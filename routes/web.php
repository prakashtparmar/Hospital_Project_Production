<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

// ==========================
// Admin Controllers
// ==========================
use App\Http\Controllers\Admin\{
    RoleController,
    UserController,
    DepartmentController,
    PatientController,
    OpdVisitController,
    IpdAdmissionController,
    WardController,
    BedController,
    RoomController,
    DoctorController,
    DoctorScheduleController,
    AppointmentController,
    MedicineCategoryController,
    MedicineUnitController,
    MedicineController,
    StockAdjustmentController,
    SupplierController,
    PurchaseController,
    IssueMedicineController,
    LabTestCategoryController,
    LabTestController,
    LabTestParameterController,
    LabTestRequestController,
    LabResultController,
    RadiologyRequestController,
    RadiologyReportController,
    RadiologyTestController,
    RadiologyCategoryController,
    BillingController,
    EmployeeController,
    LeaveTypeController,
    LeaveApplicationController,
    AttendanceController,
    SalaryStructureController,
    PayrollController,
    NotificationSettingController,
    MediaController,
    DashboardController,
    ExportController,
    ConsultationController,
    PrescriptionController,
    ActivityLogController,
    PrescriptionItemController,
};

use App\Http\Controllers\Central\HospitalController;


// ==========================
// Guest (Login)
// ==========================
Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});


