<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

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
    public function definition()
    {
        return [
            "name" => $this->faker->sentence(2),
            "description" => $this->faker->text,
            "price" => random_int(50, 3000),
            "count" => random_int(100, 10000) . "г.",
            "category_id" => Category::get()->random()->id,
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
