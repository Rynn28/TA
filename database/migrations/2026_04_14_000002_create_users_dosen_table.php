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
        // Hanya buat tabel jika belum ada
        if (!Schema::hasTable('users_dosen')) {
            Schema::create('users_dosen', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('nama');
                $table->string('nip')->unique()->nullable();
                $table->string('nidn')->unique()->nullable();
                $table->string('prodi')->nullable();
                $table->string('foto')->nullable();
                $table->enum('role', ['dosen'])->default('dosen');
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
        Schema::dropIfExists('users_dosen');
    }
};
