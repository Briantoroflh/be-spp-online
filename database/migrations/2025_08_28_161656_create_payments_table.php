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
            $table->uuid('uuid')->primary();
            $table->uuid('current_bill_uuid');
            $table->uuid('officer_uuid');
            $table->integer('nominal_payment');
            $table->string('method_payment');
            $table->dateTime('payment_date');
            $table->enum('status', ['berhasil', 'gagal']);
            $table->timestamps();

            $table->foreign('current_bill_uuid')->references('uuid')->on('current_bills')->cascadeOnDelete();
            $table->foreign('officer_uuid')->references('uuid')->on('officers')->cascadeOnDelete();
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
