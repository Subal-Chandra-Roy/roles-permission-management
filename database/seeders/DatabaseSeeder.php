<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Create permissions
        $permissions = [
            'create role',
            'view role',
            'update role',
            'delete role',
            'create permission',
            'view permission',
            'update permission',
            'delete permission',
            'create user',
            'view user',
            'update user',
            'delete user',

        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'super-admin',
            'admin',
            'user',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign permissions to roles
            switch ($roleName) {
                case 'super-admin':
                    $permissions = Permission::all();
                    break;
                case 'admin':
                    $permissions = Permission::whereIn('name', ['view role', 'view permission', 'view user', 'create user', 'update user', 'delete user'])->get();
                    break;
                case 'user':
                    $permissions = Permission::whereIn('name', ['view user'])->get();
                    break;
                default:
                    $permissions = [];
            }

            $role->syncPermissions($permissions);
        }

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password')
        ]);
        $superAdmin->assignRole('super-admin');
        $superAdmin->syncPermissions(Permission::all());

        //create admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('user');
    }
}
