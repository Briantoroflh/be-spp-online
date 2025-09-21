<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = User::role("Student")->first();

        Student::create([
            'user_uuid' => $student->uuid,
            'name' => 'Rusdi gaming',
            'nisn' => '0987654567',
            'nik' => '098765678',
            'age' => 14,
            'address' => 'Jasindo',
            'classes' => 'XI',
            'major' => 'RPL'
        ]);
    }
}
