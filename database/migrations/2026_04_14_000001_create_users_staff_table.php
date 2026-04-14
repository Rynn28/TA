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
        if (!Schema::hasTable('users_staff')) {
            Schema::create('users_staff', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('nama');
                $table->string('nip')->unique()->nullable();
                $table->string('nidn')->unique()->nullable();
                $table->string('foto')->nullable();
                $table->enum('role', ['staff', 'teknisi'])->default('staff');
                $table->string('password')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_staff');
    }
};
