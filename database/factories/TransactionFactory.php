<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(0, 999999),
        ];
    }

    /**
     * @param CarbonImmutable|null $timestamp
     * @return static
     */
    public function approved(?CarbonImmutable $timestamp = null): static
    {
        return $this->state(fn (array $attributes) => [
            'approved_at' => $timestamp ?? now(),
        ]);
    }

    /**
     * @param CarbonImmutable|null $timestamp
     * @return static
     */
    public function reproved(?CarbonImmutable $timestamp = null): static
    {
        return $this->state(fn (array $attributes) => [
            'reproved_at' => $timestamp ?? now(),
        ]);
    }
}
