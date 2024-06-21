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
            'first_name' => fake() -> firstName(),
            'last_name' => fake() -> lastName(),
            'phone_number' => fake() -> phoneNumber(),
            'amount_owe' => fake() -> randomElement([0, random_int(0,10000)]),
        ];
    }
}
