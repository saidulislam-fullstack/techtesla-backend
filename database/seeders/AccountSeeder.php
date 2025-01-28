<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::insert([
            [
                'id' => 1,
                'account_no' => '10010',
                'name' => 'Sales Account',
                'initial_balance' => 0,
                'total_balance' => 0,
                'note' => 'This is a Sales Account',
                'is_default' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'account_no' => '20010',
                'name' => 'Expense Account',
                'initial_balance' => 0,
                'total_balance' => 0,
                'note' => 'This is a Expense Account',
                'is_default' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
