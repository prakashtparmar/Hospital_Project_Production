<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Fetch all logs with subject and causer details
        $logs = Activity::with(['subject', 'causer'])
                        ->orderBy('id', 'DESC')
                        ->paginate(25);

        return view('admin.activity_logs.index', compact('logs'));
    }
}
