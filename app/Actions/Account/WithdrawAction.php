<?php

namespace App\Actions\Account;

use App\Actions\Traits\AuthUtilities;
use App\Dtos\Account\WithdrawDto;
use App\Services\Contracts\AccountServiceContract;

class WithdrawAction
{
    use AuthUtilities;

    /**
     * @param AccountServiceContract $service
     */
    public function __construct(private AccountServiceContract $service)
    { }

    /**
     * @param WithdrawDto $dto
     * @return bool
     */
    public function execute(WithdrawDto $dto): bool
    {
        $account = $this->getAccount();

        return $this->service->withdraw($account, $dto->amount);
    }
}