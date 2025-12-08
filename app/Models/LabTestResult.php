<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestResult extends Model
{
    protected $fillable = [
        'request_id',
        'parameter_id',
        'value',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function request()
    {
        return $this->belongsTo(LabTestRequest::class, 'request_id');
    }

    public function parameter()
    {
        return $this->belongsTo(LabTestParameter::class, 'parameter_id');
    }
}
