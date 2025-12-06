<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'method',
        'price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(LabTestCategory::class);
    }

    public function parameters()
    {
        return $this->hasMany(LabTestParameter::class, 'test_id');
    }
}
