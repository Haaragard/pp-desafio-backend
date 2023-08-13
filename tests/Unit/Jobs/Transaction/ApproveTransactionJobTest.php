<?php

namespace Tests\Unit\Jobs\Transaction;

use App\Jobs\ApproveTransactionJob;
use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Contracts\MockyServiceContract;
use App\Services\MockyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        ]);
    }

    /**
     * @test
     */
    public function test_can_approve_transaction_from_person_to_company(): void
    {
        //Arrange
        Queue::fake();
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
        ]);
    }

    /**
     * @test
     */
    public function test_can_reprove_transaction_from_person_to_person(): void
    {
        //Arrange
        Queue::fake();
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

        $userBalance += $amountToTransfer;

        //Assert
        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
            'reproved_at' => now(),
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

        $userBalance += $amountToTransfer;

        //Assert
        $this->assertDatabaseHas(Transaction::class, [
            'id' => $transaction->id,
            'payer_id' => $userPerson->account->id,
            'payee_id' => $secondUserPerson->account->id,
            'amount' => ($amountToTransfer * 100),
            'reproved_at' => now(),
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

    // /**
    //  * @test
    //  */
    // public function test_can_create_transaction_from_person_to_company(): void
    // {
    //     //Arrange
    //     $userPerson = $this->createPersonUser(1000);
    //     $userCompanyBalance = 1000;
    //     $userCompany = $this->createPersonUser($userCompanyBalance);
    //     $amountToTransfer = 100;
    //     $payload = $this->createTransferenceData($userCompany, $amountToTransfer);

    //     //Act
    //     $this->actingAs($userPerson);
    //     $response = $this->postJson(route(self::ROUTE), $payload);

    //     //Assert
    //     $response->assertStatus(Response::HTTP_CREATED);
    //     $response->assertJsonStructure(['token']);
    // }

    // /**
    //  * @test
    //  */
    // public function test_can_create_new_token_for_existing_company_user(): void
    // {
    //     //Arrange
    //     $user = $this->createCompanyUser();
    //     $payload = $this->createTransferenceData($user);

    //     //Act
    //     $response = $this->postJson(route(self::ROUTE), $payload);

    //     //Assert
    //     $response->assertStatus(Response::HTTP_CREATED);
    //     $response->assertJsonStructure(['token']);
    // }

    // /**
    //  * @test
    //  */
    // public function test_can_not_create_new_token_for_not_matching_password(): void
    // {
    //     //Arrange
    //     $user = $this->createPersonUser();
    //     $payload = $this->createTransferenceData($user);
    //     $payload['password'] = 'not_matching_password';

    //     //Act
    //     $response = $this->postJson(route(self::ROUTE), $payload);

    //     //Assert
    //     $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    //     $response->assertJsonFragment(['message' => 'Credentials does not match.']);
    //     $response->assertJsonStructure(['message']);
    // }

    // /**
    //  * @test
    //  */
    // public function test_can_not_create_new_token_for_non_existent_user_with_given_email(): void
    // {
    //     //Arrange
    //     $user = $this->createPersonUser();
    //     $payload = $this->createTransferenceData($user);
    //     $payload['email'] = 'non_existent_email@test.test';

    //     //Act
    //     $response = $this->postJson(route(self::ROUTE), $payload);

    //     //Assert
    //     $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    //     $response->assertJsonFragment(['message' => 'The selected email is invalid.']);
    //     $response->assertJsonStructure([
    //         'message',
    //         'errors' => ['email'],
    //     ]);
    // }

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
