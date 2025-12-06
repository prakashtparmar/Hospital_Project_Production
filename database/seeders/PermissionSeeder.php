<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Users & Roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'departments.view',
            'departments.create',
            'departments.edit',
            'departments.delete',
            'auditlogs.view',
            'notification-settings.view',
            'notification-settings.edit',

            // Consultations
            'consultations.view',
            'consultations.create',
            'consultations.edit',
            'consultations.end',

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

            // Ward & Room
            'wards.view',
            'wards.create',
            'wards.edit',
            'wards.delete',
            'rooms.view',
            'rooms.create',
            'rooms.edit',
            'rooms.delete',
            'beds.view',
            'beds.create',
            'beds.edit',
            'beds.delete',

            // Pharmacy
            'medicine-categories.view',
            'medicine-categories.create',
            'medicine-categories.edit',
            'medicine-categories.delete',
            'medicine-units.view',
            'medicine-units.create',
            'medicine-units.edit',
            'medicine-units.delete',
            'medicines.view',
            'medicines.create',
            'medicines.edit',
            'medicines.delete',
            'stock-adjustments.view',
            'stock-adjustments.create',
            'stock-adjustments.edit',
            'stock-adjustments.delete',
            'suppliers.view',
            'suppliers.create',
            'suppliers.edit',
            'suppliers.delete',
            'purchases.view',
            'purchases.create',
            'purchases.edit',
            'purchases.delete',
            'issue-medicines.view',
            'issue-medicines.create',
            'issue-medicines.edit',
            'issue-medicines.delete',

            // Lab
            'lab-test-categories.view',
            'lab-test-categories.create',
            'lab-test-categories.edit',
            'lab-test-categories.delete',
            'lab-tests.view',
            'lab-tests.create',
            'lab-tests.edit',
            'lab-tests.delete',
            'lab-requests.view',
            'lab-requests.create',
            'lab-requests.edit',
            'lab-requests.delete',

            // Radiology
            'radiology-categories.view',
            'radiology-categories.create',
            'radiology-categories.edit',
            'radiology-categories.delete',
            'radiology-tests.view',
            'radiology-tests.create',
            'radiology-tests.edit',
            'radiology-tests.delete',
            'radiology-requests.view',
            'radiology-requests.create',
            'radiology-requests.edit',
            'radiology-requests.delete',

            // Billing
            'billing.view',
            'billing.create',
            'billing.edit',
            'billing.delete',

            // HR
            'employees.view',
            'employees.create',
            'employees.edit',
            'employees.delete',
            'leave-types.view',
            'leave-types.create',
            'leave-types.edit',
            'leave-types.delete',
            'leave-applications.view',
            'leave-applications.create',
            'leave-applications.edit',
            'leave-applications.delete',
            'attendance.view',
            'attendance.create',
            'attendance.edit',
            'attendance.delete',
            'salary-structures.view',
            'salary-structures.create',
            'salary-structures.edit',
            'salary-structures.delete',
            'payroll.view',
            'payroll.create',
            'payroll.edit',
            'payroll.delete',

            // Export
            'export.view',

            // Multi Hospital (central management)
            'hospitals.view',
            'hospitals.create',
            'hospitals.edit',
            'hospitals.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
