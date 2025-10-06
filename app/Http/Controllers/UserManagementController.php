<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        $roles = Role::where('name', '!=', 'superadmin')->get();

        return view('admin.user-management.index', compact('users', 'roles'));
    }

    public function inviteUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'send_invitation' => 'boolean'
        ]);

        // Generate temporary password
        $tempPassword = Str::random(12);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'user_type' => 'invited',
            'email_verified_at' => null,
            'is_verified_by_admin' => true,
        ]);

        // Assign role
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        // Send invitation email if requested
        if ($request->has('send_invitation') && $request->send_invitation) {
            $this->sendInvitationEmail($user, $tempPassword);
        }

        return response()->json([
            'success' => true,
            'message' => 'User invited successfully.',
            'user' => $user,
            'temp_password' => $tempPassword
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'created',
            'email_verified_at' => now(),
            'is_verified_by_admin' => true,
        ]);

        // Assign role
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        // Prevent updating superadmin
        if ($user->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update superadmin user.'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update role
        $role = Role::findOrFail($request->role_id);
        $user->syncRoles([$role]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function deleteUser(User $user)
    {
        // Prevent deleting superadmin
        if ($user->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete superadmin user.'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

    public function toggleUserStatus(User $user)
    {
        // Prevent disabling superadmin
        if ($user->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot disable superadmin user.'
            ], 403);
        }

        $user->update([
            'is_verified_by_admin' => !$user->is_verified_by_admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'user' => $user
        ]);
    }

    private function sendInvitationEmail($user, $tempPassword)
    {
        // Send invitation email with temporary password
        // This would typically use Laravel's Mail system
        // For now, we'll just log it
        \Log::info("Invitation sent to {$user->email} with temporary password: {$tempPassword}");
    }

    public function getUserRoles()
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return response()->json($roles);
    }
}
