<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake() -> realText(1500),
            'brand' => fake() -> name(),
            'vendor' => fake() -> name(),
            'initPrice' => fake() -> randomFloat(nbMaxDecimals:2,min:0,max:300),
        ];
    }
}