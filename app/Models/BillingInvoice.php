<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingInvoice extends Model
{
    protected $fillable = [
        'patient_id',
        'opd_id',
        'ipd_id',
        'invoice_no',
        'total',
        'discount',
        'net_amount',
        'paid_amount',
        'due_amount'
    ];

    public function items()
    {
        return $this->hasMany(BillingItem::class, 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany(BillingPayment::class, 'invoice_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
