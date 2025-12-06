<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineUnit;
use Illuminate\Support\Str;

class MedicineUnitSeeder extends Seeder
{
    public function run()
    {
        $units = [

            // ---------------------- SOLID FORM ----------------------
            ['name' => 'Tablet', 'type' => 'Solid', 'description' => 'Single-dose solid form'],
            ['name' => 'Capsule', 'type' => 'Solid', 'description' => 'Enclosed powder/gel form'],
            ['name' => 'Strip', 'type' => 'Solid', 'description' => 'Packaging unit for tablets/capsules'],
            ['name' => 'Blister Pack', 'type' => 'Solid', 'description' => 'Blister sheet of tablets'],
            ['name' => 'Sachet', 'type' => 'Powder', 'description' => 'Powder unit dose packaging'],
            ['name' => 'Granules Pack', 'type' => 'Powder', 'description' => 'Powder granules packaging'],

            // ---------------------- LIQUID FORM ----------------------
            ['name' => 'Bottle', 'type' => 'Liquid', 'description' => 'Syrup, solution, suspension'],
            ['name' => 'ml', 'type' => 'Liquid', 'description' => 'Liquid measurement unit'],
            ['name' => 'Litre', 'type' => 'Liquid', 'description' => 'Large liquid packaging'],
            ['name' => 'Can', 'type' => 'Liquid', 'description' => 'Large volume medical liquids'],

            // ---------------------- INJECTION / PARENTERAL ----------------------
            ['name' => 'Vial', 'type' => 'Injection', 'description' => 'Glass/Plastic injection container'],
            ['name' => 'Ampoule', 'type' => 'Injection', 'description' => 'Single-use sealed injection unit'],
            ['name' => 'IV Bag', 'type' => 'Injection', 'description' => 'Intravenous saline, glucose bags'],
            ['name' => 'Syringe Pack', 'type' => 'Injection', 'description' => 'Syringe included dose pack'],

            // ---------------------- TOPICAL MEDICINES ----------------------
            ['name' => 'Tube', 'type' => 'Topical', 'description' => 'Creams, gels, ointments'],
            ['name' => 'Jar', 'type' => 'Topical', 'description' => 'Large topical containers'],
            ['name' => 'Pump Pack', 'type' => 'Topical', 'description' => 'Topical pump dispenser'],

            // ---------------------- DROPS ----------------------
            ['name' => 'Eye Drop', 'type' => 'Drops', 'description' => 'Sterile ophthalmic drops'],
            ['name' => 'Ear Drop', 'type' => 'Drops', 'description' => 'Otic drops'],
            ['name' => 'Nasal Drop', 'type' => 'Drops', 'description' => 'Nasal administration drops'],

            // ---------------------- INHALATION ----------------------
            ['name' => 'Inhaler', 'type' => 'Other', 'description' => 'Metered dose inhaler'],
            ['name' => 'Rotacap', 'type' => 'Other', 'description' => 'Dry powder inhaler capsule'],
            ['name' => 'Nebulizer Solution', 'type' => 'Other', 'description' => 'Nebulizer liquid unit'],

            // ---------------------- SURGICAL & OTHERS ----------------------
            ['name' => 'Roll', 'type' => 'Other', 'description' => 'Bandage rolls'],
            ['name' => 'Box', 'type' => 'Other', 'description' => 'Packaged surgical supplies'],
            ['name' => 'Pack', 'type' => 'Other', 'description' => 'General packaging unit'],
            ['name' => 'Kit', 'type' => 'Other', 'description' => 'Emergency or diagnostic kit'],

            // ---------------------- MEDICAL LAB & DIAGNOSTIC UNITS ----------------------
            ['name' => 'Test Strip', 'type' => 'Other', 'description' => 'Diabetes & diagnostic strips'],
            ['name' => 'Cartridge', 'type' => 'Other', 'description' => 'Diagnostic or injection cartridge'],

            // ---------------------- BULK MEDICAL SUPPLIES ----------------------
            ['name' => 'Piece', 'type' => 'Other', 'description' => 'Single item packaging'],
            ['name' => 'Set', 'type' => 'Other', 'description' => 'Optional multi-item kit'],

        ];

        foreach ($units as $unit) {
            MedicineUnit::firstOrCreate(
                ['name' => $unit['name']],
                [
                    'slug'        => Str::slug($unit['name']) . '-' . uniqid(),
                    'type'        => $unit['type'],
                    'description' => $unit['description'],
                    'status'      => 1
                ]
            );
        }
    }
}
