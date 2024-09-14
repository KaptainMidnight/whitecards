<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'telegram_id' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'cash' => $this->faker->numberBetween(0, 10000),
            'coins' => $this->faker->numberBetween(0, 10000),
            'total_coins' => $this->faker->numberBetween(0, 50000),
            'total_cash' => $this->faker->numberBetween(0, 50000),
        ];
    }
}
