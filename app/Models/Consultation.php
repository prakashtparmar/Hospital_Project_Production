<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'status',
        'chief_complaint',
        'history',
        'examination',
        'provisional_diagnosis',
        'final_diagnosis',
        'plan',
        'bp',
        'pulse',
        'temperature',
        'resp_rate',
        'spo2',
        'weight',
        'height',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function documents()
    {
        return $this->hasMany(ConsultationDocument::class);
    }
}
