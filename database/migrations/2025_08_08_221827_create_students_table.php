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
            $table->uuid('id_student')->primary();
            $table->char('nisn', 10)->unique();
            $table->char('nis', 8)->unique();
            $table->string('name');
            $table->uuid('classes_id');
            $table->string('alamat');
            $table->string('no_telp', 13);
            $table->uuid('users_id')->nullable();
            $table->timestamps();

            $table->foreign('classes_id')->references('id_classes')->on('classes')->cascadeOnDelete();
            $table->foreign('users_id')->references('id_users')->on('users')->nullOnDelete();
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
