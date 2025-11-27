<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions (you can expand later)
        $permissions = [
            'user.manage',
            'patient.create',
            'patient.view',
            'patient.update',
            'patient.delete',
            'appointment.manage',
            'billing.manage',
            'inventory.manage',
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $doctor = Role::firstOrCreate(['name' => 'Doctor']);
        $nurse = Role::firstOrCreate(['name' => 'Nurse']);
        $receptionist = Role::firstOrCreate(['name' => 'Receptionist']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());
        $doctor->givePermissionTo(['patient.view', 'patient.update', 'appointment.manage']);
        $nurse->givePermissionTo(['patient.view']);
        $receptionist->givePermissionTo(['patient.create', 'patient.view', 'appointment.manage']);
    }
}
