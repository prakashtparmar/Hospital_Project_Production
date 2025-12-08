<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Users & Roles
            'users.view','users.create','users.edit','users.delete',
            'roles.view','roles.create','roles.edit','roles.delete',

            // Departments
            'departments.view','departments.create','departments.edit','departments.delete',

            // Doctors
            'doctors.view','doctors.create','doctors.edit','doctors.delete',

            // Patients
            'patients.view','patients.create','patients.edit','patients.delete',

            // OPD / IPD
            'opd.view','opd.create','opd.edit','opd.delete',
            'ipd.view','ipd.create','ipd.edit','ipd.delete','ipd.discharge',

            // Appointments
            'appointments.view','appointments.create','appointments.edit','appointments.delete',

            // Doctor Schedule
            'doctor-schedule.view','doctor-schedule.create','doctor-schedule.edit','doctor-schedule.delete',

            // Consultations
            'consultations.view','consultations.create','consultations.edit','consultations.end',

            // ==========================
            // LAB – SETUP
            // ==========================
            'lab-test-categories.view','lab-test-categories.create','lab-test-categories.edit','lab-test-categories.delete',
            'lab-tests.view','lab-tests.create','lab-tests.edit','lab-tests.delete',
            'lab-parameters.view','lab-parameters.create','lab-parameters.edit','lab-parameters.delete',

            // LAB – REQUEST FLOW
            'lab-requests.view','lab-requests.create','lab-requests.edit','lab-requests.delete',
            'lab-samples.collect',

            // LAB – RESULTS & REPORTS
            'lab-results.view','lab-results.create','lab-results.edit','lab-results.delete',
            'lab-reports.view','lab-reports.download',

            // ==========================
            // RADIOLOGY – SETUP
            // ==========================
            'radiology-categories.view','radiology-categories.create','radiology-categories.edit','radiology-categories.delete',
            'radiology-tests.view','radiology-tests.create','radiology-tests.edit','radiology-tests.delete',

            // RADIOLOGY – REQUEST FLOW
            'radiology-requests.view','radiology-requests.create','radiology-requests.edit','radiology-requests.delete',
            'radiology-tests.start',

            // RADIOLOGY – RESULTS & REPORTS
            'radiology-results.view','radiology-results.create','radiology-results.edit','radiology-results.delete',
            'radiology-reports.view','radiology-reports.download',

            // ==========================
            // Pharmacy / Inventory
            // ==========================
            'medicines.view','medicines.create','medicines.edit','medicines.delete',
            'issue-medicines.view','issue-medicines.create',
            'purchases.view','purchases.create','purchases.edit','purchases.delete',
            'suppliers.view','suppliers.create','suppliers.edit','suppliers.delete',
            'stock-adjustments.view','stock-adjustments.create',

            // Billing
            'billing.view','billing.create','billing.edit','billing.delete',

            // HR
            'hr.manage',

            // Export
            'export.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name'=>$permission,'guard_name'=>'web']);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */
        $roles = [
            'Master Admin','Admin','Doctor','Nurse','Receptionist',
            'Accountant','Pharmacist','Lab Technician',
            'Radiology Technician','Store Manager','IPD Manager','HR Manager',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name'=>$role,'guard_name'=>'web']);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE ASSIGNMENTS
        |--------------------------------------------------------------------------
        */

        // ✅ MASTER ADMIN – ALL
        Role::findByName('master-admin')->givePermissionTo(Permission::all());

        // ✅ ADMIN
        Role::findByName('Admin')->givePermissionTo([
            'dashboard.view',
            'users.view','users.create','users.edit',
            'departments.view','departments.create','departments.edit',
            'lab-tests.view','lab-tests.create','lab-tests.edit',
            'radiology-tests.view',
            'lab-requests.view','radiology-requests.view',
        ]);

        // ✅ DOCTOR
        Role::findByName('Doctor')->givePermissionTo([
            'patients.view',
            'opd.view','opd.create','opd.edit',
            'consultations.view','consultations.create','consultations.edit','consultations.end',

            'lab-requests.view','lab-results.view','lab-reports.view','lab-reports.download',
            'radiology-requests.view','radiology-reports.view','radiology-reports.download',
        ]);

        // ✅ LAB TECHNICIAN
        Role::findByName('Lab Technician')->givePermissionTo([
            'lab-tests.view','lab-parameters.view','lab-requests.view',
            'lab-samples.collect','lab-results.create','lab-results.edit',
            'lab-reports.view',
        ]);

        // ✅ RADIOLOGY TECHNICIAN
        Role::findByName('Radiology Technician')->givePermissionTo([
            'radiology-requests.view',
            'radiology-tests.start',
            'radiology-results.create','radiology-results.edit',
            'radiology-reports.view',
        ]);
    }
}
