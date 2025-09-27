<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->user_type) {
            case 'superadmin':
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
            case 'admin':
                return view('dashboards.admin');
            case 'guru':
                return view('dashboards.guru');
            case 'siswa':
                return view('dashboards.siswa');
            case 'sarpras':
                return view('dashboards.sarpras');
            default:
                return view('dashboard'); // fallback to default dashboard
        }
    }
}
