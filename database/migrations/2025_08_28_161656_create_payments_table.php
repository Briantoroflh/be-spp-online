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
            $table->string("code_payment");
            $table->uuid('current_bill_uuid');
            $table->uuid('user_uuid');
            $table->integer('nominal_payment');
            $table->string('method_payment')->nullable()->index();
            $table->date('payment_date')->index();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['current_bill_uuid', 'user_uuid']);

            $table->foreign('current_bill_uuid')->references('uuid')->on('current_bills')->cascadeOnDelete();
            $table->foreign('user_uuid')->references('uuid')->on('users')->cascadeOnDelete();
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
