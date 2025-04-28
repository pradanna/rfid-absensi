<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classRoom = ClassRoom::first(); // pastikan ada 1 data class_room dulu

        if (!$classRoom) {
            $classRoom = ClassRoom::create(['name' => 'Kelas A']);
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($days as $day) {
            Schedule::create([
                'class_room_id' => $classRoom->id,
                'day' => $day,
                'time_in' => '07:30:00'
            ]);
        }
    }
}
