<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OpdVisit;
use App\Models\IpdAdmission;

class DashboardApiController extends Controller
{
    public function opdIpdMonthly()
    {
        $months = [];
        $opdCounts = [];
        $ipdCounts = [];

        for ($i=1; $i<=12; $i++) {
            $months[] = date("M", mktime(0,0,0,$i,10));

            $opdCounts[] = OpdVisit::whereMonth('visit_date',$i)->count();
            $ipdCounts[] = IpdAdmission::whereMonth('admission_date',$i)->count();
        }

        return response()->json([
            'months' => $months,
            'opd' => $opdCounts,
            'ipd' => $ipdCounts,
        ]);
    }
}
