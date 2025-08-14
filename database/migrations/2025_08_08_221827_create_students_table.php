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
            $table->uuid('classes_id');
            $table->char('nisn', 10)->unique();
            $table->char('nis', 8)->unique();
            $table->string('name');
            $table->string('alamat');
            $table->string('no_telp', 13);
            $table->timestamps();

            $table->foreign('classes_id')->references('id_classes')->on('classes')->cascadeOnDelete();
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
