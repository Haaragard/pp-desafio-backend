<?php

namespace App\Dtos\Person;

use App\Dtos\BaseDto;

class StoreDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [
        'cpf' => [
            'numeric',
            'digits:11',
            'unique:people,cpf',
        ],
    ];

    /**
     * @var array
     */
    protected static array $attributes = [
        'cpf',
    ];

    /**
     * @param string $cpf
     */
    public function __construct(public string $cpf)
    { }
}