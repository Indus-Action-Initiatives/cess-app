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
        $testEmail = 'rudransh20septmber@gmail.com';
        
        // Initialize the service with its dependencies
        $otpService = new OtpService(
            new Msg91SMSProvider(),
            new GmailEmailProvider()
        );

        $otp = $otpService->generate();

        if ($this->request->is('post')) {
            // We call sendEmail, which returns a boolean
            if ($otpService->sendEmail($testEmail, $otp)) {
                $this->Flash->success("Success! OTP $otp sent to $testEmail");
            } else {
                $this->Flash->error("Failed to send email. Check logs/error.log for SMTP details.");
            }
        }

        $this->set(compact('testEmail', 'otp'));
    }
}