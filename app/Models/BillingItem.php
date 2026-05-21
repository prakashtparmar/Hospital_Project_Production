<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'item_name',
        'qty',
        'rate',
        'amount',
        'source_type',
        'source_id'
    ];
}
