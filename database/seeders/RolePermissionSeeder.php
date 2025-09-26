<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $superadminRole = Role::create([
            'name' => 'superadmin',
            'display_name' => 'Super Administrator',
            'description' => 'Full system access with user management capabilities',
            'is_active' => true,
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Full access to all modules except user management',
            'is_active' => true,
        ]);

        $guruRole = Role::create([
            'name' => 'guru',
            'display_name' => 'Guru',
            'description' => 'Access to teaching modules and student data',
            'is_active' => true,
        ]);

        $siswaRole = Role::create([
            'name' => 'siswa',
            'display_name' => 'Siswa',
            'description' => 'Limited access to profile and activities',
            'is_active' => true,
        ]);

        $sarprasRole = Role::create([
            'name' => 'sarpras',
            'display_name' => 'Sarpras',
            'description' => 'Access to facilities and infrastructure modules',
            'is_active' => true,
        ]);

        // Create Permissions
        $permissions = [
            // User Management
            ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'users.read', 'display_name' => 'Read Users', 'module' => 'users'],
            ['name' => 'users.update', 'display_name' => 'Update Users', 'module' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'users'],

            // Instagram Module
            ['name' => 'instagram.create', 'display_name' => 'Create Instagram Posts', 'module' => 'instagram'],
            ['name' => 'instagram.read', 'display_name' => 'Read Instagram Posts', 'module' => 'instagram'],
            ['name' => 'instagram.update', 'display_name' => 'Update Instagram Posts', 'module' => 'instagram'],
            ['name' => 'instagram.delete', 'display_name' => 'Delete Instagram Posts', 'module' => 'instagram'],

            // Pages Module
            ['name' => 'pages.create', 'display_name' => 'Create Pages', 'module' => 'pages'],
            ['name' => 'pages.read', 'display_name' => 'Read Pages', 'module' => 'pages'],
            ['name' => 'pages.update', 'display_name' => 'Update Pages', 'module' => 'pages'],
            ['name' => 'pages.delete', 'display_name' => 'Delete Pages', 'module' => 'pages'],

            // Guru Module
            ['name' => 'guru.create', 'display_name' => 'Create Guru', 'module' => 'guru'],
            ['name' => 'guru.read', 'display_name' => 'Read Guru', 'module' => 'guru'],
            ['name' => 'guru.update', 'display_name' => 'Update Guru', 'module' => 'guru'],
            ['name' => 'guru.delete', 'display_name' => 'Delete Guru', 'module' => 'guru'],

            // Siswa Module
            ['name' => 'siswa.create', 'display_name' => 'Create Siswa', 'module' => 'siswa'],
            ['name' => 'siswa.read', 'display_name' => 'Read Siswa', 'module' => 'siswa'],
            ['name' => 'siswa.update', 'display_name' => 'Update Siswa', 'module' => 'siswa'],
            ['name' => 'siswa.delete', 'display_name' => 'Delete Siswa', 'module' => 'siswa'],

            // OSIS Module
            ['name' => 'osis.create', 'display_name' => 'Create OSIS Data', 'module' => 'osis'],
            ['name' => 'osis.read', 'display_name' => 'Read OSIS Data', 'module' => 'osis'],
            ['name' => 'osis.update', 'display_name' => 'Update OSIS Data', 'module' => 'osis'],
            ['name' => 'osis.delete', 'display_name' => 'Delete OSIS Data', 'module' => 'osis'],

            // Lulus Module
            ['name' => 'lulus.create', 'display_name' => 'Create Lulus Data', 'module' => 'lulus'],
            ['name' => 'lulus.read', 'display_name' => 'Read Lulus Data', 'module' => 'lulus'],
            ['name' => 'lulus.update', 'display_name' => 'Update Lulus Data', 'module' => 'lulus'],
            ['name' => 'lulus.delete', 'display_name' => 'Delete Lulus Data', 'module' => 'lulus'],

            // Sarpras Module
            ['name' => 'sarpras.create', 'display_name' => 'Create Sarpras Data', 'module' => 'sarpras'],
            ['name' => 'sarpras.read', 'display_name' => 'Read Sarpras Data', 'module' => 'sarpras'],
            ['name' => 'sarpras.update', 'display_name' => 'Update Sarpras Data', 'module' => 'sarpras'],
            ['name' => 'sarpras.delete', 'display_name' => 'Delete Sarpras Data', 'module' => 'sarpras'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to roles
        $allPermissions = Permission::all();
        $superadminRole->permissions()->attach($allPermissions);

        // Admin gets all permissions except user management
        $adminPermissions = Permission::where('module', '!=', 'users')->get();
        $adminRole->permissions()->attach($adminPermissions);

        // Guru gets limited permissions
        $guruPermissions = Permission::whereIn('module', ['guru', 'siswa', 'pages'])
            ->whereIn('name', ['guru.read', 'guru.update', 'siswa.read', 'pages.read'])
            ->get();
        $guruRole->permissions()->attach($guruPermissions);

        // Siswa gets very limited permissions
        $siswaPermissions = Permission::whereIn('name', ['siswa.read', 'pages.read'])
            ->get();
        $siswaRole->permissions()->attach($siswaPermissions);

        // Sarpras gets sarpras module permissions
        $sarprasPermissions = Permission::where('module', 'sarpras')->get();
        $sarprasRole->permissions()->attach($sarprasPermissions);
    }
}
