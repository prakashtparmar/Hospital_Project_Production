<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            'dashboard.view',

            // Users & Roles
            'roles.view','roles.create','roles.edit','roles.delete',
            'users.view','users.create','users.edit','users.delete',

            // Departments
            'departments.view','departments.create','departments.edit','departments.delete',

            // Patients / Doctors
            'patients.view','patients.create','patients.edit','patients.delete',
            'doctors.view','doctors.create','doctors.edit','doctors.delete',

            // OPD / IPD
            'opd.view','opd.create','opd.edit','opd.delete',
            'ipd.view','ipd.create','ipd.edit','ipd.delete','ipd.discharge',

            // Appointments
            'appointments.view','appointments.create','appointments.edit','appointments.delete',
            'doctor-schedule.view','doctor-schedule.create','doctor-schedule.edit','doctor-schedule.delete',

            // Consultations
            'consultations.view','consultations.create','consultations.edit','consultations.end',

            // LAB + RADIOLOGY (FULL)
            'lab-test-categories.view','lab-test-categories.create','lab-test-categories.edit','lab-test-categories.delete',
            'lab-tests.view','lab-tests.create','lab-tests.edit','lab-tests.delete',
            'lab-parameters.view','lab-parameters.create','lab-parameters.edit','lab-parameters.delete',
            'lab-requests.view','lab-requests.create','lab-requests.edit','lab-requests.delete',
            'lab-samples.collect',
            'lab-results.view','lab-results.create','lab-results.edit','lab-results.delete',
            'lab-reports.view','lab-reports.download',

            'radiology-categories.view','radiology-categories.create','radiology-categories.edit','radiology-categories.delete',
            'radiology-tests.view','radiology-tests.create','radiology-tests.edit','radiology-tests.delete',
            'radiology-requests.view','radiology-requests.create','radiology-requests.edit','radiology-requests.delete',
            'radiology-tests.start',
            'radiology-results.view','radiology-results.create','radiology-results.edit','radiology-results.delete',
            'radiology-reports.view','radiology-reports.download',

            // Pharmacy / Inventory
            'medicines.view','medicines.create','medicines.edit','medicines.delete',
            'issue-medicines.view','issue-medicines.create',
            'purchases.view','purchases.create','purchases.edit','purchases.delete',
            'suppliers.view','suppliers.create','suppliers.edit','suppliers.delete',
            'stock-adjustments.view','stock-adjustments.create',

            // Billing / HR / Export
            'billing.view','billing.create','billing.edit','billing.delete',
            'hr.manage',
            'export.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name'=>$permission,'guard_name'=>'web']);
        }
    }
}
