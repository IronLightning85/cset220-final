<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_daily_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->boolean('morning')->default(false);
            $table->boolean('afternoon')->default(false);
            $table->boolean('night')->default(false);
            $table->boolean('breakfast')->default(false);
            $table->boolean('lunch')->default(false);
            $table->boolean('dinner')->default(false);
            $table->date('date');
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_daily_activities');
    }
};
