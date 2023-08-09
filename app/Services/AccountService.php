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
}