<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Filesystem\Filesystem;

/**
 * Register Controller
 *
 * @property \App\Model\Table\RegistersTable $Registers
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\OfficesTable $Offices
 * @property \App\Model\Table\DistrictsTable $Districts
 * @property \App\Model\Table\StatesTable $States
 */
class RegisterController extends AppController 
{
    // Declare properties to stop "Undefined Property" warnings in VS Code
    protected $Registers;
    protected $Users;
    protected $Offices;
    protected $Districts;
    protected $States;

    public function initialize(): void
    {
        parent::initialize();
        
        // Load Tables
        $this->Registers = $this->fetchTable('Registers');
        $this->Users = $this->fetchTable('Users');
        $this->Offices = $this->fetchTable('Offices');
        $this->Districts = $this->fetchTable('Districts');
        $this->States = $this->fetchTable('States');

        $this->loadComponent('Flash');
    }

    /**
     * AJAX method to fetch districts based on state selection
     */
    public function getDistrictsByState($stateId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);

        if (!is_numeric($stateId)) {
            $response = ['error' => 'Invalid State ID'];
        } else {
            $districts = $this->Districts->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])
            ->where(['state_id' => (int)$stateId])
            ->order(['name' => 'ASC'])
            ->toArray();

            $response = ['districts' => $districts];
        }

        $this->viewBuilder()->setClassName('Json');
        $this->set(compact('response'));
        $this->viewBuilder()->setOption('serialize', ['response']);
    }

    /**
     * Password Hashing Helper
     */
    public function hashPasswordWithSalt($password, $salt, $iterations = 10000)
    {
        $toHash = $password . $salt;
        for ($i = 0; $i < $iterations; $i++) {
            $toHash = hash('sha512', $toHash);
        }
        return $toHash;
    }

    /**
     * Multi-step Registration Logic
     */
/**
 * Multi-step Registration Logic with OTP Verification Gate
 */
    public function register($step = 1)
    {
        $this->viewBuilder()->setLayout('register');
        $session = $this->request->getSession();
        $formData = $session->read('RegistrationData') ?? [];

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // --- Step 3: Final Submission & File Handling ---
            if ($step == 3) {
                
                // 1. OTP SECURITY CHECK
                // Ensure the mobile was verified in the previous step (UsersController::verifyRegisterOtp)
                $isVerified = $session->read('Register.mobile_verified');
                
                // Allow bypass ONLY if CakePHP debug mode is ON (for your local testing)
                if (!\Cake\Core\Configure::read('debug') && !$isVerified) {
                    $this->Flash->error('⚠️ Please verify your mobile number via OTP before completing registration.');
                    return $this->redirect(['action' => 'register', 2]);
                }

                // 2. FILE UPLOAD HANDLING
                $uploadDir = WWW_ROOT . 'uploads/registration-docs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                $fileFields = ['file_other', 'file_company', 'file_gst', 'file_pan', 'file_idproof'];
                foreach ($fileFields as $field) {
                    $file = $data[$field] ?? null;
                    if ($file && method_exists($file, 'getError') && $file->getError() === UPLOAD_ERR_OK) {
                        $orig = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientFilename());
                        $filename = Text::uuid() . '-' . $orig;
                        $file->moveTo($uploadDir . $filename);
                        $data[$field] = 'uploads/registration-docs/' . $filename;
                    } else {
                        unset($data[$field]);
                    }
                }
            }

            // Merge current step data into session
            $formData = array_merge($formData, $data);

            // Determine Role based on Registration Type
            if (!empty($formData['registration_type'])) {
                // Roles: 1=Admin, 2=Front/Individual, 3=Office
                if ($formData['registration_type'] === 'Individual' || $formData['registration_type'] === 'Organization') {
                    $formData['role'] = 2; 
                } else {
                    $formData['role'] = 3; 
                }
            }

            $session->write('RegistrationData', $formData);

            // --- Step Navigation & Final Save ---
            if ($step < 3) {
                return $this->redirect(['action' => 'register', $step + 1]);
            } elseif ($step == 3) {
                
                // A. DUPLICATE EMAIL CHECK
                $existingUser = $this->Users->find()
                    ->where(['OR' => [['email' => $formData['email']], ['username' => $formData['email']]]])
                    ->first();

                if ($existingUser) {
                    $this->Flash->error('❌ This email is already registered. Please login or use a different email.');
                    return $this->redirect(['action' => 'register', 1]);
                }

                // B. SAVE PROCESS (Registers -> Users -> Offices)
                $registerEntity = $this->Registers->newEntity($formData);
                
                if ($this->Registers->save($registerEntity)) {
                    
                    // 1. Create User Entity
                    $salt = bin2hex(random_bytes(16));
                    $hashedPassword = $this->hashPasswordWithSalt($formData['password'], $salt);

                    $userEntity = $this->Users->newEmptyEntity();
                    $userEntity->email = $formData['email'];
                    $userEntity->username = $formData['email']; 
                    $userEntity->password = md5($formData['password']); // Legacy support
                    $userEntity->password_hash = $hashedPassword;
                    $userEntity->salt = $salt;
                    $userEntity->status = 1;
                    $userEntity->role = $formData['role'];
                    $userEntity->created = date('Y-m-d H:i:s');

                    if ($this->Users->save($userEntity)) {
                        // Link Register record to User
                        $registerEntity->user_id = $userEntity->id;
                        $this->Registers->save($registerEntity);

                        // 2. Create Office Record
                        $officeEntity = $this->Offices->newEmptyEntity();
                        $officeEntity->user_id = $userEntity->id;
                        $officeEntity->name = $formData['firm_name'] ?? ($formData['first_name'] . ' ' . $formData['last_name']);
                        $officeEntity->email = $formData['email'];
                        $officeEntity->district_id = (int)($formData['district_id'] ?? 0);
                        $officeEntity->state_id = (int)($formData['state_id'] ?? 0);
                        $officeEntity->officer_name = $formData['first_name'] . ' ' . $formData['last_name'];
                        $officeEntity->officer_designation = $formData['registration_type'];
                        
                        $this->Offices->save($officeEntity);

                        // SUCCESS CLEANUP
                        $this->Flash->success('🎉 Registration completed successfully!');
                        
                        // Clear both Registration data and OTP session flags
                        $session->delete('RegistrationData');
                        $session->delete('Register'); 
                        
                        $this->set('registrationCompleted', true);
                    } else {
                        $this->Flash->error('⚠️ Registration failed: User account could not be created.');
                    }
                } else {
                    $this->Flash->error('❌ Failed to save registration data. Please check for errors.');
                }
            }
        }

        // --- View Variable Preparation ---
        
        // Fetch states for the dropdown (Step 2)
        $states = $this->States->find('list', [
            'keyField' => 'id', 
            'valueField' => 'name'
        ])->order(['name' => 'ASC'])->toArray();

        $registrationType = $formData['registration_type'] ?? '';
        
        $this->set(compact('states', 'formData', 'step', 'registrationType'));
    }
}