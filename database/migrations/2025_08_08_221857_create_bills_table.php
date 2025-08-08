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
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id_bill')->primary();
            $table->uuid('student_id');
            $table->uuid('spp_id');
            $table->tinyInteger('month');
            $table->year('year');
            $table->integer('amount');
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('student_id')->references('id_student')->on('students')->cascadeOnDelete();
            $table->foreign('spp_id')->references('id_spp')->on('spps')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
