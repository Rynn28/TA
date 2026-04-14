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
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn(['name']);
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn(['email']);
            }
            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn(['password']);
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn(['remember_token']);
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn(['email_verified_at']);
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('users', 'nama')) {
                $table->string('nama')->after('id');
            }
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->unique()->nullable()->after('nama');
            }
            if (!Schema::hasColumn('users', 'nidn')) {
                $table->string('nidn')->unique()->nullable()->after('nip');
            }
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('nidn');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('staff')->after('foto');
            }
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
