<?php

namespace Tests\Feature\User;

use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'api.v1.user.login';

    /**
     * @test
     */
    public function test_can_create_new_token_for_existing_person_user(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createLoginData($user);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function test_can_create_new_token_for_existing_company_user(): void
    {
        //Arrange
        $user = $this->createCompanyUser();
        $payload = $this->createLoginData($user);

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_token_for_not_matching_password(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createLoginData($user);
        $payload['password'] = 'not_matching_password';

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'Credentials does not match.']);
        $response->assertJsonStructure(['message']);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_token_for_non_existent_user_with_given_email(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createLoginData($user);
        $payload['email'] = 'non_existent_email@test.test';

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The selected email is invalid.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['email'],
        ]);
    }

    /**
     * @return User
     */
    private function createPersonUser(): User
    {
        return User::factory()
            ->for(Person::factory(), 'userable')
            ->create();
    }

    /**
     * @return User
     */
    private function createCompanyUser(): User
    {
        return User::factory()
            ->for(Company::factory(), 'userable')
            ->create();
    }

    /**
     * @param User $user
     * @return array
     */
    private function createLoginData(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => 'password',
        ];
    }
}
