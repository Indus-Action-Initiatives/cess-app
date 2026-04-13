<?php
namespace App\Contracts;

interface SMSProvider
{
    /**
     * @param string $mobile Target phone number
     * @param string $templateId The vendor-specific template ID
     * @param array $data Key-value pairs for template variables (e.g., ['otp' => '123456'])
     */
    public function send(string $mobile, string $templateId, array $data): bool;
}