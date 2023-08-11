<?php

namespace App\Listeners;

use App\Events\TransactionReproved;
use App\Services\Contracts\AccountServiceContract;
use App\Services\Contracts\TransactionServiceContract;
use Illuminate\Support\Facades\DB;

class ReproveTransaction
{
    /**
     * Create the event listener.
     * 
     * @param TransactionServiceContract $transactionService
     * @param AccountServiceContract $accountService
     */
    public function __construct(
        private readonly TransactionServiceContract $transactionService,
        private readonly AccountServiceContract $accountService
    ) { }

    /**
     * Handle the event.
     */
    public function handle(TransactionReproved $event): void
    {
        $transaction = $event->transaction;

        DB::transaction(function () use (&$transaction) {
            $this->transactionService->reprove($transaction);
            $this->accountService->deposit(
                $transaction->payer,
                $transaction->amount_float
            );
        });
    }
}
