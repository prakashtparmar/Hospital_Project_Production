<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineUnit;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        /* ------------------------------
         | Ensure Categories Exist
         ------------------------------ */
        $category_antibiotic = MedicineCategory::firstOrCreate(
            ['name' => 'Antibiotics'],
            ['slug' => Str::slug('Antibiotics') . '-' . uniqid(), 'status' => 1]
        )->id;

        $category_analgesic = MedicineCategory::firstOrCreate(
            ['name' => 'Pain Killers (Analgesics)'],
            ['slug' => Str::slug('Pain Killers Analgesics') . '-' . uniqid(), 'status' => 1]
        )->id;

        $category_syrup = MedicineCategory::firstOrCreate(
            ['name' => 'Syrups'],
            ['slug' => Str::slug('Syrups') . '-' . uniqid(), 'status' => 1]
        )->id;

        $category_vitamin = MedicineCategory::firstOrCreate(
            ['name' => 'Vitamins & Supplements'],
            ['slug' => Str::slug('Vitamins Supplements') . '-' . uniqid(), 'status' => 1]
        )->id;


        /* ------------------------------
         | Ensure Units Exist
         ------------------------------ */
        $tablet_unit = MedicineUnit::firstOrCreate(
            ['name' => 'Tablet'],
            [
                'slug' => Str::slug('Tablet') . '-' . uniqid(),
                'type' => 'solid',
                'description' => 'Solid tablet form',
                'status' => 1
            ]
        )->id;

        $syrup_unit = MedicineUnit::firstOrCreate(
            ['name' => 'Bottle'],
            [
                'slug' => Str::slug('Bottle') . '-' . uniqid(),
                'type' => 'liquid',
                'description' => 'Liquid bottle',
                'status' => 1
            ]
        )->id;

        $capsule_unit = MedicineUnit::firstOrCreate(
            ['name' => 'Capsule'],
            [
                'slug' => Str::slug('Capsule') . '-' . uniqid(),
                'type' => 'solid',
                'description' => 'Capsule form',
                'status' => 1
            ]
        )->id;


        /* -----------------------------------------
         | Medicine List (Add 10 Medicines)
         | **UPDATED: current_stock is now 100 for all**
         ----------------------------------------- */
        $medicines = [
            [
                'name' => 'Paracetamol 500mg',
                'category_id' => $category_analgesic,
                'unit_id' => $tablet_unit,
                'strength' => '500mg',
                'composition' => 'Paracetamol IP 500mg',
                'mrp' => 25.00,
                'purchase_rate' => 18.00,
                'purchase_price' => 18.00,
                'tax_percent' => 5,
                'current_stock' => 100, // Updated
                'reorder_level' => 50
            ],
            [
                'name' => 'Amoxicillin 250mg',
                'category_id' => $category_antibiotic,
                'unit_id' => $tablet_unit,
                'strength' => '250mg',
                'composition' => 'Amoxicillin IP 250mg',
                'mrp' => 80.00,
                'purchase_rate' => 60.00,
                'purchase_price' => 60.00,
                'tax_percent' => 12,
                'current_stock' => 100, // Updated
                'reorder_level' => 40
            ],
            [
                'name' => 'Cough Syrup 100ml',
                'category_id' => $category_syrup,
                'unit_id' => $syrup_unit,
                'strength' => '100ml',
                'composition' => 'Dextromethorphan + Chlorpheniramine',
                'mrp' => 95.00,
                'purchase_rate' => 70.00,
                'purchase_price' => 70.00,
                'tax_percent' => 12,
                'current_stock' => 100, // Updated
                'reorder_level' => 10
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'category_id' => $category_analgesic,
                'unit_id' => $tablet_unit,
                'strength' => '400mg',
                'composition' => 'Ibuprofen 400mg',
                'mrp' => 45.00,
                'purchase_rate' => 30.00,
                'purchase_price' => 30.00,
                'tax_percent' => 5,
                'current_stock' => 100, // Updated
                'reorder_level' => 30
            ],
            [
                'name' => 'Azithromycin 500mg',
                'category_id' => $category_antibiotic,
                'unit_id' => $tablet_unit,
                'strength' => '500mg',
                'composition' => 'Azithromycin 500mg',
                'mrp' => 120.00,
                'purchase_rate' => 90.00,
                'purchase_price' => 90.00,
                'tax_percent' => 12,
                'current_stock' => 100, // Updated
                'reorder_level' => 20
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'category_id' => $category_vitamin,
                'unit_id' => $tablet_unit,
                'strength' => '1000mg',
                'composition' => 'Ascorbic Acid 1000mg',
                'mrp' => 150.00,
                'purchase_rate' => 100.00,
                'purchase_price' => 100.00,
                'tax_percent' => 5,
                'current_stock' => 100, // Updated
                'reorder_level' => 25
            ],
            [
                'name' => 'Calcium + Vitamin D3 Tablets',
                'category_id' => $category_vitamin,
                'unit_id' => $tablet_unit,
                'strength' => '500mg + 250IU',
                'composition' => 'Calcium Carbonate + Vitamin D3',
                'mrp' => 200.00,
                'purchase_rate' => 150.00,
                'purchase_price' => 150.00,
                'tax_percent' => 5,
                'current_stock' => 100, // Updated
                'reorder_level' => 20
            ],
            [
                'name' => 'Omeprazole 20mg',
                'category_id' => $category_antibiotic,
                'unit_id' => $capsule_unit,
                'strength' => '20mg',
                'composition' => 'Omeprazole IP 20mg',
                'mrp' => 55.00,
                'purchase_rate' => 38.00,
                'purchase_price' => 38.00,
                'tax_percent' => 12,
                'current_stock' => 100, // Updated
                'reorder_level' => 35
            ],
            [
                'name' => 'ORS Powder Sachet',
                'category_id' => $category_syrup,
                'unit_id' => $tablet_unit,
                'strength' => '21g',
                'composition' => 'Oral Rehydration Salts',
                'mrp' => 25.00,
                'purchase_rate' => 15.00,
                'purchase_price' => 15.00,
                'tax_percent' => 5,
                'current_stock' => 100, // Updated
                'reorder_level' => 80
            ],
            [
                'name' => 'Multivitamin Syrup 150ml',
                'category_id' => $category_vitamin,
                'unit_id' => $syrup_unit,
                'strength' => '150ml',
                'composition' => 'Multivitamin + Minerals',
                'mrp' => 120.00,
                'purchase_rate' => 85.00,
                'purchase_price' => 85.00,
                'tax_percent' => 12,
                'current_stock' => 100, // Updated
                'reorder_level' => 15
            ],
        ];

        /* -----------------------------------------
         | Insert or Update Medicines
         ----------------------------------------- */
        foreach ($medicines as $m) {
            Medicine::updateOrCreate(
                ['name' => $m['name']],
                array_merge($m, [
                    'slug' => Str::slug($m['name']) . '-' . uniqid(),
                    'sku' => strtoupper(Str::random(10)),
                    'barcode' => rand(1000000000000, 9999999999999),
                    'status' => 1
                ])
            );
        }
    }
}