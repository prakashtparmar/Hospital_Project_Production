<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;

class RadiologyRequest extends Model
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
        return $this->hasMany(RadiologyRequestItem::class, 'request_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}

public function report()
{
    return $this->hasOne(RadiologyReport::class, 'request_id');
}


}
