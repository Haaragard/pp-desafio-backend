<?php

namespace App\Jobs;

use App\Events\TransactionApproved;
use App\Events\TransactionReproved;
use App\Models\Transaction;
use App\Services\Contracts\MockyServiceContract;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApproveTransactionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     * 
     * @param Transaction $transaction
     */
    public function __construct(private readonly Transaction $transaction)
    { }

    /**
     * Execute the job.
     */
    public function handle(MockyServiceContract $mockyService): void
    {
        try {
            $transactionIsApproved = $mockyService->transactionIsAuthorized();

            if ($transactionIsApproved) {
                $this->approve();
    
                return;
            }

            $this->reprove();
        } catch (Exception $e) {
            $this->reprove();

            throw $e;
        }
    }

    /**
     * @return void
     */
    private function approve(): void
    {
        event(new TransactionApproved($this->transaction));
    }

    /**
     * @return void
     */
    private function reprove(): void
    {
        event(new TransactionReproved($this->transaction));

    }
}
