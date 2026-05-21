<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueMedicine extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'opd_id',
        'ipd_id',
        'issue_no',
        'issue_date',
        'total_amount'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function items()
    {
        return $this->hasMany(IssueMedicineItem::class, 'issue_id');
    }
}
