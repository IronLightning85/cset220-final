<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seed Roles Table with Default Roles
        DB::table('roles')->insert([
            ['role_name' => 'Admin', 'level' => 1],
            ['role_name' => 'Supervisor', 'level' => 2],
            ['role_name' => 'Doctor', 'level' => 3],
            ['role_name' => 'Caregiver', 'level' => 4],
            ['role_name' => 'Family', 'level' => 5],
            ['role_name' => 'Patient', 'level' => 6],
        ]);

        DB::table('patient_groups')->insert([
            ['name' => "Independant", "description" => "Can manage own affairs"],
            ['name' => "Assisted Living", "description" => "Needs daily check in"],
            ['name' => "Memory Care", "description" => "Needs Daily Memory Excercises"],
            ['name' => "Palliative", "description" => "Terminal. Focus on comfort/quality of life"],
        ]);
    }
}

// php artisan db:seed --class=RoleSeeder

//kept seperte for future problems