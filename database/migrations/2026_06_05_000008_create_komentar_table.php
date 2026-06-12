<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('komentar')) {
            Schema::create('komentar', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('artikel_id');
                $table->unsignedBigInteger('user_id');
                $table->text('isi_komentar');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();

                $table->foreign('artikel_id')->references('id')->on('artikel')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};