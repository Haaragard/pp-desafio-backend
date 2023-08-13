<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'api.v1.company.create';

    /**
     * @test
     */
    public function test_can_create_new_company_with_valid_data(): void
    {
        //Arrange
        $payload = $this->createCompanyData();

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(User::class, [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);

        $this->assertDatabaseHas(Company::class, [
            'cnpj' => $payload['cnpj'],
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_company_already_existent_email(): void
    {
        //Arrange
        $user = $this->createCompanyUser();
        $payload = $this->createCompanyData();
        $payload['email'] = $user->email;

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The email has already been taken.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['email'],
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_company_already_existent_phone(): void
    {
        //Arrange
        $user = $this->createCompanyUser();
        $payload = $this->createCompanyData();
        $payload['phone'] = $user->phone;

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The phone has already been taken.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['phone'],
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_company_already_existent_cnpj(): void
    {
        //Arrange
        $user = $this->createCompanyUser();
        $payload = $this->createCompanyData();
        $payload['cnpj'] = $user->userable->cnpj;

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The cnpj has already been taken.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['cnpj'],
        ]);
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
     * @return array
     */
    private function createCompanyData(): array
    {
        $company = Company::factory()->makeOne();
        $user = User::factory()->makeOne();

        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => '12345678',
            'cnpj' => $company->cnpj,
        ];
    }
}
