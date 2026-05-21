<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntryItem extends Model
{
    protected $fillable = [
        'entry_id',
        'account_id',
        'debit',
        'credit'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
