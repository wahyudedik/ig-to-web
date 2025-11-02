<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required|exists:roles,id',
                'send_invitation' => 'boolean'
            ]);

            // Generate temporary password
            $tempPassword = Str::random(12);

            // Get user type from role
            $role = Role::findOrFail($request->role_id);
            $userType = $role->name; // Use role name as user_type

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($tempPassword),
                'user_type' => $userType,
                'email_verified_at' => now(), // ✅ Auto-verify invited users
                'is_verified_by_admin' => true,
            ]);

            // Assign role
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error inviting user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error inviting user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id',
            ]);

            // Get user type from role
            $role = Role::findOrFail($request->role_id);
            $userType = $role->name; // Use role name as user_type

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $userType,
                'email_verified_at' => now(), // ✅ Auto-verify admin-created users
                'is_verified_by_admin' => true,
            ]);

            // Assign role
            $user->assignRole($role);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'user' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editUser(User $user)
    {
        // Prevent editing superadmin
        if ($user->hasRole('superadmin')) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Cannot edit superadmin user.');
        }

        $roles = Role::where('name', '!=', 'superadmin')->get();
        $user->load('roles');

        return view('admin.user-management.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        // Prevent updating superadmin
        if ($user->hasRole('superadmin')) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Cannot update superadmin user.');
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

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User updated successfully.');
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
        try {
            // Send invitation email with temporary password
            Mail::send('emails.user-invitation', [
                'user' => $user,
                'tempPassword' => $tempPassword,
                'loginUrl' => url('/login'),
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Welcome to Portal Sekolah - Account Invitation');
            });

            Log::info("Invitation email sent to {$user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send invitation email to {$user->email}: " . $e->getMessage());
        }
    }

    public function getUserRoles()
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return response()->json($roles);
    }
}
