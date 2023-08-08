<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryContract;
use App\Services\Contracts\TransactionServiceContract;

class TransactionService implements TransactionServiceContract
{
    /**
     * @param TransactionRepositoryContract $repository
     */
    public function __construct(private TransactionRepositoryContract $repository)
    { }
}