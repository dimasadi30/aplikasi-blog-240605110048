<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('query', 255)->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->integer('results_count')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            
            $table->index(['query', 'created_at'], 'idx_search_query_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
