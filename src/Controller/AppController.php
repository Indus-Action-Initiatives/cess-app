<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\ForbiddenException; // This fixes the ForbiddenException error
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * @property \App\Model\Table\UserSessionsTable $UserSessions
 */
class AppController extends Controller
{
    /**
     * @var \Cake\ORM\Table
     */
    protected $UserSessions;

    /**
     * Initialization hook method.
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        // Initialize UserSessions table
        $this->UserSessions = TableRegistry::getTableLocator()->get('UserSessions');

        // Validate session data 
        $session = $this->getRequest()->getSession();
        $identity = $session->read('login');

        if ($identity === 'yes') {
            $sessionToken = $session->read('Auth.User.session_token');
            $userId = $session->read('Auth.User.users_id');

            $currentAgent = $this->request->getEnv('HTTP_USER_AGENT');
            $currentIp = $this->request->getEnv('REMOTE_ADDR');

            $userAgent = $session->read('Auth.User.user_agent');
            $sessionId = $session->read('Auth.User.session_id');
            $ipAddress = $session->read('Auth.User.ip_address');

            // 1. Physical session validation
            if ($sessionId !== session_id() || $userAgent !== $currentAgent || $ipAddress !== $currentIp) {
                if ($userId) {
                    $this->UserSessions->deleteAll(['user_id' => $userId]);
                }
                $session->destroy();
                $this->redirect('/users');
                return;
            }

            // 2. Database session validation (Fixes the 'null' crash)
            $validSession = null;
            if ($userId && $sessionToken) {
                $validSession = $this->UserSessions->find()
                    ->where(['user_id' => $userId, 'session_token' => $sessionToken])
                    ->first();
            }

            if (!$validSession) {
                if ($userId) {
                    $this->UserSessions->deleteAll(['user_id' => $userId]);
                }
                $session->destroy();
                $this->redirect('/users');
                return;
            }

            /* HTML Injection / XSS Check */
            if ($this->request->getData()) {
                if ($this->validateNoHtmlInjectionAll($this->request->getData())) {
                    throw new ForbiddenException('Access denied');
                }
            }
        }
    }

    public function checkAdministrator()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->check("administrator")) {
            return $this->redirect('/users');
        }
    }

    public function checkFrontUser()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->check("front")) {
            return $this->redirect('/users');
        }
    }

    public function checkOffice()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->check("office")) {
            return $this->redirect('/users');
        }
    }

    public function checkSuperUser()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->check("super")) {
            return $this->redirect('/users');
        }
    }

    /**
     * check validation for XSS scripting
     */
    protected function validateNoHtmlInjectionAll($input)
    {
        $status = false;

        if (is_array($input)) {
            foreach ($input as $key => $value) {
                // Skip file uploads
                if (!in_array($key, ['file', 'file2', 'file3', 'image', 'image1', 'userImage3', 'userImage4'])) {
                    if (is_array($value)) {
                        foreach ($value as $value1) {
                            if (is_string($value1) && preg_match('/<[^>]*>?|<script\b[^>]*>?|<iframe\b[^>]*>?/i', $value1)) {
                                $status = true;
                                break 2;
                            }
                        }
                    } else {
                        if (is_string($value) && preg_match('/<[^>]*>?|<script\b[^>]*>?|<iframe\b[^>]*>?/i', $value)) {
                            $status = true;
                            break;
                        }
                    }
                }
            }
        } else {
            if (is_string($input) && preg_match('/<[^>]*>?|<script\b[^>]*>?|<iframe\b[^>]*>?/i', $input)) {
                $status = true;
            }
        }

        return $status;
    }
}