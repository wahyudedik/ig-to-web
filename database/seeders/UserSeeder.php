<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Superadmin User (Only one superadmin)
        $superadmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@sekolah.com',
            'password' => Hash::make('password'),
            'user_type' => 'superadmin',
            'email_verified_at' => now(),
            'is_verified_by_admin' => true,
        ]);

        // Assign superadmin role
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superadmin->assignRole($superadminRole);
    }
}
