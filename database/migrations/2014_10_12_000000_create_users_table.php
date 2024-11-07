<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phone');
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('password');
            $table->foreign('roll_id')->references('roll_id')->on('roles');            
            $table->rememberToken(); // is used to prevent cookie hijacking. changes cookies when someone logs in/out. is here by default
          //$table->timestamps(); //here by default. don't need it in users table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
