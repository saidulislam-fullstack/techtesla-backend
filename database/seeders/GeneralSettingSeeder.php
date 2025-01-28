<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'site_title' => 'SalePro',
            'site_logo' => '20230718035103.png',
            'is_rtl' => 0,
            'currency' => 1,
            'state' => 1,
            'staff_access' => 'own',
            'without_stock' => 'no',
            'date_format' => 'Y-m-d',
            'developed_by' => 'SalePro',
            'invoice_format' => 'standard',
            'decimal' => 2,
            'theme' => 'default.css',
            'currency_position' => 'prefix',
            'is_zatca' => 0,
        ]);
    }
}
