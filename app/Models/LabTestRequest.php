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
}
