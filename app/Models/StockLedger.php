<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    protected $table = 'medicine_stock_ledger';

    protected $fillable = [
        'medicine_id',
        'quantity',
        'type',
        'reference_id',
        'running_stock'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
