<?php

namespace App\Http\Controllers;

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
