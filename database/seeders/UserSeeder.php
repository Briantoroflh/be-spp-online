<?php

namespace Database\Seeders;

use App\Models\Officer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'classes_id' => DB::table('classes')->inRandomOrder()->value('id_classes'),
            'nisn'       => 1234567890,
            'nis'        => 12345678,
            'password'   => Hash::make('password123'),
            'email'      => 'siswa@example.com',
            'name'       => 'Budi Santoso',
            'alamat'     => 'Jl. Merdeka No. 10, Jakarta',
            'no_telp'    => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Officer::create([
            'username'   => 'admin1',
            'password'   => Hash::make('password123'),
            'email'      => 'admin@example.com',
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Officer::create([
            'username'   => 'officer1',
            'password'   => Hash::make('password123'),
            'email'      => 'officer@example.com',
            'role'       => 'officer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
