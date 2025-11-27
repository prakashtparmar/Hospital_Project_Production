<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueMedicineItem extends Model
{
    protected $fillable = [
        'issue_id',
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
