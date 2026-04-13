<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\SMSProvider;
use Cake\Http\Client;
use Cake\Log\Log;
use Cake\Core\Configure;

class Msg91SMSProvider implements SMSProvider
{
    public function send(string $mobile, string $templateId, array $data): bool
    {
        // VENDOR SPECIFIC FORMATTING: MSG91 requires the 91 prefix
        $mobile = preg_replace('/\D/', '', $mobile);
        $normalizedMobile = (strlen($mobile) === 10) ? '91' . $mobile : $mobile;

        $authKey = Configure::read('msg91.auth_key');
        $baseUrl = Configure::read('msg91.base_url');

        if (empty($authKey) || empty($baseUrl)) {
            Log::error('MSG91 configuration is missing in app_local.php');
            return false;
        }

        try {
            $http = new Client();
            
            $payload = array_merge([
                'template_id' => $templateId,
                'mobile' => $normalizedMobile,
            ], $data);

            $response = $http->post($baseUrl, json_encode($payload), [
                'headers' => [
                    'authkey' => $authKey,
                    'Content-Type' => 'application/json',
                ]
            ]);

            if ($response->isOk()) {
                Log::info("SMS sent via MSG91 to {$normalizedMobile}");
                return true;
            }

            Log::error('MSG91 SMS send failed', [
                'status' => $response->getStatusCode(),
                'response' => $response->getStringBody(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('MSG91 SMS exception: ' . $e->getMessage());
            return false;
        }
    }
}