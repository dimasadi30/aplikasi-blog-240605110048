<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nama_depan')) {
                $table->string('nama_depan', 100)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'nama_belakang')) {
                $table->string('nama_belakang', 100)->nullable()->after('nama_depan');
            }
            if (!Schema::hasColumn('users', 'user_name')) {
                $table->string('user_name', 50)->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'penulis', 'tamu'])->default('tamu')->after('password');
            }
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->default('default.png')->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'user_name')) {
                $table->dropUnique(['user_name']);
                $table->dropColumn('user_name');
            }
            if (Schema::hasColumn('users', 'nama_belakang')) {
                $table->dropColumn('nama_belakang');
            }
            if (Schema::hasColumn('users', 'nama_depan')) {
                $table->dropColumn('nama_depan');
            }
        });
    }
};