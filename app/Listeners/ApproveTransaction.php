<?php

namespace App\Listeners;

use App\Events\TransactionApproved;
use App\Services\Contracts\AccountServiceContract;
use App\Services\Contracts\TransactionServiceContract;
use Illuminate\Support\Facades\DB;

class ApproveTransaction
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
    public function handle(TransactionApproved $event): void
    {
        $transaction = $event->transaction;

        DB::transaction(function () use (&$transaction) {
            $this->transactionService->approve($transaction);
            $this->accountService->deposit(
                $transaction->payee,
                $transaction->amount_float
            );
        });
    }
}
