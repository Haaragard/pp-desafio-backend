<?php

namespace App\Services\Contracts;

interface WiremockServiceContract
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $text
     * @return bool
     */
    public function sendEmail(string $from, string $to, string $subject, string $text): bool;

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $text
     * @return bool
     */
    public function sendSms(string $from, string $to, string $subject, string $text): bool;
}