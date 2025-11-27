<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\OpdVisit;
use App\Models\IpdAdmission;
use App\Models\Appointment;
use App\Models\BillingInvoice;
use App\Models\Medicine;
use App\Models\LabTestRequest;
use App\Models\RadiologyRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        return view('admin.dashboard.index', [
            'opd_today'       => OpdVisit::whereDate('visit_date',$today)->count(),
            'ipd_today'       => IpdAdmission::whereDate('admission_date',$today)->count(),
            'appointments_today' => Appointment::whereDate('appointment_date',$today)->count(),
            'total_patients'  => Patient::count(),
            'today_revenue'   => BillingInvoice::whereDate('created_at',$today)->sum('net_amount'),
            'low_stock'       => Medicine::where('qty','<',10)->count(),
            'pending_lab'     => LabTestRequest::where('status','pending')->count(),
            'pending_radio'   => RadiologyRequest::where('status','pending')->count(),
        ]);
    }
}
