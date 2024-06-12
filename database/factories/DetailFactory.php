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
            'inventory' => fake() -> numberBetween(int1:1, int2:1000),
            'sold' => fake() -> numberBetween(int1:1, int2:1000),
            'size' => fake() -> randomElement(['XL', 'L', 'S', 'M']),
            'color' => fake() -> randomElement(['black', 'blue', 'white', 'red']),
        ];
    }
}
