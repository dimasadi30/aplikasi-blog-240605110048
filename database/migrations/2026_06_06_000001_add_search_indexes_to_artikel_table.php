<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            // Index for status filtering (most critical)
            $table->index('status', 'idx_artikel_status');
            
            // Index for category filtering
            $table->index('id_kategori', 'idx_artikel_kategori');
            
            // Index for author filtering
            $table->index('id_penulis', 'idx_artikel_penulis');
            
            // Index for date sorting
            $table->index('created_at', 'idx_artikel_created_at');
            
            // Composite index for common query patterns
            $table->index(['status', 'created_at'], 'idx_artikel_status_created');
            $table->index(['status', 'id_kategori'], 'idx_artikel_status_kategori');
        });
        
        // Add FULLTEXT index for MySQL (InnoDB supports FULLTEXT since 5.6)
        // This enables efficient text search with relevance scoring
        DB::statement('ALTER TABLE artikel ADD FULLTEXT INDEX ft_artikel_search (judul, isi)');
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropIndex('idx_artikel_status');
            $table->dropIndex('idx_artikel_kategori');
            $table->dropIndex('idx_artikel_penulis');
            $table->dropIndex('idx_artikel_created_at');
            $table->dropIndex('idx_artikel_status_created');
            $table->dropIndex('idx_artikel_status_kategori');
        });
        
        DB::statement('ALTER TABLE artikel DROP INDEX ft_artikel_search');
    }
};
