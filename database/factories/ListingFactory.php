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
            'images' => array_map(function($element) {
                $element = fake() -> picsumUrl();
                return $element;
            }, array_fill(0, 3, '')), 
            'init_price' => fake() -> randomFloat(nbMaxDecimals:2,min:0,max:300),
            'sale_percentage' => fake() -> randomElement([0, (rand() / getrandmax()) * 100]),
            'is_clearance' => fake() -> randomElement([true, false])
        ];
    }
}