<?php
declare(strict_types=1);

namespace App\Services;

class OtpService
{
    /**
     * Generates a random OTP and saves it to the session.
     */
    public function generate($session, string $context, ?string $target = null): string
    {
        $otp = (string)random_int(100000, 999999);
        $key = $this->resolveKey($context);

        // Save OTP to session
        $session->write($key, $otp);
        
        // Save target (and normalize if it's a mobile number)
        if ($target) {
            $value = ($context === 'mobile') ? $this->normalizeMobile($target) : $target;
            $session->write($key . '_target', $value);
        }

        return $otp;
    }

    /**
     * Verifies the user input against the session and cleans up.
     */
    public function verify($session, string $context, ?string $userOtp): bool
    {
        $key = $this->resolveKey($context);
        $savedOtp = $session->read($key);

        if (!empty($userOtp) && (string)$userOtp === (string)$savedOtp) {
            // SUCCESS LOGIC
            if ($context === 'email' || $context === 'mobile') {
                $session->write("Register.{$context}_verified", true);
            }
            
            // Auto-cleanup
            $session->delete($key);
            return true;
        }

        return false;
    }

    /* --- Private Helper Methods --- */

    private function resolveKey(string $context): string
    {
        return match ($context) {
            'login' => 'Temp.otp',
            'email', 'mobile' => "Register.{$context}_otp",
            default => throw new \Exception("Invalid OTP context: {$context}")
        };
    }

    private function normalizeMobile(string $mobile): string
    {
        $mobile = preg_replace('/\D/', '', $mobile);
        return (strlen($mobile) === 10) ? '91' . $mobile : $mobile;
    }
}