<?php

namespace Tests\Unit\Jobs\Transaction;

use App\Events\TransactionApproved;
use App\Events\TransactionReproved;
use App\Jobs\ApproveTransactionJob;
use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Contracts\MockyServiceContract;
use App\Services\MockyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ApproveTransactionJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_can_approve_transaction_from_person_to_person(): void
    {
        //Arrange
        Queue::fake();
        Event::fake([TransactionApproved::class]);
        $this->mockMockyService();
        $mockyService = app(MockyServiceContract::class);

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

        //Act
        $this->freezeTime();
        $job = new ApproveTransactionJob($transaction);
        $job->handle($mockyService);

        //Assert
        Event::assertDispatched(TransactionApproved::class);

        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $userPerson->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUserPerson->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);
    }

    /**
     * @test
     */
    public function test_can_approve_transaction_from_person_to_company(): void
    {
        //Arrange
        Queue::fake();
        Event::fake([TransactionApproved::class]);
        $this->mockMockyService();
        $mockyService = app(MockyServiceContract::class);

        $userBalance = 1000;
        $userPerson = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUserPerson = $this->createCompanyUser($secondUserBalance);

        $amountToTransfer = 100;
        $transaction = $this->createTransaction(
            $userPerson->account,
            $secondUserPerson->account,
            $amountToTransfer
        );

        //Act
        $this->freezeTime();
        $job = new ApproveTransactionJob($transaction);
        $job->handle($mockyService);

        //Assert
        Event::assertDispatched(TransactionApproved::class);

        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $userPerson->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUserPerson->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);
    }

    /**
     * @test
     */
    public function test_can_reprove_transaction_from_person_to_person(): void
    {
        //Arrange
        Queue::fake();
        Event::fake([TransactionReproved::class]);
        $this->mockMockyService(false);
        $mockyService = app(MockyServiceContract::class);

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

        //Act
        $this->freezeTime();
        $job = new ApproveTransactionJob($transaction);
        $job->handle($mockyService);

        //Assert
        Event::assertDispatched(TransactionReproved::class);

        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $userPerson->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUserPerson->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);
    }

    /**
     * @test
     */
    public function test_can_reprove_transaction_from_person_to_company(): void
    {
        //Arrange
        Queue::fake();
        Event::fake([TransactionReproved::class]);
        $this->mockMockyService(false);
        $mockyService = app(MockyServiceContract::class);

        $userBalance = 1000;
        $userPerson = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUserPerson = $this->createCompanyUser($secondUserBalance);

        $amountToTransfer = 100;
        $transaction = $this->createTransaction(
            $userPerson->account,
            $secondUserPerson->account,
            $amountToTransfer
        );

        //Act
        $this->freezeTime();
        $job = new ApproveTransactionJob($transaction);
        $job->handle($mockyService);

        //Assert
        Event::assertDispatched(TransactionReproved::class);

        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $userPerson->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUserPerson->account->id,
            'balance' => ($secondUserBalance * 100),
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
     * @param int $balance
     * @return User
     */
    private function createCompanyUser(int $balance = 0): User
    {
        $account = Account::factory()->withBalance($balance);

        return User::factory()
            ->for(Company::factory(), 'userable')
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
     * @param bool $success
     * @return void
     */
    private function mockMockyService(bool $success = true): void
    {
        /**
         * @var MockObject
         */
        $mock = $this->createMock(MockyService::class);
        $mock->method('transactionIsAuthorized')
            ->willReturn($success);

        $this->app->instance(
            MockyServiceContract::class,
            $mock
        );
    }
}
