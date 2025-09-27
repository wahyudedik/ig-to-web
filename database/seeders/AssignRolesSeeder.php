<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign roles to existing users based on their user_type
        $userRoles = [
            'superadmin@sekolah.com' => 'superadmin',
            'admin@sekolah.com' => 'admin',
            'guru@sekolah.com' => 'guru',
            'siswa@sekolah.com' => 'siswa',
            'sarpras@sekolah.com' => 'sarpras',
        ];

        foreach ($userRoles as $email => $roleName) {
            $user = User::where('email', $email)->first();
            $role = Role::where('name', $roleName)->first();

            if ($user && $role) {
                $user->assignRole($role);
                echo "Assigned role '{$roleName}' to user '{$user->name}'\n";
            }
        }
    }
}
