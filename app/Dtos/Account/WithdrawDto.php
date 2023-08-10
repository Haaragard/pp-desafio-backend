<?php

namespace App\Dtos\Account;

use App\Dtos\BaseDto;
use App\Rules\HasEnoughBalance;

class WithdrawDto extends BaseDto
{
    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
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
    protected static array $attributes = ['amount'];

    /**
     * @param string $cnpj
     */
    public function __construct(public float $amount)
    { }
}