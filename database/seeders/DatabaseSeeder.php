<?php

use Database\Seeders\AccountSeeder;
use Database\Seeders\BillerSeeder;
use Database\Seeders\CourierSeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\ExpenseCategorySeeder;
use Database\Seeders\GeneralSettingSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\UnitSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WarehouseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            GeneralSettingSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            WarehouseSeeder::class,
            AccountSeeder::class,
            BillerSeeder::class,
            CourierSeeder::class,
            ExpenseCategorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
