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
            $table->id('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->boolean('approved')->default(false);            
            $table->rememberToken(); // is used to prevent cookie hijacking. changes cookies when someone logs in/out. is here by default
            //$table->timestamps(); //here by default. don't need it in users table

            $table->foreign('role_id')->references('role_id')->on('roles');//adds foreign key constraint

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
