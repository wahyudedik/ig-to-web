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

        // Get comprehensive statistics for all users
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_siswa' => 0,
            'total_guru' => 0,
            'total_barang' => 0,
            'total_pages' => 0,
            'total_instagram_settings' => 0,
            'recent_activities' => collect(), // Default empty collection
        ];

        // Try to get recent activities with error handling
        try {
            $stats['recent_activities'] = AuditLog::with('user')
                ->latest()
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $stats['recent_activities'] = collect();
        }

        // Get statistics for all users with error handling
        try {
            $stats['total_siswa'] = \App\Models\Siswa::count();
        } catch (\Exception $e) {
            $stats['total_siswa'] = 0;
        }

        try {
            $stats['total_guru'] = \App\Models\Guru::count();
        } catch (\Exception $e) {
            $stats['total_guru'] = 0;
        }

        try {
            $stats['total_barang'] = \App\Models\Barang::count();
        } catch (\Exception $e) {
            $stats['total_barang'] = 0;
        }

        try {
            $stats['total_pages'] = \App\Models\Page::count();
        } catch (\Exception $e) {
            $stats['total_pages'] = 0;
        }

        try {
            $stats['total_instagram_settings'] = \App\Models\InstagramSetting::count();
        } catch (\Exception $e) {
            $stats['total_instagram_settings'] = 0;
        }

        // Always use the centralized admin dashboard
        return view('dashboards.admin', [
            'statistics' => $stats,
            'recentActivities' => $stats['recent_activities']
        ]);
    }
}
