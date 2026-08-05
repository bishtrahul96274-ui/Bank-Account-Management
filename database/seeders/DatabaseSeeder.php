<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Create test account
        $account = Account::create([
            'user_id' => $user->id,
            'account_number' => 'ACC00000001',
            'account_type' => 'savings',
            'balance' => 50000,
            'status' => 'active',
            'pin' => bcrypt('1234'),
        ]);

        // Create sample transactions
        Transaction::create([
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => 10000,
            'balance_before' => 40000,
            'balance_after' => 50000,
            'description' => 'Initial deposit',
            'status' => 'completed',
        ]);

        // Create additional test accounts
        Account::factory(5)->for($user)->create();
    }
}
