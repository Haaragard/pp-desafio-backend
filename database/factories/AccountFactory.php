<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'balance' => fake()->numberBetween(0, 999999),
        ];
    }

    public function withBalance(int $balance = 0): static
    {
        $balance *= 100;

        return $this->state(function ($attributes = []) use (&$balance) {
            return [
                'balance' => $balance,
            ];
        });
    }
}
