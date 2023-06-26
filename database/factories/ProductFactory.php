<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1,6),
            'description' => fake()->text(),
            'price'       => fake()->numberBetween(10,1000),
            'discount'    => fake()->numberBetween(1,100), 
            'quantity'    => fake()->numberBetween(1,10), 
            'product_image_path' => fake()->image(),
        ];
    }

    
}
