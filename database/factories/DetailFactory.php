<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detail>
 */
class DetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inventory' => random_int(1,4),
            'sold' => random_int(1,4),
            'size' => fake() -> randomElement(['XL', 'L', 'S', 'M']),
            'color' => fake() -> randomElement(['black', 'blue', 'white', 'red']),
        ];
    }
}
