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
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        return view('admin.dashboard.index', [

            // ---- Today Summary ----
            'opd_today' => OpdVisit::whereDate('visit_date', $today)->count(),
            'ipd_today' => IpdAdmission::whereDate('admission_date', $today)->count(),
            'appointments_today' => Appointment::whereDate('appointment_date', $today)->count(),
            'total_patients' => Patient::count(),
            'today_revenue' => BillingInvoice::whereDate('created_at', $today)->sum('net_amount'),

            // ---- Pharmacy ----
            // 'low_stock' => Medicine::where('current_stock', '<', 10)->count(),
            // 'total_medicines' => Medicine::count(),

            // ---- Pharmacy ----
'low_stock' => Medicine::whereNull('deleted_at')
    ->whereColumn('current_stock', '<', 'reorder_level')
    ->count(),

'total_medicines' => Medicine::whereNull('deleted_at')->count(),


            // ---- Lab & Radiology ----
            'pending_lab' => LabTestRequest::where('status', 'pending')->count(),
            'pending_radio' => RadiologyRequest::where('status', 'pending')->count(),

            // ---- Bed / Ward ----
            'total_wards' => Ward::count(),
            'total_rooms' => Room::count(),
            'total_beds' => Bed::count(),
            'occupied_beds' => Bed::where('is_occupied', 1)->count(),

            // ---- Doctor Availability ----
            'available_doctors' => User::role('Doctor')->count(),
            'on_duty_doctors' => User::role('Doctor')
                ->whereHas('doctorProfile')
                ->whereHas('doctorSchedules', function ($q) {
                    $q->where('status', 1);
                })
                ->count(),


            // ---- Top 5 doctors today ----
            'top_doctors' => OpdVisit::whereDate('visit_date', $today)
                ->select('doctor_id', DB::raw('count(*) as total'))
                ->groupBy('doctor_id')
                ->with('doctor')
                ->orderBy('total', 'DESC')
                ->take(5)
                ->get(),

            // ---- Graph Data ----
            'monthly_opd' => OpdVisit::select(
                DB::raw('COUNT(id) AS total'),
                DB::raw('MONTH(created_at) AS month')
            )->groupBy('month')->pluck('total', 'month'),

            'monthly_ipd' => IpdAdmission::select(
                DB::raw('COUNT(id) AS total'),
                DB::raw('MONTH(created_at) AS month')
            )->groupBy('month')->pluck('total', 'month'),

            'monthly_revenue' => BillingInvoice::select(
                DB::raw('SUM(net_amount) AS total'),
                DB::raw('MONTH(created_at) AS month')
            )->groupBy('month')->pluck('total', 'month'),

            // ------------------------------------------------------
            //      FULL DATA FOR MODAL (RECOMMENDED OPTION B)
            // ------------------------------------------------------

            'today_appointments' => Appointment::whereDate('appointment_date', $today)
                ->with(['patient', 'doctor'])
                ->orderBy('appointment_time', 'ASC')
                ->get(),

            'today_appointments_grouped' => Appointment::whereDate('appointment_date', $today)
                ->with(['patient', 'doctor'])
                ->orderBy('doctor_id')
                ->orderBy('appointment_time')
                ->get()
                ->groupBy('doctor_id'),


            'today_opd_visits' => OpdVisit::whereDate('visit_date', $today)
                ->with(['patient', 'doctor'])
                ->get(),

            'today_ipd_admissions' => IpdAdmission::whereDate('admission_date', $today)
                ->with(['patient', 'doctor', 'ward', 'room', 'bed'])
                ->get(),

            'today_low_stock_medicines' => Medicine::whereColumn('current_stock', '<=', 'reorder_level')
                ->orderBy('current_stock')
                ->get(),

            'today_pending_lab' => LabTestRequest::where('status', 'pending')
                ->with('patient')
                ->get(),

            'today_pending_radio' => RadiologyRequest::where('status', 'pending')
                ->with('patient')
                ->get(),
        ]);
    }
}
