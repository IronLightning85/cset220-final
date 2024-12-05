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

            DB::table('users')->insert([
                'user_id' => 18,
                'first_name' => 'King',
                'last_name' => 'Poseidon',
                'phone' => '987-211-9818',
                'dob' => '1989-12-24',
                'email' => 'KingPoseidon@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, 
                'approved' => 1,
            ]);
            

            DB::table('employees')->insert([
            'employee_id'=> 13,
            'user_id' => 18,
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
        'role_id' => 3, 
        'approved' => 0,
    ]);


    DB::table('employees')->insert([
    'employee_id'=> 4,
    'user_id' => 4,
    'salary' => 50000,
    ]);

    DB::table('users')->insert([
        'user_id' => 19,
        'first_name' => 'Robot',
        'last_name' => 'Mantis',
        'phone' => '488-904-4518',
        'dob' => '1986-04-01',
        'email' => 'Robotmantis@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 3,
        'approved' => 1,
    ]);

    DB::table('employees')->insert([
        'employee_id' => 11,
        'user_id' => 19,
        'salary' => 65000,
    ]);



    DB::table('users')->insert([
        'user_id' => 17,
        'first_name' => 'Sinister',
        'last_name' => 'Slug',
        'phone' => '111-554-7772',
        'dob' => '2000-01-12',
        'email' => 'slug@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 3,
        'approved' => 1,
    ]);

    DB::table('employees')->insert([
        'employee_id' => 12,
        'user_id' => 17,
        'salary' => 65000,
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


    DB::table('users')->insert([
        'user_id' => 15,
        'first_name' => 'Dirty',
        'last_name' => 'Bubble',
        'phone' => '811-354-1875',
        'dob' => '1996-06-21',
        'email' => 'Dirtybubble@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 4,
        'approved' => 1,
    ]);

    DB::table('employees')->insert([
        'employee_id' => 9,
        'user_id' => 15,
        'salary' => 50000,
    ]);

    DB::table('users')->insert([
        'user_id' => 16,
        'first_name' => 'Man',
        'last_name' => 'Ray',
        'phone' => '435-121-1152',
        'dob' => '1996-09-20',
        'email' => 'ManRay@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 4,
        'approved' => 1,
    ]);

    DB::table('employees')->insert([
        'employee_id' => 10,
        'user_id' => 16,
        'salary' => 50000,
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
        'group_id' => 1,
        'emergency_contact' => 'SpongeBob',
        'contact_relation' => 'Brother',
        'family_code' => 1234,
        'admission_date' => '2024-02-16',
        'total_amount_due' => 100,

        
    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 9,
        'patient_id' => 9,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
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
        'group_id' => 2,
        'emergency_contact' => 'Mermaid Man',
        'contact_relation' => 'Grandfather',
        'family_code' => 4321,
        'admission_date' => '2024-03-16',
        'total_amount_due' => 100,

    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 10,
        'patient_id' => 10,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
    ]);



    DB::table('users')->insert([
        'user_id' => 11,
        'first_name' => 'Gene ',
        'last_name' => 'Scallop',
        'phone' => '119-113-2345',
        'dob' => '1992-10-10',
        'email' => 'genes@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 6,
        'approved' => 1,
    ]);

    DB::table('patients')->insert([
        'patient_id' => 11,
        'user_id' => 11,
        'group_id' => 3,
        'emergency_contact' => 'Jellyfish',
        'contact_relation' => 'Lover',
        'family_code' => 5678,
        'admission_date' => '2024-09-16',
        'total_amount_due' => 50,

        
    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 11,
        'patient_id' => 11,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
    ]);




    DB::table('users')->insert([
        'user_id' => 12,
        'first_name' => 'Sea',
        'last_name' => 'Bear',
        'phone' => '455-987-0975',
        'dob' => '2001-02-24',
        'email' => 'seabear@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 6,
        'approved' => 1,
    ]);

    DB::table('patients')->insert([
        'patient_id' => 12,
        'user_id' => 12,
        'group_id' => 2,
        'emergency_contact' => 'Sea Monster',
        'contact_relation' => 'Grandfather',
        'family_code' => 1111,
        'admission_date' => '2024-01-11',
        'total_amount_due' => 150,

    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 12,
        'patient_id' => 12,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
    ]);

    DB::table('users')->insert([
        'user_id' => 13,
        'first_name' => 'Squilliam ',
        'last_name' => 'Fancyson',
        'phone' => '491-477-8865',
        'dob' => '1999-02-24',
        'email' => 'SFancyson@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 6,
        'approved' => 1,
    ]);

    DB::table('patients')->insert([
        'patient_id' => 13,
        'user_id' => 13,
        'group_id' => 4,
        'emergency_contact' => 'Barron Trump',
        'contact_relation' => 'God Son',
        'family_code' => 1110,
        'admission_date' => '2024-07-23',
        'total_amount_due' => 300,

    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 13,
        'patient_id' => 13,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
    ]);

    DB::table('users')->insert([
        'user_id' => 14,
        'first_name' => 'Dorsal',
        'last_name' => 'Dan',
        'phone' => '891-499-8995',
        'dob' => '2001-11-03',
        'email' => 'DDAN@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 6,
        'approved' => 1,
    ]);

    DB::table('patients')->insert([
        'patient_id' => 14,
        'user_id' => 14,
        'group_id' => 1,
        'emergency_contact' => 'Gill Godfrey',
        'contact_relation' => 'Father',
        'family_code' => 7654,
        'admission_date' => '2024-04-10',
        'total_amount_due' => 50,

    ]);

    DB::table('patient_daily_activities')->insert([
        'id' => 14,
        'patient_id' => 14,
        'morning' => 0,
        'afternoon' => 0,
        'night' => 0,
        'breakfast' => 0,
        'lunch' => 0,
        'dinner' => 0,
        'date' => '2024-12-1', 
    ]);



    }













    }



    // php artisan db:seed --class=TotalSeeder
