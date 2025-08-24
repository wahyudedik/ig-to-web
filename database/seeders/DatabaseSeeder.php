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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'user_type' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Guru User',
            'email' => 'guru@gmail.com',
            'user_type' => 'guru',
        ]);
        User::factory()->create([
            'name' => 'Siswa User',
            'email' => 'siswa@gmail.com',
            'user_type' => 'siswa',
        ]);
        User::factory()->create([
            'name' => 'Sarpras User',
            'email' => 'sarpras@gmail.com',
            'user_type' => 'sarpras',
        ]);
    }
}
