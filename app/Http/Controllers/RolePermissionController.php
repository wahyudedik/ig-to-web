<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('admin.role-permissions.index', compact('roles', 'permissions'));
    }


    public function createRole(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'array'
            ]);

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            if ($request->has('permissions')) {
                $role->givePermissionTo($request->permissions);
            }

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role created successfully',
                    'data' => $role
                ]);
            }

            return redirect()->back()->with('success', 'Role created successfully.');
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

    public function updateRole(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'permissions' => 'array'
            ]);

            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role updated successfully',
                    'data' => $role
                ]);
            }

            return redirect()->back()->with('success', 'Role updated successfully.');
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

    public function deleteRole(Role $role)
    {
        try {
            // Prevent deletion of core roles
            if (in_array($role->name, ['superadmin', 'admin', 'guru', 'sarpras', 'siswa'])) {
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete core system role'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Cannot delete core system role');
            }

            if ($role->users()->count() > 0) {
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete role that has users assigned'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Cannot delete role that has users assigned.');
            }

            $role->delete();

            // Return JSON for AJAX requests
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role deleted successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting role: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }

    public function assignRoleToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        $user->assignRole($role);

        return redirect()->back()->with('success', 'Role assigned to user successfully.');
    }

    public function removeRoleFromUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        $user->removeRole($role);

        return redirect()->back()->with('success', 'Role removed from user successfully.');
    }

    public function getRolePermissions(Role $role)
    {
        try {
            $permissions = $role->permissions->pluck('name')->toArray();

            return response()->json([
                'success' => true,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading role permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUsersWithRoles()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }
}
