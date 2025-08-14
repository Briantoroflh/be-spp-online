<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::create([
            'classes_name' => 'XI RPL 3',
            'major' => 'RPL',
            'angkatan' => '12'
        ]);
    }
}
