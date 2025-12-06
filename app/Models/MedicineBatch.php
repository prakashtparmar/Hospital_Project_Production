<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineBatch extends Model
{
    protected $fillable = [
        'medicine_id',
        'batch_no',
        'expiry_date',
        'purchase_rate',
        'sale_rate',
        'mrp',
        'current_stock',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
