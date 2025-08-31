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
        Schema::create('officer_roles', function (Blueprint $table) {
            $table->uuid('officer_uuid');
            $table->uuid('role_uuid');
            $table->timestamps();
            $table->primary(['officer_uuid', 'role_uuid']);

            $table->foreign('officer_uuid')->references('uuid')->on('officers')->cascadeOnDelete();
            $table->foreign('role_uuid')->references('uuid')->on('roles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officer_roles');
    }
};
