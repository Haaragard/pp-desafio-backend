<?php

namespace App\Actions\Account;

use App\Actions\Traits\AuthUtilities;
use App\Dtos\Account\DepositDto;
use App\Services\Contracts\AccountServiceContract;

class DepositAction
{
    use AuthUtilities;

    /**
     * @param AccountServiceContract $service
     */
    public function __construct(private AccountServiceContract $service)
    { }

    /**
     * @param DepositDto $dto
     * @return bool
     */
    public function execute(DepositDto $dto): bool
    {
        $account = $this->getAccount();

        return $this->service->deposit($account, $dto->amount);
    }
}