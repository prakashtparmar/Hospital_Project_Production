<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadiologyReport extends Model
{
    protected $fillable = [
        'request_id',
        'report',
        'impression'
    ];
}
