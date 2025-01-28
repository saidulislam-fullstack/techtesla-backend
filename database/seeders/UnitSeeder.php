<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'unit_code'       => 'Pc(s)',
            'unit_name'       => 'Piece',
            'operator'        => '*',
            'operation_value' => 1,
            'is_active'       => 1,
        ]);
    }
}
