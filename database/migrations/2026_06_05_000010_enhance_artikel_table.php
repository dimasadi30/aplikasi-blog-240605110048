<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            if (!Schema::hasColumn('artikel', 'status')) {
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('hari_tanggal');
            }
            if (!Schema::hasColumn('artikel', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('artikel', 'view_count')) {
                $table->unsignedBigInteger('view_count')->default(0)->after('published_at');
            }
            if (!Schema::hasColumn('artikel', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('isi');
            }
            if (!Schema::hasColumn('artikel', 'featured')) {
                $table->boolean('featured')->default(false)->after('excerpt');
            }
            
            // Add indexes
            $table->index('status');
            $table->index('id_penulis');
            $table->index('id_kategori');
            $table->index('published_at');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropIndex(['status', 'id_penulis', 'id_kategori', 'published_at', 'featured']);
            $table->dropColumnIfExists(['status', 'published_at', 'view_count', 'excerpt', 'featured']);
        });
    }
};
