<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Courier::create([
            'name' => 'Default Courier',
            'phone_number' => '1234567890',
            'address' => '123 Main Street',
            'is_active' => 1,
        ]);
    }
}
