<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleManagementController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        return view('role-management.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('module');
        return view('role-management.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            // Normalize role name: lowercase, no spaces, only alphanumeric and hyphens
            $roleName = strtolower(str_replace(' ', '', $request->name));
            $roleName = preg_replace('/[^a-z0-9-]/', '', $roleName);

            $request->merge(['name' => $roleName]);

            $request->validate([
                'name' => 'required|string|unique:roles,name|max:255|regex:/^[a-z0-9-]+$/',
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'permissions' => 'array',
            ]);

            $role = Role::create([
                'name' => $roleName,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'guard_name' => 'web',
            ]);

            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role created successfully',
                    'data' => $role
                ]);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating role: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error creating role: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('role-management.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            // Check if it's a core role
            $coreRoles = ['superadmin', 'admin', 'guru', 'siswa', 'sarpras'];
            $isCoreRole = in_array($role->name, $coreRoles);

            // Normalize role name: lowercase, no spaces, only alphanumeric and hyphens
            $roleName = strtolower(str_replace(' ', '', $request->name));
            $roleName = preg_replace('/[^a-z0-9-]/', '', $roleName);

            // Prevent changing core roles name (but allow updating permissions and other fields)
            if ($isCoreRole && $roleName !== $role->name) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot change name of core system role. You can only update display name, description, and permissions.'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Cannot change name of core system role');
            }

            $request->merge(['name' => $roleName]);

            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id . '|max:255|regex:/^[a-z0-9-]+$/',
                'display_name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'permissions' => 'array',
            ]);

            $role->update([
                'name' => $roleName,
                'display_name' => $request->display_name ?? $role->display_name,
                'description' => $request->description ?? $role->description,
            ]);

            $role->syncPermissions($request->permissions ?? []);

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role updated successfully',
                    'data' => $role
                ]);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating role: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of core roles
        if (in_array($role->name, ['superadmin', 'admin', 'guru', 'sarpras'])) {
            return back()->with('error', 'Cannot delete core system role');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }

    public function assignUsers(Role $role)
    {
        $users = User::all();
        $roleUsers = $role->users->pluck('id')->toArray();

        return view('role-management.assign-users', compact('role', 'users', 'roleUsers'));
    }

    public function syncUsers(Request $request, Role $role)
    {
        try {
            $request->validate([
                'user_ids' => 'array',
            ]);

            $role->users()->sync($request->user_ids ?? []);

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Users assigned successfully',
                    'data' => [
                        'role' => $role,
                        'user_count' => $role->users()->count()
                    ]
                ]);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Users assigned successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error assigning users: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error assigning users: ' . $e->getMessage());
        }
    }
}
