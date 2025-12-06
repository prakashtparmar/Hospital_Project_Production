<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;

class PatientsExport implements FromCollection
{
    public function collection()
    {
        return Patient::select('id','full_name','age','gender','phone')->get();
    }
}
