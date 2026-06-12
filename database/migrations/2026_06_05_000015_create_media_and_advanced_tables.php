<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('filename', 255);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->string('disk', 50)->default('public');
            $table->string('path', 500);
            $table->json('metadata')->nullable();
            $table->string('alt_text')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::create('article_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikel')->onDelete('cascade');
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->unsignedTinyInteger('position')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->unique(['artikel_id', 'media_id']);
        });

        Schema::create('article_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikel')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['artikel_id', 'user_id']);
            $table->index('artikel_id');
        });

        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
            $table->unique(['model_type', 'model_id']);
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
        Schema::dropIfExists('article_likes');
        Schema::dropIfExists('article_media');
        Schema::dropIfExists('media');
    }
};
