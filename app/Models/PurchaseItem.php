<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'medicine_id',

        // Basic fields
        'quantity',
        'rate',
        'amount',

        // Advanced fields
        'free_qty',
        'mrp',
        'sale_rate',
        'manufacture_date',

        'discount_percent',
        'discount_amount',

        'tax_percent',
        'taxable_amount',
        'tax_amount',

        'total_amount',

        // Batch & expiry
        'batch_no',
        'expiry_date',
    ];

    protected $casts = [
        'expiry_date'       => 'date',
        'manufacture_date'  => 'date',

        'rate'              => 'decimal:2',
        'amount'            => 'decimal:2',
        'mrp'               => 'decimal:2',
        'sale_rate'         => 'decimal:2',
        'discount_amount'   => 'decimal:2',
        'taxable_amount'    => 'decimal:2',
        'tax_amount'        => 'decimal:2',
        'total_amount'      => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
