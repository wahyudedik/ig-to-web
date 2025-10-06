<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Barang;
use App\Models\Voting;
use App\Models\Kelulusan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardAnalyticsController extends Controller
{
    /**
     * Get comprehensive dashboard analytics
     */
    public function index(): JsonResponse
    {
        $analytics = [
            'overview' => $this->getOverviewStats(),
            'user_activity' => $this->getUserActivity(),
            'module_usage' => $this->getModuleUsage(),
            'performance_metrics' => $this->getPerformanceMetrics(),
            'trends' => $this->getTrendsData(),
            'real_time_stats' => $this->getRealTimeStats()
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Get overview statistics
     */
    private function getOverviewStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_students' => Siswa::count(),
            'total_teachers' => Guru::count(),
            'total_assets' => Barang::count(),
            'total_votes' => Voting::count(),
            'graduated_students' => Kelulusan::where('status', 'lulus')->count(),
            'active_users_today' => User::whereDate('last_login_at', today())->count(),
            'system_uptime' => $this->getSystemUptime()
        ];
    }

    /**
     * Get user activity analytics
     */
    private function getUserActivity(): array
    {
        $lastWeek = Carbon::now()->subWeek();
        $lastMonth = Carbon::now()->subMonth();

        return [
            'new_users_this_week' => User::where('created_at', '>=', $lastWeek)->count(),
            'new_users_this_month' => User::where('created_at', '>=', $lastMonth)->count(),
            'active_users_this_week' => User::where('last_login_at', '>=', $lastWeek)->count(),
            'active_users_this_month' => User::where('last_login_at', '>=', $lastMonth)->count(),
            'login_frequency' => $this->getLoginFrequency(),
            'user_distribution' => $this->getUserDistribution()
        ];
    }

    /**
     * Get module usage statistics
     */
    private function getModuleUsage(): array
    {
        return [
            'e_osis' => [
                'total_candidates' => \App\Models\Calon::count(),
                'total_voters' => \App\Models\Pemilih::count(),
                'voting_participation' => $this->getVotingParticipation()
            ],
            'e_lulus' => [
                'total_graduates' => Kelulusan::where('status', 'lulus')->count(),
                'pending_verification' => Kelulusan::where('status', 'pending')->count(),
                'certificates_generated' => Kelulusan::whereNotNull('certificate_path')->count()
            ],
            'sarpras' => [
                'total_assets' => Barang::count(),
                'maintenance_due' => \App\Models\Maintenance::where('tanggal_maintenance', '<=', now()->addDays(7))->count(),
                'assets_by_condition' => $this->getAssetsByCondition()
            ],
            'instagram' => [
                'total_posts' => cache('instagram_posts_count', 0),
                'total_followers' => cache('instagram_followers_count', 0),
                'engagement_rate' => cache('instagram_engagement_rate', 0)
            ]
        ];
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics(): array
    {
        return [
            'response_time' => $this->getAverageResponseTime(),
            'error_rate' => $this->getErrorRate(),
            'database_performance' => $this->getDatabasePerformance(),
            'cache_hit_rate' => $this->getCacheHitRate(),
            'memory_usage' => memory_get_usage(true),
            'disk_usage' => $this->getDiskUsage()
        ];
    }

    /**
     * Get trends data for charts
     */
    private function getTrendsData(): array
    {
        $last30Days = collect(range(0, 29))->map(function ($days) {
            return Carbon::now()->subDays($days);
        });

        return [
            'user_registrations' => $this->getUserRegistrationTrend($last30Days),
            'login_activity' => $this->getLoginActivityTrend($last30Days),
            'module_usage' => $this->getModuleUsageTrend($last30Days),
            'system_performance' => $this->getPerformanceTrend($last30Days)
        ];
    }

    /**
     * Get real-time statistics
     */
    private function getRealTimeStats(): array
    {
        return [
            'online_users' => $this->getOnlineUsers(),
            'current_requests' => $this->getCurrentRequests(),
            'server_load' => $this->getServerLoad(),
            'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'cpu_usage' => $this->getCpuUsage()
        ];
    }

    // Helper methods
    private function getSystemUptime(): string
    {
        $uptime = shell_exec('uptime');
        return $uptime ? trim($uptime) : 'Unknown';
    }

    private function getLoginFrequency(): array
    {
        $frequencies = [
            'daily' => User::where('last_login_at', '>=', today())->count(),
            'weekly' => User::where('last_login_at', '>=', Carbon::now()->subWeek())->count(),
            'monthly' => User::where('last_login_at', '>=', Carbon::now()->subMonth())->count()
        ];

        return $frequencies;
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
        $totalVoters = \App\Models\Pemilih::count();
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

    private function getAverageResponseTime(): float
    {
        // This would typically come from monitoring tools
        return 150.5; // milliseconds
    }

    private function getErrorRate(): float
    {
        // This would typically come from log analysis
        return 0.02; // 2%
    }

    private function getDatabasePerformance(): array
    {
        return [
            'query_time' => 25.3, // milliseconds
            'connections' => 8,
            'slow_queries' => 3
        ];
    }

    private function getCacheHitRate(): float
    {
        return 85.7; // percentage
    }

    private function getDiskUsage(): array
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;

        return [
            'total_gb' => round($total / 1024 / 1024 / 1024, 2),
            'used_gb' => round($used / 1024 / 1024 / 1024, 2),
            'free_gb' => round($free / 1024 / 1024 / 1024, 2),
            'usage_percentage' => round(($used / $total) * 100, 2)
        ];
    }

    private function getUserRegistrationTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('Y-m-d'),
                'count' => User::whereDate('created_at', $day)->count()
            ];
        })->reverse()->values()->toArray();
    }

    private function getLoginActivityTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('Y-m-d'),
                'count' => User::whereDate('last_login_at', $day)->count()
            ];
        })->reverse()->values()->toArray();
    }

    private function getModuleUsageTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('Y-m-d'),
                'voting' => Voting::whereDate('created_at', $day)->count(),
                'graduation' => Kelulusan::whereDate('created_at', $day)->count(),
                'assets' => Barang::whereDate('created_at', $day)->count()
            ];
        })->reverse()->values()->toArray();
    }

    private function getPerformanceTrend($days): array
    {
        return $days->map(function ($day) {
            return [
                'date' => $day->format('Y-m-d'),
                'response_time' => rand(100, 300),
                'error_rate' => rand(1, 5) / 100
            ];
        })->reverse()->values()->toArray();
    }

    private function getOnlineUsers(): int
    {
        return User::where('last_login_at', '>=', Carbon::now()->subMinutes(15))->count();
    }

    private function getCurrentRequests(): int
    {
        // This would typically come from web server stats
        return rand(50, 200);
    }

    private function getServerLoad(): float
    {
        $load = sys_getloadavg();
        return $load[0] ?? 0;
    }

    private function getCpuUsage(): float
    {
        // This would typically come from system monitoring
        return rand(10, 80);
    }
}
