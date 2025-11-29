<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\OpdVisitController;
use App\Http\Controllers\Admin\IpdAdmissionController;
use App\Http\Controllers\Admin\WardController;
use App\Http\Controllers\Admin\BedController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\MedicineCategoryController;
use App\Http\Controllers\Admin\MedicineUnitController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\IssueMedicineController;
use App\Http\Controllers\Admin\LabTestCategoryController;
use App\Http\Controllers\Admin\LabTestController;
use App\Http\Controllers\Admin\LabTestParameterController;
use App\Http\Controllers\Admin\LabTestRequestController;
use App\Http\Controllers\Admin\LabResultController;
use App\Http\Controllers\Admin\RadiologyRequestController;
use App\Http\Controllers\Admin\RadiologyReportController;
use App\Http\Controllers\Admin\RadiologyTestController;
use App\Http\Controllers\Admin\RadiologyCategoryController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\LeaveApplicationController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SalaryStructureController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\NotificationSettingController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Central\HospitalController;

// Root redirect
Route::get('/', fn() => redirect()->route('login'));


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});


// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin protected routes
    Route::middleware(['role:master-admin'])->group(function () {

        // Role Management
        Route::resource('roles', RoleController::class)
            ->middleware([
                'index' => 'permission:roles.view',
                'create' => 'permission:roles.create',
                'store' => 'permission:roles.create',
                'edit' => 'permission:roles.edit',
                'update' => 'permission:roles.edit',
                'destroy' => 'permission:roles.delete',
            ]);

        // User Management
        Route::resource('users', UserController::class)
            ->middleware([
                'index' => 'permission:users.view',
                'create' => 'permission:users.create',
                'store' => 'permission:users.create',
                'edit' => 'permission:users.edit',
                'update' => 'permission:users.edit',
                'destroy' => 'permission:users.delete',
            ]);

       

        Route::resource('doctors', DoctorController::class);

        // // Department Management
        // Route::resource('departments', DepartmentController::class)->middleware('permission:departments.view');
        // Route::get('departments/create', [DepartmentController::class, 'create'])->middleware('permission:departments.create');
        // Route::post('departments', [DepartmentController::class, 'store'])->middleware('permission:departments.create');
        // Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->middleware('permission:departments.edit');
        // Route::put('departments/{department}', [DepartmentController::class, 'update'])->middleware('permission:departments.edit');
        // Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->middleware('permission:departments.delete');

        Route::resource('departments', DepartmentController::class)
            ->middleware('permission:departments.view');

            

        // Restore soft-deleted department
        Route::post('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore')
            ->middleware('permission:departments.delete');

        // Permanently delete department
        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.force-delete')
            ->middleware('permission:departments.delete');



    });

    // Patient Management - accessible to all authenticated users
    // Route::resource('patients', PatientController::class)
    //     ->middleware('permission:patients.manage');

    Route::resource('patients', PatientController::class);


    // OPD/IPD/Ward/Room/Bed Management
    Route::resource('opd', OpdVisitController::class);



    Route::resource('ipd', IpdAdmissionController::class)
        ->middleware('permission:ipd.manage');
    Route::resource('wards', WardController::class)
        ->middleware('permission:wards.manage');
    Route::resource('rooms', RoomController::class)
        ->middleware('permission:rooms.manage');
    Route::resource('beds', BedController::class)
        ->middleware('permission:beds.manage');

    // IPD Discharge
    Route::get('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'dischargeForm'])->name('ipd.discharge.form')->middleware('permission:ipd.discharge');
    Route::post('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'discharge'])->name('ipd.discharge')->middleware('permission:ipd.discharge');
    Route::get('ipd/{ipd}/discharge-pdf', [IpdAdmissionController::class, 'dischargePdf'])->name('ipd.discharge.pdf')->middleware('permission:ipd.discharge');

    // Doctor Schedule & Appointments
    Route::resource('doctor-schedule', DoctorScheduleController::class);
    

    Route::get('appointments/get-slots', [AppointmentController::class, 'getAvailableSlots'])
    ->name('appointments.slots');

    Route::resource('appointments', AppointmentController::class);



    // Route::resource('appointments', AppointmentController::class)->middleware('permission:appointments.manage');

    // Medicine Management
    Route::resource('medicine-categories', MedicineCategoryController::class)->middleware('permission:medicines.manage');
    Route::resource('medicine-units', MedicineUnitController::class)->middleware('permission:medicines.manage');
    Route::resource('medicines', MedicineController::class)->middleware('permission:medicines.manage');
    Route::resource('stock-adjustments', StockAdjustmentController::class)->middleware('permission:stock.manage');
    Route::resource('suppliers', SupplierController::class)->middleware('permission:suppliers.manage');
    Route::resource('purchases', PurchaseController::class)->middleware('permission:purchases.manage');
    Route::resource('issue-medicines', IssueMedicineController::class)->middleware('permission:issue.medicines');

    // Lab Management
    Route::resource('lab-test-categories', LabTestCategoryController::class)->middleware('permission:lab.manage');
    Route::resource('lab-tests', LabTestController::class)->middleware('permission:lab.manage');
    Route::get('lab-tests/{lab_test}/parameters/create', [LabTestParameterController::class, 'create'])->name('lab.parameters.create')->middleware('permission:lab.manage');
    Route::post('lab-tests/{lab_test}/parameters', [LabTestParameterController::class, 'store'])->name('lab.parameters.store')->middleware('permission:lab.manage');
    Route::resource('lab-requests', LabTestRequestController::class)->middleware('permission:lab.requests');
    Route::get('lab-requests/{lab_request}/collect', [LabTestRequestController::class, 'collectSample'])->name('lab-requests.collect')->middleware('permission:lab.collect');
    Route::get('lab-requests/{lab_request}/results', [LabResultController::class, 'edit'])->name('lab-results.edit')->middleware('permission:lab.results');
    Route::post('lab-requests/{lab_request}/results', [LabResultController::class, 'update'])->name('lab-results.update')->middleware('permission:lab.results');
    Route::get('lab-requests/{lab_request}/pdf', [LabResultController::class, 'pdf'])->name('lab-results.pdf')->middleware('permission:lab.results');

    // Radiology Management
    Route::resource('radiology-categories', RadiologyCategoryController::class)->middleware('permission:radiology.manage');
    Route::resource('radiology-tests', RadiologyTestController::class)->middleware('permission:radiology.manage');
    Route::resource('radiology-requests', RadiologyRequestController::class)->middleware('permission:radiology.requests');
    Route::get('radiology-requests/{radiology_request}/start', [RadiologyRequestController::class, 'start'])->name('radiology-requests.start')->middleware('permission:radiology.requests');
    Route::get('radiology-requests/{radiology_request}/report', [RadiologyReportController::class, 'edit'])->name('radiology-reports.edit')->middleware('permission:radiology.reports');
    Route::post('radiology-requests/{radiology_request}/report', [RadiologyReportController::class, 'update'])->name('radiology-reports.update')->middleware('permission:radiology.reports');
    Route::get('radiology-requests/{radiology_request}/pdf', [RadiologyReportController::class, 'pdf'])->name('radiology-reports.pdf')->middleware('permission:radiology.reports');

    // Billing
    Route::resource('billing', BillingController::class)->middleware('permission:billing.manage');
    Route::post('billing/{billing}/add-item', [BillingController::class, 'addItem'])->name('billing.add-item')->middleware('permission:billing.manage');
    Route::post('billing/{billing}/add-discount', [BillingController::class, 'applyDiscount'])->name('billing.add-discount')->middleware('permission:billing.manage');
    Route::post('billing/{billing}/add-payment', [BillingController::class, 'addPayment'])->name('billing.add-payment')->middleware('permission:billing.manage');
    Route::get('billing/{billing}/pdf', [BillingController::class, 'pdf'])->name('billing.pdf')->middleware('permission:billing.manage');

    // Media Upload/Delete
    Route::post('media/upload/{model}/{id}', [MediaController::class, 'upload'])->name('media.upload')->middleware('permission:media.manage');
    Route::delete('media/delete/{media}', [MediaController::class, 'delete'])->name('media.delete')->middleware('permission:media.manage');

    // HR + Payroll
    Route::resource('employees', EmployeeController::class)->middleware('permission:hr.manage');
    Route::resource('leave-types', LeaveTypeController::class)->middleware('permission:hr.manage');
    Route::resource('leave-applications', LeaveApplicationController::class)->middleware('permission:hr.manage');
    Route::resource('attendance', AttendanceController::class)->middleware('permission:hr.manage');
    Route::resource('salary-structures', SalaryStructureController::class)->middleware('permission:hr.manage');
    Route::resource('payroll', PayrollController::class)->middleware('permission:hr.manage');
    Route::get('payroll/{payroll}/pdf', [PayrollController::class, 'pdf'])->name('payroll.pdf')->middleware('permission:hr.manage');

    // Settings
    Route::get('notification-settings', [NotificationSettingController::class, 'index'])->name('notification-settings.index')->middleware('permission:settings.manage');
    Route::post('notification-settings', [NotificationSettingController::class, 'update'])->name('notification-settings.update')->middleware('permission:settings.manage');

    // Export
    Route::get('export/patients', [ExportController::class, 'exportPatientsExcel'])->name('export.patients')->middleware('permission:export');

    // Hospitals
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('hospitals', HospitalController::class)->middleware('permission:hospitals.manage');
    });

    // Tenant-specific domain routing
    Route::domain('{hospital}.yourapp.com')->middleware('tenant')->group(function () {
        Route::get('/', fn() => view('tenant.dashboard'));
    });
});
