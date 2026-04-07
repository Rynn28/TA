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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'password', 'remember_token', 'email_verified_at']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('nip')->unique()->nullable()->after('nama');
            $table->string('nidn')->unique()->nullable()->after('nip');
            $table->string('foto')->nullable()->after('nidn');
            $table->string('role')->default('staff')->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'nip', 'nidn', 'foto', 'role']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
        });
    }
};
