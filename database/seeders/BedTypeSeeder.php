<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bed;

class BedTypeSeeder extends Seeder
{
    public function run()
    {
        $beds = [
            ['room_id' => 1, 'bed_no' => 'B-1', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 1, 'bed_no' => 'B-2', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 2, 'bed_no' => 'ICU-B1', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 2, 'bed_no' => 'ICU-B2', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 3, 'bed_no' => 'NICU-B1', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 4, 'bed_no' => 'PICU-B1', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 5, 'bed_no' => 'EMG-B1', 'is_occupied' => 0, 'status' => 1],
            ['room_id' => 6, 'bed_no' => 'DLX-B1', 'is_occupied' => 0, 'status' => 1],
        ];

        foreach ($beds as $bed) {
            Bed::firstOrCreate([
                'bed_no' => $bed['bed_no']
            ], $bed);
        }
    }
}
