<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Changes user_type from ENUM to VARCHAR to support custom roles
     */
    public function up(): void
    {
        // For MySQL, we need to use raw SQL to alter ENUM to VARCHAR
        // Laravel's Schema builder doesn't support changing ENUM directly
        // For SQLite (testing), we skip the MODIFY statement as SQLite doesn't support it

        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            // Step 1: Modify column from ENUM to VARCHAR(50) for MySQL/MariaDB
            DB::statement("ALTER TABLE `users` MODIFY `user_type` VARCHAR(50) DEFAULT 'siswa'");
        } elseif ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY, and if this is a fresh migration,
            // the column should already be VARCHAR. Skip if in testing environment.
            // For existing SQLite databases, you'd need to recreate the table.
            // For now, we'll just ensure the index exists.
        } else {
            // For other databases (PostgreSQL, etc.), use Laravel's change method
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type', 50)->default('siswa')->change();
            });
        }

        // Step 2: Add index for better performance (optional but recommended)
        // For SQLite, try to add index (will fail gracefully if exists)
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->index('user_type');
            });
        } catch (\Exception $e) {
            // Index might already exist, ignore error
            // This is safe for SQLite testing environment
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Revert back to ENUM (restoring original restriction)
     */
    public function down(): void
    {
        // Remove index first
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['user_type']);
            });
        } catch (\Exception $e) {
            // Index might not exist, ignore
        }

        // Revert to ENUM with original values (MySQL/MariaDB only)
        // NOTE: This will fail if there are custom role values in the database
        // In that case, you'd need to clean up custom roles first
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE `users` MODIFY `user_type` ENUM('superadmin', 'admin', 'guru', 'siswa', 'sarpras') DEFAULT 'siswa'");
        }
        // SQLite doesn't support MODIFY, skip revert for SQLite
    }
};
