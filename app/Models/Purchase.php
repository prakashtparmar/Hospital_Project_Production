<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'invoice_no',
        'invoice_date',

        'grn_no',
        'purchase_date',

        // Payment
        'payment_type',

        // Challan
        'challan_no',
        'challan_date',

        // Totals
        'total_amount',
        'discount_amount',
        'discount_percent',
        'round_off',
        'tax_amount',
        'grand_total',

        // Status
        'status',

        // Additional notes
        'remarks',

        // Transport
        'transport_name',
        'lr_no',
        'lr_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'invoice_date'  => 'date',
        'challan_date'  => 'date',
        'lr_date'       => 'date',

        'total_amount'      => 'decimal:2',
        'discount_amount'   => 'decimal:2',
        'discount_percent'  => 'decimal:2',
        'round_off'         => 'decimal:2',
        'tax_amount'        => 'decimal:2',
        'grand_total'       => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // Calculates total from purchase_items automatically
    public function calculateTotals()
    {
        $subtotal = $this->items->sum('amount');
        $discount = $this->items->sum('discount_amount');
        $tax      = $this->items->sum('tax_amount');
        $total    = $this->items->sum('total_amount');

        return [
            'subtotal'   => $subtotal,
            'discount'   => $discount,
            'tax'        => $tax,
            'grandtotal' => $total,
        ];
    }
}
