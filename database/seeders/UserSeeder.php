<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'johndoe',
            'password' => Hash::make('password123'), // Password terenkripsi
        ]);

        User::create([
            'username' => 'janesmith',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'username' => 'michaelbrown',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'username' => 'emilywhite',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'username' => 'davidblack',
            'password' => Hash::make('password123'),
        ]);
    }
}
