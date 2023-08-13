<?php

namespace Tests\Feature\Transaction;

use App\Jobs\ApproveTransactionJob;
use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    private const ROUTE = 'api.v1.transaction.create';

    /**
     * @test
     */
    public function test_can_create_transaction_from_person_to_person(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        $userBalance -= $amountToTransfer;

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_create_transaction_from_person_to_company(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createCompanyUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        $userBalance -= $amountToTransfer;

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_from_company_to_person(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createCompanyUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_while_unauthenticated(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_without_payee_valid_uuid(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            null,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The payee field must be a valid UUID.']);
        $response->assertJsonStructure(['message', 'errors' => ['payee']]);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_with_inexistent_payee_uuid(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);
        $secondUser->account->uuid = fake()->unique()->uuid();

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The selected payee is invalid.']);
        $response->assertJsonStructure(['message', 'errors' => ['payee']]);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_without_enough_balance(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 0;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 100;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'Not enough balance.']);
        $response->assertJsonStructure(['message', 'errors' => ['amount']]);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
    }

    /**
     * @test
     */
    public function test_can_not_create_transaction_with_requested_amount_less_than_one(): void
    {
        //Arrange
        Queue::fake();
        $userBalance = 1000;
        $user = $this->createPersonUser($userBalance);

        $secondUserBalance = 1000;
        $secondUser = $this->createPersonUser($secondUserBalance);

        $amountToTransfer = 0;
        $payload = $this->createTransferenceData(
            $secondUser->account,
            $amountToTransfer
        );

        //Act
        $this->actingAs($user);
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The amount field must be at least 1.']);
        $response->assertJsonStructure(['message', 'errors' => ['amount']]);

        $this->assertDatabaseMissing(Transaction::class, [
            'payer_id' => $user->account->id,
            'payee_id' => $secondUser->account->id,
            'amount' => ($amountToTransfer * 100),
            'approved_at' => null,
            'reproved_at' => null,
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => ($userBalance * 100),
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $secondUser->account->id,
            'balance' => ($secondUserBalance * 100),
        ]);

        Queue::assertNotPushed(ApproveTransactionJob::class);
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
     * @param Account|null $account
     * @param int $amount
     * @return array
     */
    private function createTransferenceData(?Account $account = null, int $amount = 0): array
    {
        return [
            'payee' => $account->uuid ?? '',
            'amount' => $amount,
        ];
    }
}
