<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komentar', function (Blueprint $table) {
            if (!Schema::hasColumn('komentar', 'nama_tamu')) {
                $table->string('nama_tamu', 100)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('komentar', 'email_tamu')) {
                $table->string('email_tamu', 100)->nullable()->after('nama_tamu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->dropColumnIfExists(['nama_tamu', 'email_tamu']);
        });
    }
};
