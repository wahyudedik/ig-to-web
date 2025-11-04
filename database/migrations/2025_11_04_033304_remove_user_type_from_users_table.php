<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove user_type column - now using Spatie Permission roles only
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop index first if it exists
            try {
                $table->dropIndex(['user_type']);
            } catch (\Exception $e) {
                // Index might not exist, ignore
            }
            
            // Drop the column
            if (Schema::hasColumn('users', 'user_type')) {
                $table->dropColumn('user_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Restore user_type column for rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type', 50)->default('siswa')->after('password');
            $table->index('user_type');
        });
    }
};
