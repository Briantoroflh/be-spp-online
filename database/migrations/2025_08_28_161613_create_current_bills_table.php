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
            $table->string('month');
            $table->date('start_date');
            $table->date('due_date');
            $table->enum('status', ['belum lunas', 'lunas', 'jatuh tempo'])->default('belum lunas');
            $table->string('description')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('bill_uuid')->references('uuid')->on('bills')->onDelete('cascade');
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
