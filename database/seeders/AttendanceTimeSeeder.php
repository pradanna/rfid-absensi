<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::create([
            'name' => 'Masuk',
            'time' => '07:00:00',
        ]);

        Attendance::create([
            'name' => 'Pulang',
            'time' => '15:00:00',
        ]);
    }
}
