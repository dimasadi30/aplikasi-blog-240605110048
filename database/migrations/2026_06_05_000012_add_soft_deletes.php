<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            if (!Schema::hasColumn('artikel', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('komentar', function (Blueprint $table) {
            if (!Schema::hasColumn('komentar', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            if (Schema::hasColumn('artikel', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('komentar', function (Blueprint $table) {
            if (Schema::hasColumn('komentar', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
