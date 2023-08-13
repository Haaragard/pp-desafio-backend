<?php

namespace Tests\Unit\Jobs\Transaction;

use App\Events\TransactionApproved;
use App\Listeners\ApproveTransaction;
use App\Models\Account;
use App\Models\Person;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ApproveTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_can_listen_to_transaction_approved_event(): void
    {
        Event::fake([TransactionApproved::class]);
        Event::assertListening(
            TransactionApproved::class,
            ApproveTransaction::class
        );
    }

    /**
     * @test
     */
    public function test_can_approve_transaction_from_listener(): void
    {
        //Arrange
        $userBalance = 1000;
        $userPerson = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUserPerson = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $transaction = $this->createTransaction(
            $userPerson->account,
            $secondUserPerson->account,
            $amountToTransfer
        );

        $event = $this->createTransactionApproved($transaction);
        $listener = $this->createApproveTransaction();

        //Act
        $this->freezeTime();
        $listener->handle($event);

        $secondUserBalance += $amountToTransfer;

        //Assert
        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => now(),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $userPerson->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUserPerson->account->id,
            'balance' => ($secondUserBalance * 100),
            'updated_at' => now(),
        ]);
    }

    /**
     * @param int $balance
     * @return User
     */
    private function createPersonUser(int $balance = 0): User
    {
        $account = Account::factory()->withBalance($balance);

        return User::factory()
            ->for(Person::factory(), 'userable')
            ->has($account, 'account')
            ->create();
    }

    /**
     * @param Account $payer
     * @param Account $payee
     * @param int $amount
     * @return Transaction
     */
    private function createTransaction(Account $payer, Account $payee, int $amount = 1): Transaction
    {
        /**
         * @var Transaction
         */
        $transaction = Transaction::factory()->makeOne();
        $transaction->payer()->associate($payer);
        $transaction->payee()->associate($payee);
        $transaction->amount = ($amount * 100);
        $transaction->save();

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @return TransactionApproved
     */
    private function createTransactionApproved(Transaction $transaction): TransactionApproved
    {
        return new TransactionApproved($transaction);
    }

    /**
     * @return ApproveTransaction
     */
    private function createApproveTransaction(): ApproveTransaction
    {
        return app(ApproveTransaction::class);
    }
}
