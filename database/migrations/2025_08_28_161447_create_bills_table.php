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
            $table->uuid('uuid')->primary();
            $table->uuid('student_uuid');
            $table->uuid('detail_bill_uuid');
            $table->integer('year');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['student_uuid', 'detail_bill_uuid']);

            $table->foreign('student_uuid')->references('uuid')->on('students')->cascadeOnDelete();
            $table->foreign('detail_bill_uuid')->references('uuid')->on('detail_bills')->cascadeOnDelete();
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
