<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dateTime('last_cost_update')->nullable()->after('admission_date');
        });
    }
    
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('last_cost_update');
        });
    }
};
