<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Medicine;

class PurchaseItemSeeder extends Seeder
{
    public function run()
    {
        $purchase = Purchase::first();
        $medicines = Medicine::take(2)->get();

        if (!$purchase || $medicines->isEmpty()) {
            return;
        }

        foreach ($medicines as $m) {
            PurchaseItem::create([
                'purchase_id'   => $purchase->id,
                'medicine_id'   => $m->id,
                'quantity'      => 20,
                'purchase_rate' => $m->purchase_rate ?? 10,
                'mrp'           => $m->mrp ?? 0,
                'tax_percent'   => $m->tax_percent ?? 12,
                'tax_amount'    => 20 * ($m->purchase_rate ?? 10) * (($m->tax_percent ?? 12) / 100),
                'total_amount'  => 20 * ($m->purchase_rate ?? 10),
                'batch_no'      => "BATCH-" . rand(100, 999),
                'expiry_date'   => now()->addMonths(12),
            ]);

            $m->increment('current_stock', 20);
        }
    }
}
