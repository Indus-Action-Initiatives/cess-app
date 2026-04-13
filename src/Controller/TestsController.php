<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\OtpService;
use App\Services\Msg91SMSProvider;
use App\Services\GmailEmailProvider;

class TestsController extends AppController
{
    public function testOtp()
    {
        // 1. Tell CakePHP to use a clean layout for this specific action
        $this->viewBuilder()->setLayout('ajax');

        $testEmail = 'rudransh20septmber@gmail.com';
        
        // 2. Initialize the service
        $otpService = new OtpService(
            new Msg91SMSProvider(),
            new GmailEmailProvider()
        );

        $otp = $otpService->generate();

        // 3. Handle the form submission
        if ($this->request->is('post')) {
            if ($otpService->sendEmail($testEmail, $otp)) {
                $this->Flash->success("Success! OTP $otp sent to $testEmail");
            } else {
                $this->Flash->error("Failed to send email. Check logs/error.log");
            }
        }

        // 4. Pass data to the view
        $this->set(compact('testEmail', 'otp'));
    }
}