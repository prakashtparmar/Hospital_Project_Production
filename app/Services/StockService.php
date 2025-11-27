<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\StockLedger;

class StockService
{
    public function adjustStock($medicine_id, $qty, $type, $reference_id = null)
    {
        $medicine = Medicine::findOrFail($medicine_id);

        $newStock = $medicine->current_stock + $qty;   // qty can be +IN or -OUT

        $medicine->update(['current_stock' => $newStock]);

        StockLedger::create([
            'medicine_id'   => $medicine_id,
            'quantity'      => $qty,
            'type'          => $type,
            'reference_id'  => $reference_id,
            'running_stock' => $newStock,
        ]);

        return $newStock;
    }
}
