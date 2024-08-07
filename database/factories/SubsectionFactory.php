<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subsection>
 */
class SubsectionFactory extends Factory
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
            'name' => fake() -> name(),
            'images' => array_map(function($element) {
                $element = fake() -> picsumUrl();
                return $element;
            }, array_fill(0, 3, '')),

        ];
    }
}
