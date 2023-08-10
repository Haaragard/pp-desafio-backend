<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryContract;

class TransactionRepository extends BaseRepository implements TransactionRepositoryContract
{
    /**
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @param Account $payer
     * @param Account $payee
     * @param float $amount
     * @return Transaction
     */
    public function createTransaction(Account $payer, Account $payee, float $amount): Transaction
    {
        /**
         * @var Transaction
         */
        $transaction = new $this->model;

        $transaction->payer()->associate($payer);
        $transaction->payee()->associate($payee);
        $transaction->amount = (int) ($amount * 100);
        $transaction->save();

        return $transaction;
    }
}