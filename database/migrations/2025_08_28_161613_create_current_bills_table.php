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
        Schema::create('current_bills', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('bill_uuid');
            $table->string('month')->index();
            $table->date('start_date');
            $table->date('due_date');
            $table->string('status')->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bill_uuid')->references('uuid')->on('bills')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_bills');
    }
};
