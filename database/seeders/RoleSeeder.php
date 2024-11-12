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
        DB::table('roles')->insert([
            ['role_name' => 'Admin', 'level' => 1],
            ['role_name' => 'Supervisor', 'level' => 2],
            ['role_name' => 'Doctor', 'level' => 3],
            ['role_name' => 'Caregiver', 'level' => 4],
            ['role_name' => 'Family', 'level' => 5],
            ['role_name' => 'Patient', 'level' => 6],
        ]);
    }
}


// php artisan db:seed --class=RoleSeeder
