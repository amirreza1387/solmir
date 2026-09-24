<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->company(),
            'content' => fake()->paragraph(),
            'avatar' => null,
            'rating' => fake()->numberBetween(4, 5),
            'is_active' => true,
        ];
    }
}
