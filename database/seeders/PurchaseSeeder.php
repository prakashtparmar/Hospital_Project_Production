<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Purchase;
use App\Models\Supplier;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $supplier = Supplier::first();

        if (!$supplier) {
            $supplier = Supplier::create([
                'name' => 'Default Supplier',
                'email' => 'supplier@example.com',
                'phone' => '9999999999',
            ]);
        }

        Purchase::updateOrCreate(
            ['invoice_no' => 'INV-1001'],
            [
                'grn_no'        => 'GRN-' . strtoupper(Str::random(6)),
                'supplier_id'   => $supplier->id,
                'purchase_date' => now()->subDays(2),
                'total_amount'  => 1800,
                'tax_amount'    => 200,
                'grand_total'   => 2000,
            ]
        );
    }
}
