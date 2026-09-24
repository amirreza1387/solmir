<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PortfolioFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 1000),
            'description' => fake()->paragraph(),
            'client_name' => fake()->company(),
            'category' => fake()->randomElement(['Web Design', 'UI/UX', 'Mobile App', 'Branding']),
            'image' => null,
            'url' => fake()->url(),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
