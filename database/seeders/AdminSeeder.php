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
        //Seed Users Dstabase with Admin Account
        DB::table('users')->insert([
            'user_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Shady Shoals',
            'phone' => '888-245-5618',
            'dob' => '1995-07-11',
            'email' => 'admin@shadyshoals.com',
            'password' => Hash::make('Admin'),  // we have to hash password or it will fail
            'role_id' => 1, 
            'approved' => 1,
        ]);
        
        //Seed Employees Table with Admin Account
        DB::table('employees')->insert([
        'id'=> 1,
        'user_id' => 1,
        'salary' => 50000,
    ]);
    }
}

// php artisan db:seed --class=AdminSeeder
