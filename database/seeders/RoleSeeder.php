<?php

namespace Database\Seeders;

use App\Models\OfficerRole;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'for manage all data' 
        ]);

        OfficerRole::create([
            'officer_uuid' => DB::table('officers')->inRandomOrder()->value('uuid'),
            'role_uuid' => DB::table('roles')->inRandomOrder()->value('uuid')
        ]);
    }
}
