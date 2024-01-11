<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
            'number' => fake()->randomDigitNotNull(8),
            'total_price' => $this->faker->numberBetween($min = 150000, $max = 500000),
            'payment_status' => 1,
            'user_id' => 1,
            'seller_id' => 2,
        ];
    }
}
