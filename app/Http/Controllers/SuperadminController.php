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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Exports\UserExport;

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
            'total_siswas' => \App\Models\Siswa::count(),
            'total_gurus' => \App\Models\Guru::count(),
            'total_pages' => \App\Models\Page::count(),
            'total_instagram_posts' => \App\Models\InstagramSetting::count(),
            'recent_activities' => AuditLog::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return view('dashboards.admin', compact('stats'));
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
        // Different validation for AJAX requests (from guru/create modal)
        $isAjax = $request->wantsJson() || $request->ajax();

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => $isAjax ? 'required|string|min:8' : 'required|string|min:8|confirmed',
            'user_type' => 'required|in:superadmin,admin,guru,siswa,sarpras',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ];

        $validated = $request->validate($validationRules);

        // Use transaction for user creation with roles and audit log
        $user = DB::transaction(function () use ($request) {
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

                // IMPORTANT: Use syncRoles() to ensure user has ONLY the selected roles
                // If only one role provided, user will have only that one role
                // If multiple roles provided, user will have all of them (but typically only one)
                $user->syncRoles($roleNames);
            }

            // Sync user_type with primary role
            $user->load('roles');
            $primaryRole = $user->roles->first();
            if ($primaryRole && $user->user_type !== $primaryRole->name) {
                $user->updateQuietly(['user_type' => $primaryRole->name]);
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

            return $user;
        });

        // Return JSON for AJAX requests
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                ]
            ]);
        }

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

        // Use transaction for user update with roles and audit log
        DB::transaction(function () use ($request, $user, $oldValues) {
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

            // Sync user_type with primary role
            $user->load('roles');
            $primaryRole = $user->roles->first();
            if ($primaryRole && $user->user_type !== $primaryRole->name) {
                $user->updateQuietly(['user_type' => $primaryRole->name]);
            } elseif (!$primaryRole && $user->user_type) {
                // If user has no roles, set default
                $user->updateQuietly(['user_type' => 'siswa']); // Default fallback
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
        });

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
        $modules = ['instagram', 'pages', 'guru', 'siswa', 'osis', 'lulus', 'sarpras', 'settings'];
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

    /**
     * Show import form for users.
     */
    public function importUsers()
    {
        return view('superadmin.users.import');
    }

    /**
     * Download template Excel for user import.
     */
    public function downloadUserTemplate()
    {
        // Create sample data for template
        $sampleData = [
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.com',
                'user_type' => 'admin',
                'password' => 'password123',
                'email_verified_at' => '2024-01-01 00:00:00',
                'is_verified_by_admin' => 'yes'
            ],
            [
                'name' => 'Guru Matematika',
                'email' => 'guru@sekolah.com',
                'user_type' => 'guru',
                'password' => 'password123',
                'email_verified_at' => '2024-01-01 00:00:00',
                'is_verified_by_admin' => 'yes'
            ],
            [
                'name' => 'Siswa Contoh',
                'email' => 'siswa@sekolah.com',
                'user_type' => 'siswa',
                'password' => 'password123',
                'email_verified_at' => '',
                'is_verified_by_admin' => 'no'
            ]
        ];

        // Create a new export class for template
        $templateExport = new class($sampleData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'name',
                    'email',
                    'user_type',
                    'password',
                    'email_verified_at',
                    'is_verified_by_admin'
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [
                    1 => ['font' => ['bold' => true]],
                ];
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 25,
                    'B' => 30,
                    'C' => 15,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                ];
            }
        };

        return Excel::download($templateExport, 'template-import-users.xlsx');
    }

    /**
     * Process user import.
     */
    public function processUserImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // Get file info for logging
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            Log::info("Starting user import process", [
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'user_id' => Auth::id()
            ]);

            // Create import instance
            $import = new UserImport();

            // Import the file
            Excel::import($import, $file);

            // Get import results
            $importedCount = $import->getRowCount() ?? 0;
            $errors = $import->errors();
            $failures = $import->failures();

            Log::info("User import completed", [
                'imported_count' => $importedCount,
                'errors_count' => count($errors),
                'failures_count' => count($failures)
            ]);

            // Prepare success message with details
            $message = "Data user berhasil diimpor!";
            $details = [];

            if ($importedCount > 0) {
                $details[] = "Berhasil mengimpor {$importedCount} user";
            }

            if (count($failures) > 0) {
                $details[] = count($failures) . " user gagal diimpor (cek log untuk detail)";
            }

            if (count($errors) > 0) {
                $details[] = count($errors) . " user memiliki error validasi";
            }

            if (!empty($details)) {
                $message .= " (" . implode(', ', $details) . ")";
            }

            return redirect()->route('superadmin.users')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error("User import failed", [
                'error' => $e->getMessage(),
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Export users data.
     */
    public function exportUsers(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->has('user_type') && $request->user_type !== '') {
            $query->where('user_type', $request->user_type);
        }

        if ($request->has('is_verified_by_admin') && $request->is_verified_by_admin !== '') {
            $query->where('is_verified_by_admin', $request->is_verified_by_admin);
        }

        $users = $query->get();

        return Excel::download(new UserExport($users), 'users-' . date('Y-m-d') . '.xlsx');
    }
}
