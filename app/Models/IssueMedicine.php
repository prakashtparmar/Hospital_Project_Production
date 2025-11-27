<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueMedicine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'opd_id',
        'ipd_id',
        'issue_date',
        'total_amount'
    ];

    public function items()
    {
        return $this->hasMany(IssueMedicineItem::class, 'issue_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
