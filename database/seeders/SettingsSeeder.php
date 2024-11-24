<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->insert([
            'key' => 'last_update',
            'value' => now(), // Initial value for last update
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
