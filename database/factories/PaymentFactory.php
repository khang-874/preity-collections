<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'payment_type' => fake() -> randomElement(['cash', 'debit', 'credit']),
            'amount_paid' => fake() -> randomFloat(2,10, 20)
        ];
    }
}
