<?php
declare(strict_types=1);

namespace App\Contracts;

interface EmailProvider
{
    /**
     * Sends an email. Supports a single email string or an array of recipients.
     *
     * @param string|array $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function send(string|array $to, string $subject, string $body): bool;
}