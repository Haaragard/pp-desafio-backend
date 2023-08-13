<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mocky' => [
        'domain' => env('MOCKY_DOMAIN', 'https://run.mocky.io/'),
        'uri' => [
            'transaction' => [
                'status' => 'v3/4e55fdf3-fd5d-41c3-945f-ffa02d28d285',
            ],
        ],
    ],

    'wiremock' => [
        'domain' => env('WIREMOCK_DOMAIN', 'https://haaragard.wiremockapi.cloud/'),
        'token' => env('WIREMOCK_TOKEN', 'token'),
        'uri' => [
            'notify' => [
                'email' => 'email/notify',
                'sms' => 'sms/notify',
            ],
        ],
    ],
];
