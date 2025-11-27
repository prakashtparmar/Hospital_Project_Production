<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'unit_id',
        'sku',
        'reorder_level',
        'current_stock',
        'mrp',
        'purchase_price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(MedicineCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(MedicineUnit::class);
    }
}
