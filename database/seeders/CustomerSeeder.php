<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerGroup = CustomerGroup::create([
            'name' => 'General Customers',
            'percentage' => 0,
            'is_active' => 1,
        ]);

        CustomerGroup::create([
            'name' => 'Wholesale Customers',
            'percentage' => 5,
            'is_active' => 1,
        ]);

        $customerGroup->customer()->create([
            'name' => 'Walk-in Customer',
            'phone_number' => '1234567890',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'postal_code' => '12345',
            'is_active' => 1,
        ]);
    }
}
