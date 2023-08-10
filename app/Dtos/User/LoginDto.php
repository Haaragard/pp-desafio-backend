<?php

namespace App\Dtos\User;

use App\Dtos\BaseDto;

class LoginDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [
        'email' => [
            'string',
            'email',
            'exists:users,email',
        ],
        'password' => 'string',
    ];

    /**
     * @var array
     */
    protected static array $attributes = [
        'email',
        'password',
    ];

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public string $email,
        public string $password
    ) { }
}