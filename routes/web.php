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
use App\Http\Controllers\Admin\EmployeeController; // Added missing controller
use App\Http\Controllers\Admin\LeaveTypeController; // Added missing controller
use App\Http\Controllers\Admin\LeaveApplicationController; // Added missing controller
use App\Http\Controllers\Admin\AttendanceController; // Added missing controller
use App\Http\Controllers\Admin\SalaryStructureController; // Added missing controller
use App\Http\Controllers\Admin\PayrollController; // Added missing controller
use App\Http\Controllers\Admin\NotificationSettingController; // Added missing controller
use App\Http\Controllers\Admin\MediaController; // Added the new Media Controller
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Central\HospitalController;



// Redirect root to login page
Route::get('/', fn() => redirect()->route('login'));

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Admin Routes: Protected by 'auth' and 'role:Admin' middleware
    Route::middleware(['role:Admin'])->group(function () {
        // Role Management
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

        // User Management Resource Routes
        Route::resource('users', UserController::class);

        // Doctor Management Resource Routes
        Route::resource('doctors', DoctorController::class);


        // Department Management Resource Routes
        Route::resource('departments', DepartmentController::class);
    });

    // Patient Management Resource Routes (Available to all authenticated users)
    Route::resource('patients', PatientController::class);

    // OPD Management Resource Routes
    Route::resource('opd', OpdVisitController::class);

    //IPD Management Resource Routes
    Route::resource('ipd', IpdAdmissionController::class);

    Route::resource('wards', WardController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('beds', BedController::class);

    // Discharge Route
    Route::get('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'dischargeForm'])->name('ipd.discharge.form');
    Route::post('ipd/{ipd}/discharge', [IpdAdmissionController::class, 'discharge'])->name('ipd.discharge');

    // Discharge PDF Generate
    Route::get('ipd/{ipd}/discharge-pdf', [IpdAdmissionController::class, 'dischargePdf'])->name('ipd.discharge.pdf');

    // Doctor Schedule
    Route::resource('doctor-schedule', DoctorScheduleController::class);

    // Appoinment 
    Route::resource('appointments', AppointmentController::class);

    //Medicine Categories
    Route::resource('medicine-categories', MedicineCategoryController::class);

    //Medicine Unit
    Route::resource('medicine-units', MedicineUnitController::class);

    // Medicine Master
    Route::resource('medicines', MedicineController::class);

    // Stock Adjustment

    Route::resource('stock-adjustments', StockAdjustmentController::class);

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    //Purchase Module
    Route::resource('purchases', PurchaseController::class);

    //Issue Medicines to OPD IPD
    Route::resource('issue-medicines', IssueMedicineController::class);

    // LAB TEST Categories
    Route::resource('lab-test-categories', LabTestCategoryController::class);

    //LAB TEST MASTER
    Route::resource('lab-tests', LabTestController::class);

    //Route — Test Parameters
    Route::get('lab-tests/{lab_test}/parameters/create', [LabTestParameterController::class, 'create'])->name('lab.parameters.create');

    Route::post('lab-tests/{lab_test}/parameters', [LabTestParameterController::class, 'store'])->name('lab.parameters.store');

    //Routes — Test Request
    Route::resource('lab-requests', LabTestRequestController::class);

    //Sample Collection
    Route::get('lab-requests/{lab_request}/collect', [LabTestRequestController::class, 'collectSample'])
        ->name('lab-requests.collect');


    // LAB Result Route

    Route::get('lab-requests/{lab_request}/results', [LabResultController::class, 'edit'])->name('lab-results.edit');

    Route::post('lab-requests/{lab_request}/results', [LabResultController::class, 'update'])->name('lab-results.update');

    //PDF LAB REPORT
    Route::get('lab-requests/{lab_request}/pdf', [LabResultController::class, 'pdf'])->name('lab-results.pdf');


    //Radiology Categories
    Route::resource('radiology-categories', RadiologyCategoryController::class);

    //Radiology Test Master
    Route::resource('radiology-tests', RadiologyTestController::class);

    //Radiology Request
    Route::resource('radiology-requests', RadiologyRequestController::class);

    Route::get(
        'radiology-requests/{radiology_request}/start',
        [RadiologyRequestController::class, 'start']
    )->name('radiology-requests.start');

    //Radiology Report
    Route::get(
        'radiology-requests/{radiology_request}/report',
        [RadiologyReportController::class, 'edit']
    )->name('radiology-reports.edit');

    Route::post(
        'radiology-requests/{radiology_request}/report',
        [RadiologyReportController::class, 'update']
    )->name('radiology-reports.update');

    // Report PDF
    Route::get(
        'radiology-requests/{radiology_request}/pdf',
        [RadiologyReportController::class, 'pdf']
    )->name('radiology-reports.pdf');


    // Billing Module
    Route::resource('billing', BillingController::class);

    Route::post('billing/{billing}/add-item', [BillingController::class, 'addItem'])->name('billing.add-item');
    Route::post('billing/{billing}/add-discount', [BillingController::class, 'applyDiscount'])->name('billing.add-discount');
    Route::post('billing/{billing}/add-payment', [BillingController::class, 'addPayment'])->name('billing.add-payment');

    // BILLING INVOICE PDF

    Route::get('billing/{billing}/pdf', [BillingController::class, 'pdf'])->name('billing.pdf');

    // --- Media Upload/Delete Utility Routes ---
    Route::post('media/upload/{model}/{id}', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/delete/{media}', [MediaController::class, 'delete'])->name('media.delete');
    // ----------------------------------------

    // HR + Payroll
    Route::resource('employees', EmployeeController::class);
    Route::resource('leave-types', LeaveTypeController::class);
    Route::resource('leave-applications', LeaveApplicationController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('salary-structures', SalaryStructureController::class);
    Route::resource('payroll', PayrollController::class);

    Route::get('payroll/{payroll}/pdf', [PayrollController::class, 'pdf'])->name('payroll.pdf');

    // Settings
    Route::get('notification-settings', [NotificationSettingController::class, 'index'])->name('notification-settings.index');
    Route::post('notification-settings', [NotificationSettingController::class, 'update'])->name('notification-settings.update');

    // Export In Word File
    Route::get('export/patients', [ExportController::class, 'exportPatientsExcel'])->name('export.patients');

    // DASHBOARD
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Create New Hospital
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::resource('hospitals', HospitalController::class);
    });

    Route::domain('{hospital}.yourapp.com')->middleware('tenant')->group(function () {
        // Tenant-specific routes go here
        Route::get('/', function () {
            return view('tenant.dashboard');
        });
    });


    
});