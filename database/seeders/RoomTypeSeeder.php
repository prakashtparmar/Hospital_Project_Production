<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            ['ward_id' => 1, 'room_no' => 'S-101', 'status' => 1],
            ['ward_id' => 1, 'room_no' => 'S-102', 'status' => 1],
            ['ward_id' => 2, 'room_no' => 'ICU-1', 'status' => 1],
            ['ward_id' => 2, 'room_no' => 'ICU-2', 'status' => 1],
            ['ward_id' => 3, 'room_no' => 'NICU-1', 'status' => 1],
            ['ward_id' => 4, 'room_no' => 'PICU-1', 'status' => 1],
            ['ward_id' => 5, 'room_no' => 'EMG-1', 'status' => 1],
            ['ward_id' => 6, 'room_no' => 'DLX-1', 'status' => 1],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate([
                'room_no' => $room['room_no']
            ], $room);
        }
    }
}
