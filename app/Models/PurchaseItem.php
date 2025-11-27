<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'medicine_id',
        'quantity',
        'rate',
        'amount'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