// ==========================
// Authenticated Routes
// ==========================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

    // Dashboard
    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // ==========================
    // Master Admin ONLY
    // ==========================
    Route::middleware(['role:master-admin'])->group(function () {

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('doctors', DoctorController::class);

        Route::resource('departments', DepartmentController::class);

        Route::post('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore');

        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.force-delete');
    });


    // ==========================
    // Patient / OPD / IPD
    // ==========================
    Route::resource('patients', PatientController::class);
    Route::resource('opd', OpdVisitController::class);
    Route::resource('ipd', IpdAdmissionController::class);

    Route::get('ipd/get-rooms/{ward_id}', [IpdAdmissionController::class, 'getRooms'])->name('ipd.getRooms');
    Route::get('ipd/get-beds/{room_id}', [IpdAdmissionController::class, 'getBeds'])->name('ipd.getBeds');

    Route::get('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'dischargeForm'])->name('ipd.discharge.form');
    Route::post('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'discharge'])->name('ipd.discharge');
    Route::get('ipd/{ipd}/discharge-pdf', [IpdAdmissionController::class, 'dischargePdf'])->name('ipd.discharge.pdf');


    // Ward / Room / Bed
    Route::resources([
        'wards' => WardController::class,
        'rooms' => RoomController::class,
        'beds' => BedController::class,
    ]);


    // ==========================
    // Appointments
    // ==========================
    Route::resource('doctor-schedule', DoctorScheduleController::class);

    Route::get(
        'appointments/get-slots',
        [AppointmentController::class, 'getAvailableSlots']
    )->name('appointments.slots');

    Route::resource('appointments', AppointmentController::class);

    Route::post(
        'appointments/{appointment:id}/convert-opd',
        [AppointmentController::class, 'convertToOpd']
    )->name('appointments.convert-to-opd');


    // ==========================
    // Pharmacy
    // ==========================
// Purchase Invoice Preview (HTML)
    Route::get(
        'purchases/{purchase}/invoice',
        [PurchaseController::class, 'invoice']
    )->name('purchases.invoice');

    // Purchase Invoice PDF Download
    Route::get(
        'purchases/{purchase}/invoice/pdf',
        [PurchaseController::class, 'invoicePdf']
    )->name('purchases.invoice.pdf');



    Route::resources([
        'medicine-categories' => MedicineCategoryController::class,
        'medicine-units' => MedicineUnitController::class,
        'medicines' => MedicineController::class,
        'stock-adjustments' => StockAdjustmentController::class,
        'suppliers' => SupplierController::class,
        'purchases' => PurchaseController::class,
        'issue-medicines' => IssueMedicineController::class,
    ]);

    Route::get('/medicine-stock/{id}', function ($id) {
        $medicine = \App\Models\Medicine::find($id);
        return ['stock' => $medicine ? $medicine->current_stock : 0];
    });







    // ==========================
    // Laboratory
    // ==========================
    Route::resource('lab-test-categories', LabTestCategoryController::class);
    Route::resource('lab-tests', LabTestController::class);

    Route::get(
        'lab-tests/{lab_test:id}/parameters/create',
        [LabTestParameterController::class, 'create']
    )->name('lab.parameters.create');

    Route::post(
        'lab-tests/{lab_test:id}/parameters',
        [LabTestParameterController::class, 'store']
    )->name('lab.parameters.store');

    Route::resource('lab-requests', LabTestRequestController::class);

    Route::get('lab-requests/{lab_request:id}/collect', [LabTestRequestController::class, 'collectSample'])
        ->name('lab-requests.collect');

    Route::get('lab-requests/{lab_request:id}/results', [LabResultController::class, 'edit'])
        ->name('lab-results.edit');

    Route::post('lab-requests/{lab_request:id}/results', [LabResultController::class, 'update'])
        ->name('lab-results.update');

    Route::get('lab-requests/{lab_request:id}/pdf', [LabResultController::class, 'pdf'])
        ->name('lab-results.pdf');


    // ==========================
// Radiology
// ==========================
Route::resource('radiology-categories', RadiologyCategoryController::class);
Route::resource('radiology-tests', RadiologyTestController::class);
Route::resource('radiology-requests', RadiologyRequestController::class);

Route::get(
    'radiology-requests/{radiology_request:id}/start',
    [RadiologyRequestController::class, 'start']
)->name('radiology-requests.start');

Route::get(
    'radiology-requests/{radiology_request:id}/report',
    [RadiologyReportController::class, 'edit']
)->name('radiology-reports.edit');

Route::put( // ✅ FIX APPLIED
    'radiology-requests/{radiology_request:id}/report',
    [RadiologyReportController::class, 'update']
)->name('radiology-reports.update');

Route::get(
    'radiology-requests/{radiology_request:id}/pdf',
    [RadiologyReportController::class, 'pdf']
)->name('radiology-reports.pdf');



    // ==========================
    // Billing
    // ==========================
    Route::resource('billing', BillingController::class);

    Route::post('billing/{billing:id}/add-item', [BillingController::class, 'addItem'])->name('billing.add-item');
    Route::post('billing/{billing:id}/add-discount', [BillingController::class, 'applyDiscount'])->name('billing.add-discount');
    Route::post('billing/{billing:id}/add-payment', [BillingController::class, 'addPayment'])->name('billing.add-payment');

    Route::get('billing/{billing:id}/pdf', [BillingController::class, 'pdf'])->name('billing.pdf');


    // ==========================
    // Media Upload
    // ==========================
    Route::post('media/upload/{model}/{id}', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/delete/{media:id}', [MediaController::class, 'delete'])->name('media.delete');


    // ==========================
    // HR / Payroll
    // ==========================
    Route::resources([
        'employees' => EmployeeController::class,
        'leave-types' => LeaveTypeController::class,
        'leave-applications' => LeaveApplicationController::class,
        'attendance' => AttendanceController::class,
        'salary-structures' => SalaryStructureController::class,
        'payroll' => PayrollController::class,
    ]);

    Route::get('payroll/{payroll:id}/pdf', [PayrollController::class, 'pdf'])->name('payroll.pdf');


    // ==========================
    // Notification Settings
    // ==========================
    Route::get('notification-settings', [NotificationSettingController::class, 'index'])
        ->name('notification-settings.index');

    Route::post('notification-settings', [NotificationSettingController::class, 'update'])
        ->name('notification-settings.update');


    // ==========================
    // Export
    // ==========================
    Route::get('export/patients', [ExportController::class, 'exportPatientsExcel'])
        ->name('export.patients');


    // ==========================
    // Hospitals (Central)
    // ==========================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('hospitals', HospitalController::class);
    });


    // ==========================
    // Activity Logs
    // ==========================
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');



    // ==========================================================
    // CONSULTATIONS MODULE (CLEAN + FIXED)
    // ==========================================================

    Route::resource('consultations', ConsultationController::class);

    Route::get(
        'consultations/patient/{patient}/history',
        [ConsultationController::class, 'patientHistory']
    )->name('consultations.patient-history');

    Route::get(
        'consultations/patient/{patient}/history/pdf',
        [ConsultationController::class, 'patientHistoryPdf']
    )->name('consultations.patient-history.pdf');

    Route::post(
        'consultations/{consultation}/documents',
        [ConsultationController::class, 'uploadDocument']
    )->name('consultations.documents.upload');

    Route::delete(
        'consultations/documents/{id}',
        [ConsultationController::class, 'deleteDocument']
    )->name('consultations.documents.destroy');






    // ==========================================================
    // PRESCRIPTIONS MODULE (CLEAN + FIXED)
    // ==========================================================
    Route::resource('prescriptions', PrescriptionController::class);

    // Keep old GET delete route (as you requested)
    Route::get(
        'prescription-item/delete/{id}',
        [PrescriptionItemController::class, 'destroy']
    )->name('prescription-items.delete');

    Route::get(
        '/prescriptions/{id}/pdf',
        [PrescriptionController::class, 'generatePdf']
    )->name('prescriptions.pdf');

    Route::post(
        '/prescriptions/item/store',
        [PrescriptionController::class, 'storeItem']
    )->name('prescriptions.item.store');

    Route::delete(
        '/prescriptions/item/{id}',
        [PrescriptionController::class, 'deleteItem']
    )->name('prescriptions.item.delete');

    Route::post(
        '/prescriptions/notes/update',
        [PrescriptionController::class, 'updateNotes']
    )->name('prescriptions.notes.update');

});
