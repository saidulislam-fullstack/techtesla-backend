<?php

namespace Database\Seeders;

use App\Models\Biller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Biller::create([
            'name' => 'Default Biller',
            'company_name' => 'My Company',
            'email' => 'biller@company.earth',
            'phone_number' => '1234567890',
            'address' => '123 Main Street',
            'city' => 'City',
            'state' => 'State',
            'postal_code' => '12345',
            'country' => 'United States',
            'is_active' => 1,
        ]);
    }
}
