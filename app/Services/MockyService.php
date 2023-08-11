<?php

namespace App\Services;

use App\Clients\MockyClient;
use App\Services\Contracts\MockyServiceContract;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class MockyService implements MockyServiceContract
{
    /**
     * @param MockyClient $client
     */
    public function __construct(private readonly MockyClient $client)
    { }

    /**
     * @inheritDoc
     */
    public function transactionIsAuthorized(): bool
    {
        /**
         * @var ResponseInterface
         */
        $response = $this->client->get(config('services.mocky.uri.transaction.status'));

        $data = $this->getResponseJsonData($response);

        return $this->isAuthorized($data);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function getResponseJsonData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isAuthorized(array $data): bool
    {
        return Arr::get($data, 'message') === 'Autorizado';
    }
}