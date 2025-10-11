<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Barang;
use App\Models\Voting;
use App\Models\Kelulusan;
use App\Models\Calon;
use App\Models\Pemilih;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $analytics = [
            'overview' => $this->getOverviewStats(),
            'user_activity' => $this->getUserActivity(),
            'module_usage' => $this->getModuleUsage(),
            'trends' => $this->getTrendsData(),
        ];

        return view('analytics.dashboard', compact('analytics'));
    }

    private function getOverviewStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_students' => Siswa::count(),
            'total_teachers' => Guru::count(),
            'total_assets' => Barang::count(),
            'total_votes' => Voting::count(),
            'graduated_students' => Kelulusan::where('status', 'lulus')->count(),
        ];
    }

    private function getUserActivity(): array
    {
        $lastWeek = Carbon::now()->subWeek();
        $lastMonth = Carbon::now()->subMonth();

        return [
            'new_users_this_week' => User::where('created_at', '>=', $lastWeek)->count(),
            'new_users_this_month' => User::where('created_at', '>=', $lastMonth)->count(),
            'user_distribution' => $this->getUserDistribution()
        ];
    }

    private function getModuleUsage(): array
    {
        return [
            'e_osis' => [
                'total_candidates' => Calon::count(),
                'total_voters' => Pemilih::count(),
                'voting_participation' => $this->getVotingParticipation()
            ],
            'e_lulus' => [
                'total_graduates' => Kelulusan::where('status', 'lulus')->count(),
                'pending_verification' => Kelulusan::where('status', 'pending')->count(),
            ],
            'sarpras' => [
                'total_assets' => Barang::count(),
                'maintenance_due' => Maintenance::where('tanggal_maintenance', '<=', now()->addDays(7))->count(),
                'assets_by_condition' => $this->getAssetsByCondition()
            ],
        ];
    }

    private function getTrendsData(): array
    {
        $last30Days = collect(range(0, 29))->map(function ($days) {
            return Carbon::now()->subDays(29 - $days);
        });

        return [
            'user_registrations' => $this->getUserRegistrationTrend($last30Days),
            'module_usage' => $this->getModuleUsageTrend($last30Days),
        ];
    }

    private function getUserDistribution(): array
    {
        return [
            'superadmin' => User::role('superadmin')->count(),
            'admin' => User::role('admin')->count(),
            'guru' => User::role('guru')->count(),
            'siswa' => User::role('siswa')->count(),
            'sarpras' => User::role('sarpras')->count()
        ];
    }

    private function getVotingParticipation(): float
    {
        $totalVoters = Pemilih::count();
        $totalVotes = Voting::count();

        return $totalVoters > 0 ? round(($totalVotes / $totalVoters) * 100, 2) : 0;
    }

    private function getAssetsByCondition(): array
    {
        return [
            'baik' => Barang::where('kondisi', 'baik')->count(),
            'rusak' => Barang::where('kondisi', 'rusak')->count(),
            'hilang' => Barang::where('kondisi', 'hilang')->count()
        ];
    }

    private function getUserRegistrationTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('M d'),
                'count' => User::whereDate('created_at', $day)->count()
            ];
        })->toArray();
    }

    private function getModuleUsageTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('M d'),
                'voting' => Voting::whereDate('created_at', $day)->count(),
                'graduation' => Kelulusan::whereDate('created_at', $day)->count(),
                'assets' => Barang::whereDate('created_at', $day)->count()
            ];
        })->toArray();
    }
}
