<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTestParameter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_id',
        'name',
        'unit',
        'reference_range'
    ];
}
