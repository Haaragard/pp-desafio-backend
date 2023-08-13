<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class WiremockClient extends Client
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => config('services.wiremock.domain'),
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Token' => config('services.wiremock.token'),
            ],
        ]);
    }
}