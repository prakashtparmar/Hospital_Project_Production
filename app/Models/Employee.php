<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name','email','phone',
        'department_id','designation_id',
        'joining_date','leaving_date',
        'bank_name','bank_account',
        'basic_salary','status'
    ];

    public function department()
    {
        return $this->belongsTo(EmployeeDepartment::class);
    }

    public function designation()
    {
        return $this->belongsTo(EmployeeDesignation::class);
    }
}
