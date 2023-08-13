<?php

namespace Tests\Feature\Person;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'api.v1.person.create';

    /**
     * @test
     */
    public function test_can_create_new_person_with_valid_data(): void
    {
        //Arrange
        $payload = $this->createPersonData();

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(User::class, [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);

        $this->assertDatabaseHas(Person::class, [
            'cpf' => $payload['cpf'],
        ]);
    }

    /**
     * @test
     */
    public function test_can_not_create_new_person_already_existent_email(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createPersonData();
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
    public function test_can_not_create_new_person_already_existent_phone(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createPersonData();
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
    public function test_can_not_create_new_person_already_existent_cpf(): void
    {
        //Arrange
        $user = $this->createPersonUser();
        $payload = $this->createPersonData();
        $payload['cpf'] = $user->userable->cpf;

        //Act
        $response = $this->postJson(route(self::ROUTE), $payload);

        //Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment(['message' => 'The cpf has already been taken.']);
        $response->assertJsonStructure([
            'message',
            'errors' => ['cpf'],
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
     * @return array
     */
    private function createPersonData(): array
    {
        $person = Person::factory()->makeOne();
        $user = User::factory()->makeOne();

        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => '12345678',
            'cpf' => $person->cpf,
        ];
    }
}
