<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpdAdmission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ipd_no',
        'patient_id',
        'doctor_id',
        'department_id',
        'ward_id',
        'room_id',
        'bed_id',
        'admission_date',
        'admission_reason',
        'initial_diagnosis',
        'discharge_date',
        'discharge_summary',
        'final_diagnosis',
        'status'
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

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
