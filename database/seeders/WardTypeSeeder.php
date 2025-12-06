<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardTypeSeeder extends Seeder
{
    public function run()
    {
        $wards = [
            ['name' => 'General Ward', 'type' => 'General', 'status' => 1],
            ['name' => 'ICU', 'type' => 'Critical Care', 'status' => 1],
            ['name' => 'NICU', 'type' => 'Neonatal', 'status' => 1],
            ['name' => 'PICU', 'type' => 'Pediatric', 'status' => 1],
            ['name' => 'Emergency Ward', 'type' => 'Emergency', 'status' => 1],
            ['name' => 'Deluxe Ward', 'type' => 'Deluxe', 'status' => 1],
        ];

        foreach ($wards as $ward) {
            Ward::firstOrCreate(['name' => $ward['name']], $ward);
        }
    }
}
