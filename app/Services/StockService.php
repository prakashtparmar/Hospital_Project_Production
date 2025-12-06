<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\MedicineStockLedger;

class StockService
{
    /**
     * Adjust stock with batch support.
     * +qty = Purchase (IN)
     * -qty = Issue (OUT using FEFO)
     */
    public function adjustStock(
        $medicine_id,
        $qty,
        $type,
        $reference_id = null,
        $batch_no = null,
        $expiry_date = null
    ) {
        $medicine = Medicine::findOrFail($medicine_id);

        /* =====================================================
         * 1. PURCHASE → Stock IN
         * =====================================================*/
        if ($qty > 0) {

            $batch_id = null;

            // If batch number exists → update batch stock
            if (!empty($batch_no)) {

                $batch = MedicineBatch::firstOrCreate(
                    [
                        'medicine_id' => $medicine_id,
                        'batch_no'    => $batch_no,
                    ],
                    [
                        'expiry_date'   => $expiry_date,
                        'current_stock' => 0
                    ]
                );

                $batch->current_stock += $qty;
                $batch->save();

                $batch_id = $batch->id;
            }

            // Update main stock
            $newStock = $medicine->current_stock + $qty;
            $medicine->update(['current_stock' => $newStock]);

            // Ledger entry
            MedicineStockLedger::create([
                'medicine_id'   => $medicine_id,
                'batch_id'      => $batch_id,
                'quantity'      => $qty,
                'type'          => $type,
                'reference_id'  => $reference_id,
                'running_stock' => $newStock,
            ]);

            return $newStock;
        }



        /* =====================================================
         * 2. ISSUE → Stock OUT (FEFO)
         * =====================================================*/
        if ($qty < 0) {

            $neededQty = abs($qty);

            // Fetch FEFO batches
            $batches = MedicineBatch::where('medicine_id', $medicine_id)
                        ->where('current_stock', '>', 0)
                        ->orderBy('expiry_date', 'asc')
                        ->get();

            $totalBatchStock = $batches->sum('current_stock');

            /* --------------------------------------------------
             * CASE A: BATCH STOCK < NEEDED
             * But main stock is enough → allow fallback
             * --------------------------------------------------*/
            if ($totalBatchStock < $neededQty) {

                if ($medicine->current_stock >= $neededQty) {

                    // Deduct from main stock only
                    $medicine->current_stock -= $neededQty;
                    $medicine->save();

                    MedicineStockLedger::create([
                        'medicine_id'   => $medicine_id,
                        'batch_id'      => null,
                        'quantity'      => -$neededQty,
                        'type'          => $type,
                        'reference_id'  => $reference_id,
                        'running_stock' => $medicine->current_stock,
                    ]);

                    return $medicine->current_stock;
                }

                // Not enough in batches or master
                throw new \Exception("Not enough stock for Medicine ID: $medicine_id");
            }



            /* --------------------------------------------------
             * CASE B: FEFO BATCH DEDUCTION
             * --------------------------------------------------*/
            foreach ($batches as $batch) {

                if ($neededQty <= 0) break;

                $deduct = min($neededQty, $batch->current_stock);

                // Deduct from batch
                $batch->current_stock -= $deduct;
                $batch->save();

                // Deduct from main stock
                $medicine->current_stock -= $deduct;
                $medicine->save();

                $neededQty -= $deduct;

                // Ledger entry
                MedicineStockLedger::create([
                    'medicine_id'   => $medicine_id,
                    'batch_id'      => $batch->id,
                    'quantity'      => -$deduct,
                    'type'          => $type,
                    'reference_id'  => $reference_id,
                    'running_stock' => $medicine->current_stock,
                ]);
            }

            return $medicine->current_stock;
        }
    }
}
