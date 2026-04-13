<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\EmailProvider;
use Cake\Mailer\Mailer;
use Cake\Log\Log;

class GmailEmailProvider implements EmailProvider
{
    public function send(string|array $to, string $subject, string $body): bool
    {
        // Format the 'to' address for logging purposes
        $logRecipient = is_array($to) ? implode(', ', $to) : $to;

        try {
            $mailer = new Mailer('default');
            
            // setTo() natively accepts string OR array, so no changes needed here!
            $mailer->setTo($to)
                ->setSubject($subject)
                ->deliver($body);

            Log::info("Email successfully sent to {$logRecipient} via SMTP");
            return true;
        } catch (\Exception $e) {
            Log::error("SMTP Error sending to {$logRecipient}: " . $e->getMessage());
            return false;
        }
    }
}


