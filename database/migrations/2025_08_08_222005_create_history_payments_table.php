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
        Schema::create('history_payments', function (Blueprint $table) {
            $table->uuid('id_history_payment')->primary();
            $table->uuid('detail_payment_id');
            $table->enum('status', ['success', 'failed']);
            $table->string('message')->nullable();
            $table->timestamps();

            $table->foreign('detail_payment_id')->references('id_detail_payment')->on('detail_payments')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_payments');
    }
};
