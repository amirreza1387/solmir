<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('phone');
            $table->index('role');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index(['user_id', 'status']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->index('status');
            $table->index('priority');
            $table->index(['user_id', 'status']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index('is_read');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['is_featured', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['role']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['is_read']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex(['is_featured', 'created_at']);
        });
    }
};
