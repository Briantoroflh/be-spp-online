<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Budi Santoso',
            'nisn' => 1234567890,
            'nipd' => 20250001,
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'age' => 16,
            'classes' => 'XI RPL 1',
            'major' => 'Rekayasa Perangkat Lunak',
        ]);
    }
}
