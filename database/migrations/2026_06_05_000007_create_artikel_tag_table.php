<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('artikel_tag')) {
            Schema::create('artikel_tag', function (Blueprint $table) {
                $table->unsignedBigInteger('artikel_id');
                $table->unsignedBigInteger('tag_id');
                $table->primary(['artikel_id', 'tag_id']);

                $table->foreign('artikel_id')->references('id')->on('artikel')->onDelete('cascade');
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel_tag');
    }
};