<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntry extends Model
{
    protected $fillable = [
        'entry_date',
        'voucher_no',
        'type',
        'reference_type',
        'reference_id'
    ];

    public function items()
    {
        return $this->hasMany(AccountingEntryItem::class, 'entry_id');
    }
}
