<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Patient extends Model implements HasMedia
{
    // Added LogsActivity trait
    use SoftDeletes, InteractsWithMedia, LogsActivity;

    // Configuration for Spatie Activity Log
    protected static $logName = 'patient';
    protected static $logAttributes = [
        'full_name', // Logs the computed attribute value
        'phone',
        'age',
        'gender',
        'address'
    ];

    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'gender',
        'age',
        'phone',
        'email',
        'address',
        'department_id',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Accessor to get the full name
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    // Media Library configuration
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')->useDisk('public');
    }

    // Implement the missing getActivitylogOptions method
    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly(['full_name', 'phone', 'age', 'gender', 'address']);
    }
}
