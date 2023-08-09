<?php

namespace App\Actions\Traits;

use App\Actions\Account\StoreAction;
use App\Models\Account;
use App\Models\User;

trait CreateAccountFromUser
{
    /**
     * @var StoreAction
     */
    private StoreAction $storeAccountAction;

    /**
     * @param User $user
     * @return Account
     */
    private function createAccount(User $user): Account
    {
        return $this->storeAccountAction->execute($user);
    }
}