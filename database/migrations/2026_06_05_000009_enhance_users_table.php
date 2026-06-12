<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(1)->comment('1=active, 0=inactive, 2=banned')->after('role');
            $table->text('bio')->nullable()->after('status');
            $table->string('phone', 20)->nullable()->after('bio');
            $table->string('address')->nullable()->after('phone');
            $table->timestamp('last_login_at')->nullable()->after('address');
            $table->index('status');
            $table->index(['role', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['role', 'status']);
            $table->dropColumn(['status', 'bio', 'phone', 'address', 'last_login_at']);
        });
    }
};
