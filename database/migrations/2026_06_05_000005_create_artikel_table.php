<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('artikel')) {
            Schema::create('artikel', function (Blueprint $table) {
                $table->id();
                $table->string('judul', 255);
                $table->string('slug', 255)->unique();
                $table->longText('isi');
                $table->string('gambar');
                $table->unsignedBigInteger('id_penulis');
                $table->unsignedBigInteger('id_kategori');
                $table->enum('status', ['draft', 'publish'])->default('draft');
                $table->string('hari_tanggal', 100)->nullable();
                $table->timestamps();

                $table->foreign('id_penulis')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('id_kategori')->references('id')->on('kategori_artikel')->onDelete('restrict');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};