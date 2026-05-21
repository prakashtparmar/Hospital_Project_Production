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

    public function issue()
    {
        return $this->belongsTo(IssueMedicine::class, 'issue_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}
