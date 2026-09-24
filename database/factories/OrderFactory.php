<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_type' => 'طراحی وب‌سایت',
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'budget_range' => '۱۰ تا ۲۰ میلیون',
            'status' => 'pending',
        ];
    }
}
