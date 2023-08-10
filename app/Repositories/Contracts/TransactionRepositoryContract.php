<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use App\Models\Transaction;

interface TransactionRepositoryContract extends BaseRepositoryContract
{
    /**
     * @param Account $payer
     * @param Account $payee
     * @param float $amount
     * @return Transaction
     */
    public function createTransaction(Account $payer, Account $payee, float $amount): Transaction;
}