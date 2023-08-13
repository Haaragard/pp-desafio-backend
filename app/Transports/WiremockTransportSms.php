<?php

namespace App\Transports;

use App\Services\Contracts\WiremockServiceContract;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

class WiremockTransportSms extends AbstractTransport
{
    /**
     * Create a new Mailchimp transport instance.
     * 
     * @param WiremockServiceContract $service
     */
    public function __construct(protected readonly WiremockServiceContract $service)
    {
        parent::__construct();
    }
 
    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        // $email = MessageConverter::toEmail($message->getOriginalMessage());
 
        // $this->service->sendSms([
        //     RequestOptions::JSON => [
        //         'from_number' => $number->getFrom(),
        //         'to' => collect($number->getTo())->map(function (Address $number) {
        //             return ['email' => $number->getAddress(), 'type' => 'to'];
        //         })->all(),
        //         'subject' => $email->getSubject(),
        //         'text' => $email->getTextBody(),
        //     ]
        // ]);
    }
 
    /**
     * Get the string representation of the transport.
     */
    public function __toString(): string
    {
        return 'wiremock-sms';
    }
}