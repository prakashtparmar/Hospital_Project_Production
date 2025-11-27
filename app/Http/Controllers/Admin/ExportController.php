<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel; // Use the Excel facade
use Illuminate\Http\Request; // Good practice, though not strictly needed for this method

class ExportController extends Controller
{
    /**
     * Export patients data to an Excel file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPatientsExcel()
    {
        return Excel::download(new PatientsExport, 'patients.xlsx');
    }
}