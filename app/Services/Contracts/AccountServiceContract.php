<?php

namespace App\Services\Contracts;

use App\Models\Account;
use App\Models\User;

interface AccountServiceContract
{
    /**
     * @param User $user
     * @return Account
     */
    public function create(User $user): Account;
}