<?php

namespace Database\Factories\front;

use Illuminate\Database\Eloquent\Factories\Factory;

class transactionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'store_id' => 1,
            'provider_id' => rand(1, 5),
            'transaction_id' => rand(100000, 999999),
            'from' => $this->faker->phoneNumber,
            'amount' => rand(500, 5000),
            'sim_number' => $this->faker->phoneNumber,
            'username' => $this->faker->name,
            'status' => rand(1, 4),
        ];
    }
}
