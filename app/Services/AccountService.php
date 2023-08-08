<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Services\Contracts\AccountServiceContract;

class AccountService implements AccountServiceContract
{
    /**
     * @param AccountRepositoryContract $repository
     */
    public function __construct(private AccountRepositoryContract $repository)
    { }
}