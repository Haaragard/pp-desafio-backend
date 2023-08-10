<?php

namespace App\Dtos\Account;

use App\Dtos\BaseDto;

class DepositDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [
        'amount' => [
            'numeric',
            'max:100000000',
        ],
    ];

    /**
     * @var array
     */
    protected static array $attributes = ['amount'];

    /**
     * @param string $cnpj
     */
    public function __construct(public float $amount)
    { }
}