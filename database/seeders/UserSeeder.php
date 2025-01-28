<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::findByName('Admin');
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'phone' => '1234567890',
            'company_name' => 'My Company',
            'role_id' => $role->id,
            'biller_id' => 1,
            'warehouse_id' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
        ]);
    }
}
