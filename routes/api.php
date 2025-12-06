<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Controller Imports (Placeholder for future controllers) ---
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\DoctorApiController;
use App\Http\Controllers\Api\AppointmentApiController; // New Placeholder
use App\Http\Controllers\Api\OpdApiController;         // New Placeholder
use App\Http\Controllers\Api\IpdApiController;         // New Placeholder
use App\Http\Controllers\Api\PharmacyApiController;    // New Placeholder
use App\Http\Controllers\Api\LabApiController;        // New Placeholder
use App\Http\Controllers\Api\RadiologyApiController;   // New Placeholder
use App\Http\Controllers\Api\BillingApiController;    // New Placeholder
use App\Http\Controllers\Api\DashboardApiController;


/*
|--------------------------------------------------------------------------
| Public Routes (Authentication)
|--------------------------------------------------------------------------
*/

Route::post('auth/login', [ApiAuthController::class,'login']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // User Management
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('auth/logout', [ApiAuthController::class,'logout']);

    // --- Role-Specific API Routes ---
    
    // PATIENT API
    Route::prefix('patient')->group(function () {
        Route::get('profile', [PatientApiController::class,'profile']);
        Route::post('profile', [PatientApiController::class,'updateProfile']);
        Route::get('appointments', [PatientApiController::class,'appointments']);
        Route::get('lab-reports', [PatientApiController::class,'labReports']);
        Route::get('radiology-reports', [PatientApiController::class,'radiologyReports']);
        Route::get('invoices', [PatientApiController::class,'invoices']);
    });

    // DOCTOR API
    Route::prefix('doctor')->group(function () {
        Route::get('today-appointments', [DoctorApiController::class,'appointmentsToday']);
        Route::post('opd-notes/{visit}', [DoctorApiController::class,'opdNotes']);
        Route::get('patient-history/{patientId}', [DoctorApiController::class,'patientHistory']);
    });

    // --- Resource API Routes (Anonymous Functions) ---
    
    // APPOINTMENTS API
    Route::get('appointments', function() {
        return \App\Models\Appointment::latest()->paginate(20);
    });

    // OPD API
    Route::get('opd', function() {
        return \App\Models\OpdVisit::latest()->paginate(20);
    });

    // IPD API
    Route::get('ipd', function() {
        return \App\Models\IpdAdmission::latest()->paginate(20);
    });

    // PHARMACY API
    // Get stock Issue medications Medicine search
    Route::prefix('pharmacy')->group(function () {
        Route::get('stock', function() {
            return \App\Models\Medicine::select('id','name','qty')->get();
        });
    });

    // LAB API
    Route::prefix('lab')->group(function () {
        Route::get('tests', function() {
            return \App\Models\LabTest::all();
        });
    });

    // RADIOLOGY API
    Route::prefix('radiology')->group(function () {
        Route::get('tests', function() {
            return \App\Models\RadiologyTest::all();
        });
    });

    // BILLING API
    Route::prefix('billing')->group(function () {
        Route::get('invoices', function() {
            return \App\Models\BillingInvoice::latest()->get();
        });
    });

    //Dashboard
    Route::get('dashboard/api/opd-ipd', [DashboardApiController::class,'opdIpdMonthly']);

    
});