<?php

namespace App\Dtos\Company;

use App\Dtos\BaseDto;

class StoreDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [
        'cnpj' => [
            'numeric',
            'digits:14',
            'unique:companies,cnpj',
        ],
    ];

    /**
     * @var array
     */
    protected static array $attributes = ['cnpj'];

    /**
     * @param string $cnpj
     */
    public function __construct(public string $cnpj)
    { }
}