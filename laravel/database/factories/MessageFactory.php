<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "subject" => $this->faker->sentence(4),
            "text" => $this->faker->text,
            "name" => $this->faker->firstName . " " . $this->faker->lastName,
            "phone" => $this->faker->phoneNumber,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
