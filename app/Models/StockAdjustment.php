<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $fillable = ['medicine_id', 'adjust_quantity', 'reason'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
