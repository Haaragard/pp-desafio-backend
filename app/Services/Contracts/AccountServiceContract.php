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

    /**
     * @param string $uuid
     * @return Account
     */
    public function getByUuid(string $uuid): Account;

    /**
     * @param Account $account
     * @param float $amount
     * @return bool
     */
    public function deposit(Account $account, float $amount): bool;

    /**
     * @param Account $account
     * @param float $amount
     * @return bool
     */
    public function withdraw(Account $account, float $amount): bool;
}