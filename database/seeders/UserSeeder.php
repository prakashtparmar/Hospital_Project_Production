<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Create Full Permission List
        |--------------------------------------------------------------------------
        */
        $permissions = [

            // Dashboard
            'dashboard.view',

            // User & System
            'roles.view','roles.create','roles.edit','roles.delete',
            'users.view','users.create','users.edit','users.delete',
            'departments.view','departments.create','departments.edit','departments.delete',
            'auditlogs.view',
            'notification-settings.view','notification-settings.edit',

            // Doctors
'doctors.view','doctors.create','doctors.edit','doctors.delete',

// Consultations (FULL LIST)
'consultations.view',
'consultations.create',
'consultations.edit',
'consultations.end',



            // Clinical Care
            'patients.view','patients.create','patients.edit','patients.delete',
            'opd.view','opd.create','opd.edit','opd.delete',
            'ipd.view','ipd.create','ipd.edit','ipd.delete','ipd.discharge',
            'appointments.view','appointments.create','appointments.edit','appointments.delete',
            'doctor-schedule.view','doctor-schedule.create','doctor-schedule.edit','doctor-schedule.delete',

            // Ward & Room
            'wards.view','wards.create','wards.edit','wards.delete',
            'rooms.view','rooms.create','rooms.edit','rooms.delete',
            'beds.view','beds.create','beds.edit','beds.delete',

            // Pharmacy & Inventory
            'medicine-categories.view','medicine-categories.create','medicine-categories.edit','medicine-categories.delete',
            'medicine-units.view','medicine-units.create','medicine-units.edit','medicine-units.delete',
            'medicines.view','medicines.create','medicines.edit','medicines.delete',
            'stock-adjustments.view','stock-adjustments.create',
            'suppliers.view','suppliers.create','suppliers.edit','suppliers.delete',
            'purchases.view','purchases.create','purchases.edit','purchases.delete',
            'issue-medicines.view','issue-medicines.create',

            // Laboratory
            'lab-test-categories.view','lab-test-categories.create','lab-test-categories.edit','lab-test-categories.delete',
            'lab-tests.view','lab-tests.create','lab-tests.edit','lab-tests.delete',
            'lab.requests','lab.collect','lab.results',

            // Radiology
            'radiology-categories.view','radiology-categories.create','radiology-categories.edit','radiology-categories.delete',
            'radiology-tests.view','radiology-tests.create','radiology-tests.edit','radiology-tests.delete',
            'radiology.requests','radiology.reports',

            // Billing
            'billing.manage','billing.view',

            // HR & Payroll
            'hr.manage',

            // Export
            'export.view',

            // Multi-Hospital
            'hospitals.view','hospitals.create','hospitals.edit','hospitals.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }


        /*
        |--------------------------------------------------------------------------
        | 2. Create Standard Production Roles
        |--------------------------------------------------------------------------
        */
        $roles = [
            'master-admin',
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

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // master-admin - All permissions
        Role::findByName('master-admin')->givePermissionTo(Permission::all());

        // Admin
        Role::findByName('Admin')->givePermissionTo([
            'dashboard.view',
            'users.view','users.create','users.edit',
            'departments.view','departments.create','departments.edit',
            'billing.view',
        ]);

        // Doctor
        Role::findByName('Doctor')->givePermissionTo([
            'patients.view',
            'opd.view','opd.create','opd.edit',
            'lab.requests','lab.results',
            'radiology.requests','radiology.reports',
        ]);

        // Nurse
        Role::findByName('Nurse')->givePermissionTo([
            'patients.view',
            'ipd.view','ipd.edit',
        ]);

        // Receptionist
        Role::findByName('Receptionist')->givePermissionTo([
            'patients.view','patients.create',
            'opd.create',
            'appointments.view','appointments.create',
        ]);

        // Accountant
        Role::findByName('Accountant')->givePermissionTo([
            'billing.manage',
        ]);

        // Pharmacist
        Role::findByName('Pharmacist')->givePermissionTo([
            'medicines.view',
            'issue-medicines.view','issue-medicines.create',
        ]);

        // Lab Technician
        Role::findByName('Lab Technician')->givePermissionTo([
            'lab.requests','lab.collect','lab.results',
        ]);

        // Radiology Technician
        Role::findByName('Radiology Technician')->givePermissionTo([
            'radiology.requests','radiology.reports',
        ]);

        // Store Manager
        Role::findByName('Store Manager')->givePermissionTo([
            'purchases.view','purchases.create',
            'suppliers.view','suppliers.create',
            'stock-adjustments.view',
        ]);

        // IPD Manager
        Role::findByName('IPD Manager')->givePermissionTo([
            'ipd.view','ipd.edit','ipd.discharge',
        ]);

        // HR Manager
        Role::findByName('HR Manager')->givePermissionTo([
            'hr.manage',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 4. Create Demo Production Users
        |--------------------------------------------------------------------------
        */

        // master-admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'master-administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('master-admin');


        // DOCTOR
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@example.com'],
            [
                'name' => 'Dr. Tony Stark',
                'password' => Hash::make('password'),
            ]
        );
        $doctor->assignRole('Doctor');


        // NURSE
        $nurse = User::firstOrCreate(
            ['email' => 'nurse@example.com'],
            [
                'name' => 'Nurse Olivia',
                'password' => Hash::make('password'),
            ]
        );
        $nurse->assignRole('Nurse');


        // RECEPTIONIST
        $reception = User::firstOrCreate(
            ['email' => 'reception@example.com'],
            [
                'name' => 'Front Desk Officer',
                'password' => Hash::make('password'),
            ]
        );
        $reception->assignRole('Receptionist');


        // ACCOUNTANT
        $accountant = User::firstOrCreate(
            ['email' => 'accountant@example.com'],
            [
                'name' => 'Billing Officer',
                'password' => Hash::make('password'),
            ]
        );
        $accountant->assignRole('Accountant');


        // PHARMACIST
        $pharmacist = User::firstOrCreate(
            ['email' => 'pharmacy@example.com'],
            [
                'name' => 'Pharmacy Manager',
                'password' => Hash::make('password'),
            ]
        );
        $pharmacist->assignRole('Pharmacist');


        // LAB TECHNICIAN
        $lab = User::firstOrCreate(
            ['email' => 'lab@example.com'],
            [
                'name' => 'Lab Technician',
                'password' => Hash::make('password'),
            ]
        );
        $lab->assignRole('Lab Technician');


        // RADIOLOGY TECHNICIAN
        $rad = User::firstOrCreate(
            ['email' => 'radiology@example.com'],
            [
                'name' => 'Radiology Staff',
                'password' => Hash::make('password'),
            ]
        );
        $rad->assignRole('Radiology Technician');


        // STORE MANAGER
        $store = User::firstOrCreate(
            ['email' => 'store@example.com'],
            [
                'name' => 'Inventory Manager',
                'password' => Hash::make('password'),
            ]
        );
        $store->assignRole('Store Manager');


        // IPD MANAGER
        $ipd = User::firstOrCreate(
            ['email' => 'ipd@example.com'],
            [
                'name' => 'IPD Manager',
                'password' => Hash::make('password'),
            ]
        );
        $ipd->assignRole('IPD Manager');


        // HR MANAGER
        $hr = User::firstOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('password'),
            ]
        );
        $hr->assignRole('HR Manager');
    }
}
