<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classRoom = ClassRoom::first(); // Pastikan ada satu kelas dulu

        if (!$classRoom) {
            $classRoom = ClassRoom::create(['name' => 'Kelas Default']);
        }

        Student::create([
            'rfid_uid' => 'A1B2C3D4',
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'class_room_id' => $classRoom->id,
        ]);

        Student::create([
            'rfid_uid' => 'E5F6G7H8',
            'name' => 'Siti Rahma',
            'phone' => '089876543210',
            'class_room_id' => $classRoom->id,
        ]);
    }
}
