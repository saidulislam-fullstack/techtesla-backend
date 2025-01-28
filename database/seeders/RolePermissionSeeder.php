<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the permissions directory
        $permissionsDirectory = database_path('seeders/permissions');
        // in permissions directory, there are 4 files(admin.json, cashier.json, customer.json, owner.json)
        // we will create roles and permissions for each file

        // Get all JSON files in the permissions directory
        $permissionFiles = array_diff(scandir($permissionsDirectory), ['.', '..']);

        // Loop through each JSON file
        foreach ($permissionFiles as $file) {
            // Check if the file is a JSON file
            if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                // Get the contents of the file and decode it
                $filePath = $permissionsDirectory . '/' . $file;
                $permissionsData = json_decode(File::get($filePath), true);

                // Check if the data is valid (has 'role' and 'permissions')
                if (isset($permissionsData['role']) && isset($permissionsData['permissions'])) {
                    $roleData = $permissionsData['role'];
                    // Create or get the role, including description and is_active status
                    $role = Role::firstOrCreate(
                        ['name' => $roleData['name'], 'guard_name' => 'web'],
                        ['description' => $roleData['description'], 'is_active' => $roleData['is_active']]
                    );

                    // Create permissions if they don't exist
                    foreach ($permissionsData['permissions'] as $permission) {
                        Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
                    }

                    // Assign all permissions to the role
                    $role->syncPermissions($permissionsData['permissions']);
                }
            }
        }
    }
}
