<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryContract;
use App\Services\Contracts\TransactionServiceContract;

class TransactionService implements TransactionServiceContract
{
    /**
     * @param TransactionRepositoryContract $repository
     */
    public function __construct(private TransactionRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(Account $payer, Account $payee, float $amount): Transaction
    {
        return $this->repository->createTransaction(
            $payer,
            $payee,
            $amount
        );
    }

    /**
     * @inheritDoc
     */
    public function approve(Transaction $transaction): bool
    {
        return $this->repository->approve($transaction);
    }

    /**
     * @inheritDoc
     */
    public function reprove(Transaction $transaction): bool
    {
        return $this->repository->reprove($transaction);
    }
}