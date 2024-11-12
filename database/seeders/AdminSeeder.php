<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'user_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Shady Shoals',
            'phone' => '888-245-5618',
            'dob' => '1995-07-11',
            'email' => 'admin@shadyshoals.com',
            'password' => 'Admin',
            // 'password' => Hash::make('Admin'),
            'role_id' => 1, 
            'approved' => 1,
        ]);
    }
}

// php artisan db:seed --class=AdminSeeder
