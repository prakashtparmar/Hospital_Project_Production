<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadiologyTest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'modality',
        'price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(RadiologyCategory::class);
    }
}
