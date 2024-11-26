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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patient_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id')->nullable(true)->default(null);
            $table->string('emergency_contact');
            $table->string('contact_relation');
            $table->string('family_code');
            $table->dateTime('admission_date')->nullable(true)->default(null);
            $table->decimal('total_amount_due', 10, 2)->default(0.00); // Add the field for total amount due

            $table->foreign('user_id')->references('user_id')->on('users'); // Set foreign key constraint
            $table->foreign('group_id')->references('group_id')->on('patient_groups'); // Set foreign key constraint

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
