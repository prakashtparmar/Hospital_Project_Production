<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DoctorProfile extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'department_id',
        'specialization',
        'qualification',
        'registration_no',
        'consultation_fee',
        'biography'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id', 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('doctor_profile')
            ->logOnly([
                'user_id',
                'department_id',
                'specialization',
                'qualification',
                'registration_no',
                'consultation_fee',
                'biography',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
