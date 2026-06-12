<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komentar', function (Blueprint $table) {
            if (!Schema::hasColumn('komentar', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])
                    ->default('pending')
                    ->after('isi_komentar');
            }
            $table->index('status');
            $table->index('artikel_id');
        });
    }

    public function down(): void
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->dropIndex(['status', 'artikel_id']);
            $table->dropColumnIfExists('status');
        });
    }
};
