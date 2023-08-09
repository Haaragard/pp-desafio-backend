<?php

namespace App\Actions\Account;

use App\Dtos\Account\DepositDto;
use App\Models\Account;
use App\Services\Contracts\AccountServiceContract;

class DepositAction
{
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
        $account = $this->findAccount($dto->account);

        return $this->service->deposit($account, $dto->amount);
    }

    /**
     * @param string $uuid
     * @return Account
     */
    private function findAccount(string $uuid): Account
    {
        return $this->service->getByUuid($uuid);
    }
}