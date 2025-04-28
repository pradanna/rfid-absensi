<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'nip' => '1234567890',
            'name' => 'John Doe',
            'tanggal_lahir' => '1980-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 1',
            'no_hp' => '081234567890',
            'user_id' => 1, // Pastikan user_id sudah ada di tabel users
        ]);

        Teacher::create([
            'nip' => '1234567891',
            'name' => 'Jane Smith',
            'tanggal_lahir' => '1985-06-10',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Contoh No. 2',
            'no_hp' => '081234567891',
            'user_id' => 2,
        ]);

        Teacher::create([
            'nip' => '1234567892',
            'name' => 'Michael Brown',
            'tanggal_lahir' => '1990-07-20',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 3',
            'no_hp' => '081234567892',
            'user_id' => 3,
        ]);

        Teacher::create([
            'nip' => '1234567893',
            'name' => 'Emily White',
            'tanggal_lahir' => '1988-03-25',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Contoh No. 4',
            'no_hp' => '081234567893',
            'user_id' => 4,
        ]);

        Teacher::create([
            'nip' => '1234567894',
            'name' => 'David Black',
            'tanggal_lahir' => '1992-11-30',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 5',
            'no_hp' => '081234567894',
            'user_id' => 5,
        ]);
    }
}
