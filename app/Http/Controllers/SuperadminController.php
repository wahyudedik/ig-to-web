<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ModuleAccess;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperadminController extends Controller
{
    /**
     * Display superadmin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'recent_activities' => AuditLog::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return view('dashboards.superadmin', compact('stats'));
    }

    /**
     * Display user management.
     */
    public function users()
    {
        $users = User::with('roles', 'moduleAccess')->paginate(15);
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Show user details.
     */
    public function showUser(User $user)
    {
        $user->load('roles', 'moduleAccess', 'auditLogs');
        return view('superadmin.users.show', compact('user'));
    }

    /**
     * Show create user form.
     */
    public function createUser()
    {
        $roles = Role::where('is_active', true)->get();
        return view('superadmin.users.create', compact('roles'));
    }

    /**
     * Store new user.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:superadmin,admin,guru,siswa,sarpras',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'email_verified_at' => now(), // Auto verify when created by superadmin
            'is_verified_by_admin' => true, // Mark as verified by admin
        ]);

        if ($request->has('roles')) {
            $roleIds = $request->roles;
            $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            $user->assignRole($roleNames);
        }

        // Log the action
        AuditLog::createLog(
            'user_created',
            Auth::id(),
            'User',
            $user->id,
            null,
            $user->toArray(),
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('superadmin.users')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show edit user form.
     */
    public function editUser(User $user)
    {
        $roles = Role::where('is_active', true)->get();
        $user->load('roles');
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'user_type' => 'required|in:superadmin,admin,guru,siswa,sarpras',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $oldValues = $user->toArray();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->has('roles')) {
            $roleIds = $request->roles;
            $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        // Log the action
        AuditLog::createLog(
            'user_updated',
            Auth::id(),
            'User',
            $user->id,
            $oldValues,
            $user->fresh()->toArray(),
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('superadmin.users')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user.
     */
    public function destroyUser(User $user)
    {
        // Prevent deleting superadmin
        if ($user->user_type === 'superadmin') {
            return redirect()->back()
                ->with('error', 'Cannot delete superadmin user.');
        }

        $oldValues = $user->toArray();
        $user->delete();

        // Log the action
        AuditLog::createLog(
            'user_deleted',
            Auth::id(),
            'User',
            $user->id,
            $oldValues,
            null,
            request()->ip(),
            request()->userAgent()
        );

        return redirect()->route('superadmin.users')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Manage user module access.
     */
    public function moduleAccess(User $user)
    {
        $modules = ['instagram', 'pages', 'guru', 'siswa', 'osis', 'lulus', 'sarpras'];
        $user->load('moduleAccess');

        return view('superadmin.users.module-access', compact('user', 'modules'));
    }

    /**
     * Update user module access.
     */
    public function updateModuleAccess(Request $request, User $user)
    {
        $request->validate([
            'modules' => 'required|array',
            'modules.*.module_name' => 'required|string',
            'modules.*.can_access' => 'boolean',
            'modules.*.can_create' => 'boolean',
            'modules.*.can_read' => 'boolean',
            'modules.*.can_update' => 'boolean',
            'modules.*.can_delete' => 'boolean',
        ]);

        foreach ($request->modules as $moduleData) {
            ModuleAccess::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'module_name' => $moduleData['module_name'],
                ],
                [
                    'can_access' => $moduleData['can_access'] ?? false,
                    'can_create' => $moduleData['can_create'] ?? false,
                    'can_read' => $moduleData['can_read'] ?? false,
                    'can_update' => $moduleData['can_update'] ?? false,
                    'can_delete' => $moduleData['can_delete'] ?? false,
                ]
            );
        }

        // Log the action
        AuditLog::createLog(
            'module_access_updated',
            Auth::id(),
            'User',
            $user->id,
            null,
            $request->modules,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('superadmin.users.module-access', $user)
            ->with('success', 'Module access updated successfully.');
    }
}
