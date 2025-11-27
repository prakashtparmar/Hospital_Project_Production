<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create the Admin Role (if it doesn't exist)
        // Note: You might have a separate RoleSeeder for this
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 2. Assign ALL available permissions to the Admin Role
        // This grants the Admin role every permission defined in the system.
        $allPermissions = Permission::pluck('id')->all();
        $adminRole->syncPermissions($allPermissions);

        // 3. Create the Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Find by email
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'), // CHANGE THIS!
                // REMOVED: 'role' => 'admin',  <-- This line caused your error!
            ]
        );

        // 4. Assign the 'admin' role to the Admin User
        $admin->assignRole($adminRole);


        // 5. Create a Standard User (using the 'user' role or no role)
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
            ]
        );
        
        // Optional: Assign a default 'user' role if you have one
        // $userRole = Role::firstOrCreate(['name' => 'user']);
        // $user->assignRole($userRole);
    }
}