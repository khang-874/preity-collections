<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake() -> firstName(),
            'lastName' => fake() -> lastName(),
            'phoneNumber' => fake() -> phoneNumber(),
            'amountOwed' => fake() -> randomElement([0, random_int(0,10000)]),
        ];
    }
}
