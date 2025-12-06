<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalaryStructure;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(20);
        return view('admin.payroll.index', compact('payrolls'));
    }

    public function generate(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $structure = SalaryStructure::where('employee_id',$employee->id)->first();

        $basic = $employee->basic_salary;
        $hra = ($basic * $structure->hra_percent) / 100;
        $da = ($basic * $structure->da_percent) / 100;
        $allow = $structure->other_allowance;

        $pf = ($basic * $structure->pf_percent) / 100;
        $tds = ($basic * $structure->tds_percent) / 100;

        // LEAVE DEDUCTIONS
        $month = $request->month;
        $year = $request->year;

        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $absents = Attendance::where('employee_id',$employee->id)
            ->whereBetween('date', ["$year-$month-01", "$year-$month-$days"])
            ->where('status','Absent')
            ->count();

        $per_day_salary = $basic / 30;
        $leave_ded = $absents * $per_day_salary;

        $net_salary = $basic + $hra + $da + $allow - $pf - $tds - $leave_ded;

        Payroll::create([
            'employee_id' => $employee->id,
            'month' => $month,
            'year' => $year,
            'basic' => $basic,
            'hra' => $hra,
            'da' => $da,
            'allowance' => $allow,
            'pf' => $pf,
            'tds' => $tds,
            'leave_deduction' => $leave_ded,
            'net_salary' => $net_salary
        ]);

        return back()->with('success','Payroll Generated.');
    }

    public function pdf(Payroll $payroll)
{
    $pdf = \PDF::loadView('admin.payroll.pdf', compact('payroll'));
    return $pdf->download('payslip-'.$payroll->id.'.pdf');
}

}
