<?php

namespace App\Services\Contracts;

use App\Models\Account;
use App\Models\Transaction;

interface TransactionServiceContract
{
    /**
     * @param Account $payer
     * @param Account $payee
     * @param float $amount
     * @return Transaction
     */
    public function create(Account $payer, Account $payee, float $amount): Transaction;

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function approve(Transaction $transaction): bool;

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function reprove(Transaction $transaction): bool;
}