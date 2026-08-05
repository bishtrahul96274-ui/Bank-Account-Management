<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'account_number' => 'ACC' . str_pad($this->faker->unique()->numberBetween(1, 999999), 8, '0', STR_PAD_LEFT),
            'account_type' => $this->faker->randomElement(['savings', 'checking', 'business']),
            'balance' => $this->faker->numberBetween(1000, 100000),
            'status' => 'active',
            'pin' => bcrypt('1234'),
        ];
    }
}
