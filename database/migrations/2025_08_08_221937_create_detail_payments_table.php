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
        Schema::create('detail_payments', function (Blueprint $table) {
            $table->uuid('id_detail_payment')->primary();
            $table->uuid('payment_id');
            $table->uuid('bill_id');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('payment_id')->references('id_payment')->on('payments')->cascadeOnDelete();
            $table->foreign('bill_id')->references('id_bill')->on('bills')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_payments');
    }
};
