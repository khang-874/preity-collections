<?php

namespace Database\Factories;

use App\Models\Vendor;
use Mmo\Faker\PicsumProvider;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'vendor_id' => Vendor::factory(),
            'name' => fake()->name(),
            'description' => fake() -> realText(1500),
            'weight' => fake() -> randomFloat(),
            'initPrice' => fake() -> randomFloat(nbMaxDecimals:2,min:0,max:300),
        ];
    }
}