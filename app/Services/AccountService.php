<?php

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Services\Contracts\AccountServiceContract;

class AccountService implements AccountServiceContract
{
    /**
     * @param AccountRepositoryContract $repository
     */
    public function __construct(private AccountRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(User $user): Account
    {
        return $this->repository->createWithUser($user);
    }

    /**
     * @inheritDoc
     */
    public function getByUuid(string $uuid): Account
    {
        return $this->repository->findBy('uuid', $uuid, true);
    }

    /**
     * @inheritDoc
     */
    public function deposit(Account $account, float $amount): bool
    {
        return $this->repository->deposit($account, $amount);
    }

    /**
     * @inheritDoc
     */
    public function withdraw(Account $account, float $amount): bool
    {
        return $this->repository->withdraw($account, $amount);
    }
}