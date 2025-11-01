<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core system seeders
            RoleSeeder::class, // Create roles first (superadmin, admin, guru, siswa, sarpras)
            PermissionSeeder::class,
            UserSeeder::class,

            // Data management seeders
            DataManagementSeeder::class,
            MataPelajaranSeeder::class,

            // Module-specific seeders
            GuruSeeder::class,
            SiswaSeeder::class,
            KelulusanSeeder::class,
            SarprasSeeder::class,
            OSISSeeder::class,

            // Content management seeders
            MenuSeeder::class,
            PageSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
