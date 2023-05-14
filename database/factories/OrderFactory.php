<?php

namespace Database\Factories;

use App\Models\User;
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
            'user_id' => User::factory()->create(),
            'order_id' => $this->faker->lexify,
            'provider' => $this->faker->randomElement(['PayPal', 'PlacetoPay']),
            'url' => $this->faker->url(),
            'amount' => $this->faker->randomFloat(2),
            'currency' => $this->faker->randomElement(['USD', 'COP']),
            'status' => $this->faker->randomElement(['PENDING', 'COMPLETED', 'CANCELED']),
        ];
    }
}
