<?php

namespace App\Actions\Account;

use App\Dtos\Account\DepositDto;
use App\Models\Account;
use App\Models\User;
use App\Services\Contracts\AccountServiceContract;
use Illuminate\Support\Facades\Auth;

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
        $account = $this->getAccount();

        return $this->service->deposit($account, $dto->amount);
    }

    /**
     * @return Account
     */
    private function getAccount(): Account
    {
        /**
         * @var User
         */
        $user = Auth::user();

        return $user->account;
    }
}