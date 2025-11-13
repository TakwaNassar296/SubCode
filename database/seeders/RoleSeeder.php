<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create 3 main roles
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'employee']);

        // Assign super_admin role to first user
        $adminUser = User::first();
        if ($adminUser) {
            $adminUser->assignRole('super_admin');
        }

        $this->command->info('✅ 3 Roles created: super_admin, manager, employee');
        $this->command->info('✅ super_admin role assigned to first user');
    }
}