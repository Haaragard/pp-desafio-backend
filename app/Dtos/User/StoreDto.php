<?php

namespace App\Dtos\User;

use App\Dtos\BaseDto;
use Illuminate\Validation\Rules\Password;

class StoreDto extends BaseDto
{
    public static function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => [
                'string',
                'email',
                'unique:users,email',
            ],
            'phone' => [
                'numeric',
                'digits:11',
                'unique:users,phone',
            ],
            'password' => Password::min(8),
        ];
    }

    /**
     * @var array
     */
    protected static array $attributes = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $password
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $password
    ) { }
}