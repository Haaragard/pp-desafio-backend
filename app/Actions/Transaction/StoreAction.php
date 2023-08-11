<?php

namespace App\Actions\Transaction;

use App\Actions\Account\WithdrawAction;
use App\Actions\Traits\AuthUtilities;
use App\Dtos\Account\WithdrawDto;
use App\Dtos\Transaction\StoreDto;
use App\Jobs\ApproveTransactionJob;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\Contracts\AccountServiceContract;
use App\Services\Contracts\TransactionServiceContract;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    use AuthUtilities;

    /**
     * @param TransactionServiceContract $service
     * @param AccountServiceContract $accountService
     * @param WithdrawAction $withdrawAction
     */
    public function __construct(
        private readonly TransactionServiceContract $service,
        private readonly AccountServiceContract $accountService,
        private readonly WithdrawAction $withdrawAction
    ) { }

    /**
     * @param StoreDto $dto
     * @return Transaction
     */
    public function execute(StoreDto $dto): Transaction
    {
        $account = $this->getAccount();

        $targetAccount = $this->findAccount($dto->payee);

        $transaction = DB::transaction(function () use (&$account, &$targetAccount, &$dto) {
            $this->withdraw($dto);
            $transaction = $this->createTransaction($account, $targetAccount, $dto->amount);

            return $transaction;
        });

        ApproveTransactionJob::dispatch($transaction);

        return $transaction;
    }

    /**
     * @param string $uuid
     * @return Account
     */
    private function findAccount(string $uuid): Account
    {
        return $this->accountService->getByUuid($uuid);
    }

    /**
     * @param Account $payer
     * @param Account $payee
     * @param float $amount
     * @return Transaction
     */
    private function createTransaction(Account $payer, Account $payee, float $amount): Transaction
    {
        return $this->service->create($payer, $payee, $amount);
    }

    /**
     * @param StoreDto $dto
     * @return void
     */
    private function withdraw(StoreDto $dto): void
    {
        $withdrawDto = new WithdrawDto($dto->amount);
        $this->withdrawAction->execute($withdrawDto);
    }
}