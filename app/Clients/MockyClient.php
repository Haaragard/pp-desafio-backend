<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class MockyClient extends Client
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => config('services.mocky.domain'),
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }
}