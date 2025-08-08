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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id_payment')->primary();
            $table->uuid('student_id');
            $table->dateTime('date_payment');
            $table->string('method_payment');
            $table->integer('total_amount');
            $table->timestamps();

            $table->foreign('student_id')->references('id_student')->on('students')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
