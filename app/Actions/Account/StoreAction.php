<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\User;
use App\Services\Contracts\AccountServiceContract;

class StoreAction
{
    /**
     * @param AccountServiceContract $service
     */
    public function __construct(private AccountServiceContract $service)
    { }

    /**
     * @param User $user
     * @return Account
     */
    public function execute(User $user): Account
    {
        return $this->service->create($user);
    }
}