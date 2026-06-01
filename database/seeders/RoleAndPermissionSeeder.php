<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $supervisorRole = Role::firstOrCreate(['name' => 'Supervisor']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);

        // Create Default Users
        $staff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Budi Staff',
                'password' => bcrypt('password'),
            ]
        );
        $staff->assignRole($staffRole);

        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Siti Supervisor',
                'password' => bcrypt('password'),
            ]
        );
        $supervisor->assignRole($supervisorRole);

        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Andi Manager',
                'password' => bcrypt('password'),
            ]
        );
        $manager->assignRole($managerRole);
    }
}
