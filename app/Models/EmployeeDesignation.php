<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDesignation extends Model
{
    protected $fillable = [
        'department_id',
        'name'
    ];

    public function department()
    {
        return $this->belongsTo(EmployeeDepartment::class);
    }
}
