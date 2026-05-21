<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestRequest extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'opd_id',
        'ipd_id',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(LabTestRequestItem::class, 'request_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
{
    return $this->belongsTo(\App\Models\User::class, 'doctor_id');
}

// App\Models\LabTestRequest.php
public function results()
{
    return $this->hasMany(LabTestResult::class, 'request_id');
}


}
