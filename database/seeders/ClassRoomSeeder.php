<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classRooms = [
            'Kelas A',
            'Kelas B',
            'Kelas C',
            'Kelas D',
        ];

        foreach ($classRooms as $name) {
            ClassRoom::create([
                'name' => $name,
            ]);
        }
    }
}
