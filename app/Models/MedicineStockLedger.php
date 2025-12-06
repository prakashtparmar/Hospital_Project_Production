<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStockLedger extends Model
{
    protected $table = 'medicine_stock_ledger';

    protected $fillable = [
        'medicine_id',
        'batch_id',
        'batch_no',
        'expiry_date',
        'quantity',        // +IN or -OUT
        'type',            // PURCHASE, ISSUE_OPD, ISSUE_IPD, ADJUSTMENT, RETURN
        'reference_id',    // purchase_id / issue_id / return_id etc.
        'running_stock',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'batch_id');
    }
}
