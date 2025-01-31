<?php

namespace Database\Factories;

use App\Models\Brand;
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
            'name' => $this->faker->name,
            'reference' => $this->faker->word,
            'quantity_box' => $this->faker->randomNumber(2),
            'quantity_pack' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomFloat(2, 0, 999),
            'purchase_price' => $this->faker->randomFloat(2, 0, 999),
            'brand_id' => Brand::first()->id,
        ];
    }
}
