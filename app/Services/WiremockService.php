<?php

namespace App\Services;

use App\Clients\WiremockClient;
use App\Services\Contracts\WiremockServiceContract;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class WiremockService implements WiremockServiceContract
{
    /**
     * @param WiremockClient $client
     */
    public function __construct(private readonly WiremockClient $client)
    { }

    /**
     * @inheritDoc
     */
    public function sendEmail(string $from, string $to, string $subject, string $text): bool
    {
        /**
         * @var ResponseInterface
         */
        $response = $this->client->post(config('services.wiremock.uri.notify.email'), [
            'json' => [
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'text' => $text,
            ],
        ]);

        $this->getResponseJsonData($response);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function sendSms(string $from, string $to, string $subject, string $text): bool
    {
        /**
         * @var ResponseInterface
         */
        $response = $this->client->post(config('services.wiremock.uri.notify.sms'), [
            'json' => [
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'text' => $text,
            ],
        ]);

        $this->getResponseJsonData($response);

        return true;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function getResponseJsonData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}