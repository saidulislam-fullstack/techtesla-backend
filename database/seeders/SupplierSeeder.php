<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'Default Supplier',
            'company_name' => 'Supplier Company',
            'email' => 'supplier@supplier.earth',
            'phone_number' => '1234567890',
            'address' => 'Supplier Address',
            'city' => 'City',
            'state' => 'State',
            'postal_code' => '12345',
            'country' => 'Country',
            'is_active' => 1,
        ]);
    }
}
