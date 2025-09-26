<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Superadmin User
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Guru User
        User::create([
            'name' => 'Guru Matematika',
            'email' => 'guru@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'guru',
            'email_verified_at' => now(),
        ]);

        // Create Siswa User
        User::create([
            'name' => 'Siswa Kelas 10A',
            'email' => 'siswa@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'siswa',
            'email_verified_at' => now(),
        ]);

        // Create Sarpras User
        User::create([
            'name' => 'Staff Sarpras',
            'email' => 'sarpras@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'sarpras',
            'email_verified_at' => now(),
        ]);
    }
}
