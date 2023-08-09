<?php

namespace App\Dtos\Account;

use App\Dtos\BaseDto;

class DepositDto extends BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [
        'account' => [
            'uuid',
            'exists:accounts,uuid',
        ],
        'amount' => [
            'numeric',
            'max:100000000',
        ],
    ];

    /**
     * @var array
     */
    protected static array $attributes = [
        'account',
        'amount',
    ];

    /**
     * @param string $cnpj
     */
    public function __construct(
        public string $account,
        public float $amount
    ) { }
}