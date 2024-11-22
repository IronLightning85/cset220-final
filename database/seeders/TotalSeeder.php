<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TotalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        //Seed Users Dstabase with Supervisor Account
        DB::table('users')->insert([
            'user_id' => 2,
            'first_name' => 'Flats',
            'last_name' => 'Flounder',
            'phone' => '987-235-9818',
            'dob' => '1995-02-11',
            'email' => 'flats90@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2, 
            'approved' => 1,
        ]);
        

        DB::table('employees')->insert([
        'employee_id'=> 2,
        'user_id' => 2,
        'salary' => 50000,
    ]);




//Doctors
    DB::table('users')->insert([
        'user_id' => 3,
        'first_name' => 'Bubble',
        'last_name' => 'Buddy',
        'phone' => '987-235-7778',
        'dob' => '1990-01-20',
        'email' => 'Bubble@gmail.com',
        'password' => Hash::make('password'),  
        'role_id' => 3, 
        'approved' => 1,
    ]);
    

    DB::table('employees')->insert([
    'employee_id'=> 3,
    'user_id' => 3,
    'salary' => 50000,
]);





DB::table('users')->insert([
    'user_id' => 4,
    'first_name' => 'Gill',
    'last_name' => 'Gilliam',
    'phone' => '104-333-1818',
    'dob' => '1990-08-03',
    'email' => 'GillBill@gmail.com',
    'password' => Hash::make('password'),  
    'role_id' => 4, 
    'approved' => 0,
]);


DB::table('employees')->insert([
'employee_id'=> 4,
'user_id' => 4,
'salary' => 50000,
]);




//family members
DB::table('users')->insert([
    'user_id' => 5,
    'first_name' => 'Perch',
    'last_name' => 'Perkins',
    'phone' => '287-235-8472',
    'dob' => '1990-02-11',
    'email' => 'pperkins@gmail.com',
    'password' => Hash::make('password'), 
    'role_id' => 5, 
    'approved' => 0,
]);


DB::table('family_members')->insert([
'family_member_id'=> 5,
'patient_relation' => 'Dad',
'user_id' => 5,
]);





DB::table('users')->insert([
    'user_id' => 6,
    'first_name' => 'Patrick',
    'last_name' => 'Star',
    'phone' => '321-654-9870',
    'dob' => '1985-08-17',
    'email' => 'patrickstar@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => 5,
    'approved' => 1,
]);



DB::table('family_members')->insert([
    'family_member_id'=> 6,
    'patient_relation' => 'Dad',
    'user_id' => 6,
    ]);





//caregivers
DB::table('users')->insert([
    'user_id' => 7,
    'first_name' => 'Squidward',
    'last_name' => 'Tentacles',
    'phone' => '555-123-4567',
    'dob' => '1978-04-15',
    'email' => 'squidward@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => 4,
    'approved' => 0,
]);

DB::table('employees')->insert([
    'employee_id' => 7,
    'user_id' => 7,
    'salary' => 55000,
]);



DB::table('users')->insert([
    'user_id' => 8,
    'first_name' => 'Sandy',
    'last_name' => 'Cheeks',
    'phone' => '888-777-6666',
    'dob' => '1992-06-21',
    'email' => 'sandycheeks@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => 4,
    'approved' => 1,
]);

DB::table('employees')->insert([
    'employee_id' => 8,
    'user_id' => 8,
    'salary' => 60000,
]);


//patients
DB::table('users')->insert([
    'user_id' => 9,
    'first_name' => 'Eugene',
    'last_name' => 'Krabs',
    'phone' => '999-111-2222',
    'dob' => '1952-11-30',
    'email' => 'mrkrabs@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => 6,
    'approved' => 1,
]);

DB::table('patients')->insert([
    'patient_id' => 9,
    'user_id' => 9,
    'emergency_contact' => 'SpongeBob',
    'contact_relation' => 'Brother',
    'family_code' => 1234,
    'admission_date' => '2024-02-16',
    'total_amount_due' => 100,

    
]);




DB::table('users')->insert([
    'user_id' => 10,
    'first_name' => 'Pearl',
    'last_name' => 'Krabs',
    'phone' => '444-555-6666',
    'dob' => '2003-03-16',
    'email' => 'pearlkrabs@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => 6,
    'approved' => 1,
]);

DB::table('patients')->insert([
    'patient_id' => 10,
    'user_id' => 10,
    'emergency_contact' => 'Mermaid Man',
    'contact_relation' => 'Grandfather',
    'family_code' => 4321,
    'admission_date' => '2024-03-16',
    'total_amount_due' => 100,

]);
}

}



// php artisan db:seed --class=TotalSeeder
