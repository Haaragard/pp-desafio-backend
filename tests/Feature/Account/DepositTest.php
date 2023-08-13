<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class DepositTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'api.v1.account.deposit';

    /**
     * @test
     */
    public function test_can_deposit_for_person_account(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToDeposit = 100;
        $payload = $this->mountPayload($amountToDeposit);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $actualBalance += $amountToDeposit;
        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_deposit_for_company_account(): void
    {
        //Arrange
        $user = $this->createCompanyUser();
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToDeposit = 100;
        $payload = $this->mountPayload($amountToDeposit);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $actualBalance += $amountToDeposit;
        $this->assertDatabaseHas(Account::class, [
            'id' => $user->account->id,
            'balance' => $actualBalance * 100,
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_deposit_with_amount_value_less_than_one(): void
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
    public function test_can_not_deposit_with_amount_value_more_than_one_hundred_thousand_thousand_and_one(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $this->actingAs($user);
        $actualBalance = $user->account->balance_float;
        $amountToDeposit = 100000001;
        $payload = $this->mountPayload($amountToDeposit);

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
    public function test_can_not_deposit_without_auth(): void
    {
        //Arrange
        $payload = $this->mountPayload();

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return User
     */
    private function createPersonUser(): User
    {
        return User::factory()
            ->for(Person::factory(), 'userable')
            ->has(Account::factory(), 'account')
            ->create();
    }

    /**
     * @return User
     */
    private function createCompanyUser(): User
    {
        return User::factory()
            ->for(Company::factory(), 'userable')
            ->has(Account::factory(), 'account')
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
