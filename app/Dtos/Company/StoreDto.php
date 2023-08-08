<?php

namespace App\Dtos\Company;

use App\Dtos\BaseDto;

class StoreDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = ['cnpj' => ['numeric', 'max:255']];

    /**
     * @param string $cnpj
     */
    public function __construct(public string $cnpj)
    { }
}