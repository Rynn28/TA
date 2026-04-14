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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('user_type')->nullable(); // 'dosen' atau 'staff'
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->decimal('durasi_jam', 5, 2)->default(0); // durasi dalam jam (misal 7.5)
            $table->string('keterangan')->nullable(); // hadir, sakit, izin, dll
            $table->timestamps();

            // Unique constraint agar 1 user hanya bisa 1 record per hari
            $table->unique(['user_id', 'tanggal']);

            // Index untuk query cepat
            $table->index('user_id');
            $table->index('tanggal');
            $table->index(['user_type', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
