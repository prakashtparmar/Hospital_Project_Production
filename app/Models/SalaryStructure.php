<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    protected $fillable = [
        'employee_id',
        'hra_percent',
        'da_percent',
        'other_allowance',
        'pf_percent',
        'tds_percent'
    ];
}
