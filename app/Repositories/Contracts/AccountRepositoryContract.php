<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use App\Models\User;

interface AccountRepositoryContract extends BaseRepositoryContract
{
    /**
     * @param User $user
     * @return Account
     */
    public function createWithUser(User $user): Account;
}