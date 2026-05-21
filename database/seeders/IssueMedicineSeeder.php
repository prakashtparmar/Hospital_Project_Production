<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IssueMedicine;

class IssueMedicineSeeder extends Seeder
{
    public function run()
    {
        IssueMedicine::create([
            'patient_id' => 1,
            'doctor_id' => 1,
            'opd_id' => 1,
            'issue_date' => now(),
            'total_amount' => 150,
        ]);
    }
}
