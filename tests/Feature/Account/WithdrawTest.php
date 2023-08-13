<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'api.v1.account.withdraw';

    /**
     * @test
     */
    public function test_can_withdraw_for_person_account(): void
    {
        //Arrange
        $user = $this->createPersonUser(10000);
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToWithdraw = 100;
        $payload = $this->mountPayload($amountToWithdraw);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $actualBalance -= $amountToWithdraw;
        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_withdraw_for_company_account(): void
    {
        //Arrange
        $user = $this->createCompanyUser(10000);
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToWithdraw = 100;
        $payload = $this->mountPayload($amountToWithdraw);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $actualBalance -= $amountToWithdraw;
        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_withdraw_with_balance_less_than_expected_requested_amount(): void
    {
        //Arrange
        $user = $this->createPersonUser(1000);
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToWithdraw = 2000;
        $payload = $this->mountPayload($amountToWithdraw);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'Not enough balance.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['amount'],
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_withdraw_with_amount_value_less_than_one(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $payload = $this->mountPayload();

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The amount field must be at least 1.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['amount'],
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_withdraw_with_amount_value_more_than_one_hundred_thousand_thousand_and_one(): void
    {
        //Arrange
        $user = $this->createPersonUser(100000002);
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToWithdraw = 100000001;
        $payload = $this->mountPayload($amountToWithdraw);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonFragment(['message' => 'The amount field must not be greater than 100000000.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['amount'],
        ]);

        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_withdraw_without_auth(): void
    {
        //Arrange
        $payload = $this->mountPayload();

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
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
     * @param int $amount
     * @return array
     */
    private function mountPayload(int $amount = 0): array
    {
        return [
            'amount' => $amount,
        ];
    }
}
