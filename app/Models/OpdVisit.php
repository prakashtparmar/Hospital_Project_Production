<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpdVisit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'opd_no', 'patient_id', 'doctor_id', 'department_id',
        'visit_date', 'symptoms', 'diagnosis', 'bp', 'temperature',
        'pulse', 'weight', 'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
