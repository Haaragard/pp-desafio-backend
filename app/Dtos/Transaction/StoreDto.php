<?php

namespace App\Dtos\Transaction;

use App\Dtos\BaseDto;
use App\Rules\HasEnoughBalance;

class StoreDto extends BaseDto
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'payee' => [
                'uuid',
                'exists:accounts,uuid',
            ],
            'amount' => [
                'numeric',
                'min:1',
                'max:100000000',
                new HasEnoughBalance,
            ],
        ];
    }

    /**
     * @var array
     */
    protected static array $attributes = [
        'payee',
        'amount',
    ];

    /**
     * @param string $cpf
     */
    public function __construct(
        public readonly string $payee,
        public readonly float $amount
    ) { }
}