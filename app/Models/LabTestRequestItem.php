<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestRequestItem extends Model
{
    protected $fillable = [
        'request_id',
        'test_id'
    ];

    public function test()
    {
        return $this->belongsTo(LabTest::class);
    }
}
