<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Http\Response;
use Cake\Utility\Security;
use Cake\Log\Log;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\UserSessionsTable $UserSessions
 * @property \App\Model\Table\OfficesTable $Offices
 */
class UsersController extends AppController
{
    /**
     * Message Templates for OTPs
     * Easily modify subjects and bodies here without hunting through functions.
     */
    private const EMAIL_MESSAGES = [
        'login' => [
            'subject' => 'Your Login Verification Code',
            'body' => 'Your secure login OTP code is: {otp}'
        ],
        'email' => [
            'subject' => 'Registration OTP',
            'body' => 'Your registration code is: {otp}'
        ]
    ];

    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->disableAutoLayout();
        
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->UserSessions = TableRegistry::getTableLocator()->get('UserSessions');
        $this->Offices = TableRegistry::getTableLocator()->get('Offices');
    }

    /**
     * Login Landing Page & Submission
     */
    public function index()
    {
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            
            // 1. CAPTCHA Validation
            $userCaptchaAnswer = $this->request->getData('captcha_answer');
            $correctCaptcha = $session->read('Captcha.answer');
            
            if ($userCaptchaAnswer != $correctCaptcha) {
                $this->Flash->error('Incorrect CAPTCHA. Please try again.', ['params' => ['class' => 'alert alert-danger']]);
                return $this->redirect('/users');
            }

            // 2. User Lookup
            $username = trim((string)$this->request->getData('email'));
            $getUser = $this->Users->find()->where(['OR' => ['username' => $username, 'email' => $username]])->first();
            
            if (empty($getUser)) {
                $this->Flash->error('Username or password is invalid.', ['params' => ['class' => 'alert alert-danger']]);
                return $this->redirect('/users');
            }

            // 3. Password Decryption (AES-256-CBC)
            $encrypted_password = $this->request->getData('password');
            $iv = base64_decode(substr($encrypted_password, 0, 24));
            $ciphertext = base64_decode(substr($encrypted_password, 24));
            $encryption_key = hex2bin(Configure::read('SECRET_KEY'));

            $decrypted_password = openssl_decrypt($ciphertext, 'AES-256-CBC', $encryption_key, OPENSSL_RAW_DATA, $iv);
            
            // 4. Verify Credentials
            if ($this->verifyPassword($decrypted_password, $getUser['password_hash'], $getUser['salt'])) {
                if ($getUser['status'] == 0) {
                    $this->Flash->error('Your account is Inactive. Please contact the administrator.', ['params'=>['class'=>'alert alert-danger']]);
                    return $this->redirect('/users');
                }

                // 5. Role Redirection
                if ($getUser['role'] == 1) {
                    $session->write("administrator", $getUser);
                    $this->savesessiondataAll($getUser);
                    return $this->redirect('/admin/dashboard');
                } elseif ($getUser['role'] == 2) {
                    $session->write("front", $getUser);
                    $this->savesessiondataAll($getUser);
                    return $this->redirect('/front/dashboard');
                } elseif ($getUser['role'] == 3) {
                    $office = $this->Offices->find()->where(['user_id' => $getUser['id']])->contain(['Districts'])->first();
                    $getUser['office_name'] = $office->name;
                    $getUser['district_name'] = $office->district->name;
                    $getUser['officer_designation'] = $office->officer_designation;
                    $session->write("office", $getUser);
                    $this->savesessiondataAll($getUser);
                    return $this->redirect('/office/dashboard');
                }
            } else {
                $this->Flash->error('Username or password is invalid.', ['params' => ['class' => 'alert alert-danger']]);
                return $this->redirect("/users");
            }
        }
        $this->set('secret_key', Configure::read('SECRET_KEY'));
    }

    /**
     * User Registration Handling
     */
    public function register()
    {
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();

            $isEmailVerified = $session->read('Register.email_verified');
            $isMobileVerified = $session->read('Register.mobile_verified');

            // STRICT CHECK: Block submission if BOTH are not verified
            if (!$isEmailVerified || !$isMobileVerified) {
                $this->Flash->error('Security Error: You must verify both your email address and mobile number before creating an account.', ['params' => ['class' => 'alert alert-danger']]);
                return $this->redirect(['action' => 'register']);
            }

            // Proceed with normal save logic...
            $user = $this->Users->newEmptyEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            // Map the verified data securely to the correct database columns
            $user->set('email', $session->read('Register.email_target'));
            $user->set('mobile', $session->read('Register.mobile_target')); 

            if ($this->Users->save($user)) {
                // Clear all verification flags so they can't be reused
                $session->delete('Register.email_verified');
                $session->delete('Register.email_target');
                $session->delete('Register.mobile_verified');
                $session->delete('Register.mobile_target');

                $this->Flash->success('Registration successful! Please log in.', ['params' => ['class' => 'alert alert-success']]);
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error('Unable to register your account. Please try again.', ['params' => ['class' => 'alert alert-danger']]);
        }
    }

    /**
     * Password Utility Methods
     */
    public function verifyPassword($inputPassword, $storedHash, $storedSalt, $iterations = 10000)
    {
        $inputHash = $this->hashPasswordWithSalt($inputPassword, $storedSalt, $iterations);
        return $inputHash === $storedHash;
    }

    public function hashPasswordWithSalt($password, $salt, $iterations = 10000)
    {
        $toHash = $password . $salt;
        for ($i = 0; $i < $iterations; $i++) {
            $toHash = hash('sha512', $toHash);
        }
        return $toHash;
    }

    /**
     * Master OTP Generation & Sending (Consolidated)
     * Handles both 'login', 'email' (registration), and 'mobile' contexts.
     */
    public function sendOtp()
    {
        $this->request->allowMethod(['post']);
        
        // Grab context ('login', 'email', 'mobile') and target (email address or phone number)
        $context = $this->request->getData('context') ?? $this->request->getData('type') ?? 'login'; 
        $target = $this->request->getData('target') ?? $this->request->getData('email'); 
        
        $otpService = new \App\Services\OtpService();
        $session = $this->getRequest()->getSession();

        try {
            $otp = $otpService->generate($session, $context, $target);

            if (filter_var(env('DEBUG'), FILTER_VALIDATE_BOOLEAN)) {
                $success = true; 
            } else {
                if ($context === 'mobile') {
                    // Send via SMS
                    $smsClass = Configure::read('Bindings.SMSProvider');
                    $smsProvider = new $smsClass();
                    $templateId = Configure::read('msg91.template_id');
                    $success = $smsProvider->send($target, $templateId, ['otp' => $otp]);
                } else {
                    // Send via Email
                    $emailClass = Configure::read('Bindings.EmailProvider');
                    $emailProvider = new $emailClass();
                    
                    // Fetch from constant array, defaulting if somehow missing
                    $subject = self::EMAIL_MESSAGES[$context]['subject'] ?? 'Your Verification Code';
                    $bodyTemplate = self::EMAIL_MESSAGES[$context]['body'] ?? 'Your OTP is: {otp}';
                    
                    // Inject the OTP into the template string
                    $body = str_replace('{otp}', $otp, $bodyTemplate);
                    
                    $success = $emailProvider->send($target, $subject, $body);
                }
            }

            if ($success) {
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['status' => 'success', 'message' => 'OTP sent successfully.']));
            }
            throw new \Exception("Delivery failed.");
        } catch (\Exception $e) {
            Log::error("OTP Error [{$context}]: " . $e->getMessage());
            return $this->response->withStatus(500)->withType('application/json')
                ->withStringBody(json_encode(['status' => 'error', 'message' => 'Failed to send OTP.']));
        }
    }

    /**
     * Master OTP Verification (Consolidated)
     * Handles verification for all contexts.
     */
    public function verifyOtp()
    {
        $this->request->allowMethod(['post', 'ajax']);
        
        $context = $this->request->getData('context') ?? $this->request->getData('type') ?? 'login';
        $inputOtp = $this->request->getData('otp');
        
        $otpService = new \App\Services\OtpService();

        // DEBUG BYPASS: Allow 123456 if debug mode is active
        if (filter_var(env('DEBUG'), FILTER_VALIDATE_BOOLEAN) && $inputOtp === '123456') {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['status' => 'success', 'message' => ucfirst($context) . ' verified successfully (Debug Mode)!']));
        }

        if ($otpService->verify($this->getRequest()->getSession(), $context, $inputOtp)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['status' => 'success', 'message' => ucfirst($context) . ' verified successfully!']));
        }

        return $this->response->withStatus(400)->withType('application/json')
            ->withStringBody(json_encode(['status' => 'error', 'message' => 'Invalid or expired OTP code.']));
    }

    /**
     * Session Initialization Logic
     */
    public function savesessiondataAll($getUser)
    {
        $session = $this->getRequest()->getSession();
        $session->write("login", 'yes');
        $userAgent = (string)env('HTTP_USER_AGENT');
        $session->write('Auth.User.user_agent', $userAgent);
        $session->write('Auth.User.ip_address', env('REMOTE_ADDR'));
        $sessionToken = Security::hash(uniqid(), 'sha1', true);
        $session->write('Auth.User.session_token', $sessionToken);
        $session->write('Auth.User.session_id', session_id());
        $session->write('Auth.User.users_id', $getUser['id']);

        $userSession = $this->UserSessions->newEntity([
            'user_id' => $getUser['id'],
            'session_token' => $sessionToken,
            'user_agent' => $userAgent
        ]);
        return $this->UserSessions->save($userSession);
    }

    /**
     * Logout Logic
     */
    public function logout()
    {
        $session = $this->getRequest()->getSession();
        $userId = $session->read('Auth.User.users_id');
        if ($userId) {
            $this->UserSessions->deleteAll(['user_id' => $userId]);
        }
        $session->destroy();
        $this->Flash->success('logout Successfully.', ['params' => ['class' => 'alert alert-success']]);
        return $this->redirect('/users');
    }

    /**
     * CAPTCHA Image Generation - Safe Output Buffering
     */
    public function captcha()
    {
        $this->autoRender = false;
        
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $this->getRequest()->getSession()->write('Captcha.answer', $num1 + $num2);
        
        $image = imagecreatetruecolor(150, 50);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        
        imagefill($image, 0, 0, $bgColor);
        imagestring($image, 5, 30, 15, "{$num1} + {$num2} = ?", $textColor);
        
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        
        return $this->response->withType('image/png')->withStringBody($imageData);
    }
}