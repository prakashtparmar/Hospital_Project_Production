<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // -----------------------------------
        // PERMISSIONS (same list as PermissionSeeder)
        // -----------------------------------
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Users & Roles
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Departments
            'departments.view',
            'departments.create',
            'departments.edit',
            'departments.delete',

            // Doctors
            'doctors.view',
            'doctors.create',
            'doctors.edit',
            'doctors.delete',

            // Patients
            'patients.view',
            'patients.create',
            'patients.edit',
            'patients.delete',

            // OPD
            'opd.view',
            'opd.create',
            'opd.edit',
            'opd.delete',

            // IPD
            'ipd.view',
            'ipd.create',
            'ipd.edit',
            'ipd.delete',
            'ipd.discharge',

            // Appointments
            'appointments.view',
            'appointments.create',
            'appointments.edit',
            'appointments.delete',

            // Doctor Schedule
            'doctor-schedule.view',
            'doctor-schedule.create',
            'doctor-schedule.edit',
            'doctor-schedule.delete',

            // Consultations — IMPORTANT
            'consultations.view',
            'consultations.create',
            'consultations.edit',
            'consultations.end',

            // Pharmacy
            'medicines.view',
            'medicines.create',
            'medicines.edit',
            'medicines.delete',
            'issue-medicines.view',
            'issue-medicines.create',

            // Inventory
            'purchases.view',
            'purchases.create',
            'purchases.edit',
            'purchases.delete',
            'suppliers.view',
            'suppliers.create',
            'suppliers.edit',
            'suppliers.delete',
            'stock-adjustments.view',
            'stock-adjustments.create',

            // Lab
            'lab.manage',
            'lab.requests',
            'lab.collect',
            'lab.results',

            // Radiology
            'radiology.manage',
            'radiology.requests',
            'radiology.reports',

            // Billing
            'billing.manage',
            'billing.view',

            // HR
            'hr.manage',

            // Export
            'export',

            // Settings
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // -----------------------------------
        // ROLE CREATION
        // -----------------------------------
        $roles = [
            'Master Admin',
            'Admin',
            'Doctor',
            'Nurse',
            'Receptionist',
            'Accountant',
            'Pharmacist',
            'Lab Technician',
            'Radiology Technician',
            'Store Manager',
            'IPD Manager',
            'HR Manager',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // -----------------------------------
        // ROLE → PERMISSION ASSIGNMENTS
        // -----------------------------------

        // Master Admin — full access
        Role::findByName('Master Admin')->givePermissionTo(Permission::all());


        // Admin
        Role::findByName('Admin')->givePermissionTo([
            'dashboard.view',
            'users.view',
            'users.create',
            'users.edit',
            'departments.view',
            'departments.create',
            'departments.edit',
            'billing.view',
        ]);


        // Doctor
        Role::findByName('Doctor')->givePermissionTo([
            'patients.view',
            'opd.view',
            'opd.create',
            'opd.edit',

            // consultations
            'consultations.view',
            'consultations.create',
            'consultations.edit',
            'consultations.end',

            'lab.requests',
            'lab.results',
            'radiology.requests',
            'radiology.reports',
        ]);


        // Nurse
        Role::findByName('Nurse')->givePermissionTo([
            'patients.view',
            'ipd.view',
            'ipd.edit',
        ]);


        // Receptionist
        Role::findByName('Receptionist')->givePermissionTo([
            'patients.view',
            'patients.create',
            'opd.create',
            'appointments.view',
            'appointments.create',
            'appointments.edit',
        ]);


        // Accountant
        Role::findByName('Accountant')->givePermissionTo([
            'billing.manage',
        ]);


        // Pharmacist
        Role::findByName('Pharmacist')->givePermissionTo([
            'medicines.view',
            'issue-medicines.view',
            'issue-medicines.create',
        ]);


        // Lab Technician
        Role::findByName('Lab Technician')->givePermissionTo([
            'lab.requests',
            'lab.collect',
            'lab.results',
        ]);


        // Radiology Technician
        Role::findByName('Radiology Technician')->givePermissionTo([
            'radiology.requests',
            'radiology.reports',
        ]);


        // Store Manager
        Role::findByName('Store Manager')->givePermissionTo([
            'purchases.view',
            'purchases.create',
            'suppliers.view',
            'suppliers.create',
            'stock-adjustments.view',
        ]);


        // IPD Manager
        Role::findByName('IPD Manager')->givePermissionTo([
            'ipd.view',
            'ipd.edit',
            'ipd.discharge',
        ]);


        // HR Manager
        Role::findByName('HR Manager')->givePermissionTo([
            'hr.manage',
        ]);
    }
}
