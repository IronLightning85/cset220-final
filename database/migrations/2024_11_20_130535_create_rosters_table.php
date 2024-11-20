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
        Schema::create('rosters', function (Blueprint $table) {
            $table->id('roster_id');
            $table->date("date");
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('caregiver_id_1');
            $table->unsignedBigInteger('caregiver_id_2');
            $table->unsignedBigInteger('caregiver_id_3');
            $table->unsignedBigInteger('caregiver_id_4');

            // set foreign key contraints
            $table->foreign('supervisor_id')->references('employee_id')->on('employees');
            $table->foreign('doctor_id')->references('employee_id')->on('employees');
            $table->foreign('caregiver_id_1')->references('employee_id')->on('employees');
            $table->foreign('caregiver_id_2')->references('employee_id')->on('employees');
            $table->foreign('caregiver_id_3')->references('employee_id')->on('employees');
            $table->foreign('caregiver_id_4')->references('employee_id')->on('employees');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
