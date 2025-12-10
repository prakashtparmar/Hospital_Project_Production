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
            'ipd.discharge', // ✅ ADDED

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

            // ==========================
            // LAB – TEST SETUP (MASTER)
            // ==========================
            'lab-test-categories.view',
            'lab-test-categories.create',
            'lab-test-categories.edit',
            'lab-test-categories.delete',

            'lab-tests.view',
            'lab-tests.create',
            'lab-tests.edit',
            'lab-tests.delete',

            'lab-parameters.view',
            'lab-parameters.create',
            'lab-parameters.edit',
            'lab-parameters.delete',

            // ==========================
            // LAB – TEST REQUEST FLOW
            // ==========================
            'lab-requests.view',
            'lab-requests.create',
            'lab-requests.edit',
            'lab-requests.delete',

            // Sample Collection
            'lab-samples.collect',

            // ==========================
            // LAB – RESULTS & REPORTS
            // ==========================
            'lab-results.view',
            'lab-results.create',
            'lab-results.edit',
            'lab-results.delete',

            'lab-reports.view',
            'lab-reports.download',

            // ==========================
            // LAB – DASHBOARD (OPTIONAL)
            // ==========================
            'lab-dashboard.view',

            // ==========================
            // RADIOLOGY – TEST SETUP
            // ==========================
            'radiology-categories.view',
            'radiology-categories.create',
            'radiology-categories.edit',
            'radiology-categories.delete',

            'radiology-tests.view',
            'radiology-tests.create',
            'radiology-tests.edit',
            'radiology-tests.delete',

            // ==========================
            // RADIOLOGY – REQUEST FLOW
            // ==========================
            'radiology-requests.view',
            'radiology-requests.create',
            'radiology-requests.edit',
            'radiology-requests.delete',

            // Start / Perform Test
            'radiology-tests.start',

            // ==========================
            // RADIOLOGY – RESULTS & REPORTS
            // ==========================
            'radiology-results.view',
            'radiology-results.create',
            'radiology-results.edit',
            'radiology-results.delete',

            'radiology-reports.view',
            'radiology-reports.update', // ✅ ADDED
            'radiology-reports.download',

            // ==========================
            // RADIOLOGY – DASHBOARD
            // ==========================
            'radiology-dashboard.view',

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

            // Multi Hospital
            'hospitals.view',
            'hospitals.create',
            'hospitals.edit',
            'hospitals.delete',

            'product-list',
    'product-create',
    'product-edit',
    'product-delete',
    'product-print',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
