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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->bigInteger('nisn')->unique();
            $table->bigInteger('nipd')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age');
            $table->string('classes');
            $table->string('major');
            $table->integer('code_otp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
