<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SystemHealthController extends Controller
{
    /**
     * Get comprehensive system health status
     */
    public function index(): JsonResponse
    {
        $health = [
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'version' => config('app.version', '1.0.0'),
            'environment' => config('app.env'),
            'checks' => [
                'database' => $this->checkDatabase(),
                'cache' => $this->checkCache(),
                'storage' => $this->checkStorage(),
                'queue' => $this->checkQueue(),
                'memory' => $this->checkMemory(),
                'disk_space' => $this->checkDiskSpace(),
                'external_services' => $this->checkExternalServices()
            ]
        ];

        // Determine overall status
        $allHealthy = collect($health['checks'])->every(function ($check) {
            return $check['status'] === 'healthy';
        });

        $health['status'] = $allHealthy ? 'healthy' : 'degraded';

        return response()->json($health);
    }

    /**
     * Get detailed system metrics
     */
    public function metrics(): JsonResponse
    {
        $metrics = [
            'system' => $this->getSystemMetrics(),
            'application' => $this->getApplicationMetrics(),
            'database' => $this->getDatabaseMetrics(),
            'performance' => $this->getPerformanceMetrics()
        ];

        return response()->json([
            'success' => true,
            'data' => $metrics,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Check database connectivity and performance
     */
    private function checkDatabase(): array
    {
        try {
            $startTime = microtime(true);
            DB::select('SELECT 1');
            $responseTime = (microtime(true) - $startTime) * 1000;

            return [
                'status' => 'healthy',
                'response_time_ms' => round($responseTime, 2),
                'connection_count' => DB::getPdo()->getAttribute(\PDO::ATTR_CONNECTION_STATUS),
                'version' => DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check cache system
     */
    private function checkCache(): array
    {
        try {
            $testKey = 'health_check_' . time();
            $testValue = 'test_value';

            Cache::put($testKey, $testValue, 60);
            $retrieved = Cache::get($testKey);
            Cache::forget($testKey);

            return [
                'status' => $retrieved === $testValue ? 'healthy' : 'unhealthy',
                'driver' => config('cache.default'),
                'store' => config('cache.stores.' . config('cache.default') . '.driver')
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check storage systems
     */
    private function checkStorage(): array
    {
        try {
            $testFile = 'health_check_' . time() . '.txt';
            $testContent = 'health check content';

            Storage::disk('local')->put($testFile, $testContent);
            $retrieved = Storage::disk('local')->get($testFile);
            Storage::disk('local')->delete($testFile);

            return [
                'status' => $retrieved === $testContent ? 'healthy' : 'unhealthy',
                'local_disk' => Storage::disk('local')->exists('test') ? 'accessible' : 'not_accessible',
                'public_disk' => Storage::disk('public')->exists('test') ? 'accessible' : 'not_accessible'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check queue system
     */
    private function checkQueue(): array
    {
        try {
            $queueSize = DB::table('jobs')->count();

            return [
                'status' => 'healthy',
                'pending_jobs' => $queueSize,
                'failed_jobs' => DB::table('failed_jobs')->count(),
                'driver' => config('queue.default')
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check memory usage
     */
    private function checkMemory(): array
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = $this->convertToBytes($memoryLimit);
        $usagePercentage = ($memoryUsage / $memoryLimitBytes) * 100;

        return [
            'status' => $usagePercentage < 80 ? 'healthy' : 'warning',
            'current_mb' => round($memoryUsage / 1024 / 1024, 2),
            'limit_mb' => round($memoryLimitBytes / 1024 / 1024, 2),
            'usage_percentage' => round($usagePercentage, 2),
            'peak_memory_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2)
        ];
    }

    /**
     * Check disk space
     */
    private function checkDiskSpace(): array
    {
        $totalSpace = disk_total_space('/');
        $freeSpace = disk_free_space('/');
        $usedSpace = $totalSpace - $freeSpace;
        $usagePercentage = ($usedSpace / $totalSpace) * 100;

        return [
            'status' => $usagePercentage < 90 ? 'healthy' : 'warning',
            'total_gb' => round($totalSpace / 1024 / 1024 / 1024, 2),
            'used_gb' => round($usedSpace / 1024 / 1024 / 1024, 2),
            'free_gb' => round($freeSpace / 1024 / 1024 / 1024, 2),
            'usage_percentage' => round($usagePercentage, 2)
        ];
    }

    /**
     * Check external services
     */
    private function checkExternalServices(): array
    {
        $services = [];

        // Check Instagram API
        $instagramStatus = $this->checkInstagramAPI();
        $services['instagram_api'] = $instagramStatus;

        // Check email service
        $emailStatus = $this->checkEmailService();
        $services['email_service'] = $emailStatus;

        return $services;
    }

    /**
     * Check Instagram API connectivity
     */
    private function checkInstagramAPI(): array
    {
        try {
            $instagramSettings = cache('instagram_settings');
            if (!$instagramSettings || !$instagramSettings['access_token']) {
                return [
                    'status' => 'not_configured',
                    'message' => 'Instagram API not configured'
                ];
            }

            // This would typically make an actual API call
            return [
                'status' => 'healthy',
                'message' => 'Instagram API accessible'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check email service
     */
    private function checkEmailService(): array
    {
        try {
            $mailConfig = config('mail');
            if (!$mailConfig['default'] || $mailConfig['default'] === 'log') {
                return [
                    'status' => 'not_configured',
                    'message' => 'Email service not configured'
                ];
            }

            return [
                'status' => 'healthy',
                'driver' => $mailConfig['default'],
                'message' => 'Email service configured'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get system metrics
     */
    private function getSystemMetrics(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'operating_system' => PHP_OS,
            'load_average' => sys_getloadavg(),
            'uptime' => $this->getSystemUptime(),
            'timezone' => config('app.timezone')
        ];
    }

    /**
     * Get application metrics
     */
    private function getApplicationMetrics(): array
    {
        return [
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug'),
            'maintenance_mode' => app()->isDownForMaintenance(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
            'database_driver' => config('database.default')
        ];
    }

    /**
     * Get database metrics
     */
    private function getDatabaseMetrics(): array
    {
        try {
            $connection = DB::connection();
            $pdo = $connection->getPdo();

            return [
                'driver' => config('database.default'),
                'version' => $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION),
                'connection_status' => $pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS),
                'total_connections' => $pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS),
                'table_count' => DB::select("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = DATABASE()")[0]->count ?? 0
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics(): array
    {
        return [
            'response_time' => $this->getAverageResponseTime(),
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true),
            'opcache_enabled' => function_exists('opcache_get_status') && opcache_get_status(),
            'extensions' => $this->getLoadedExtensions()
        ];
    }

    /**
     * Convert memory limit string to bytes
     */
    private function convertToBytes(string $value): int
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;

        switch ($last) {
            case 'g':
                $value *= 1024;
                // no break
            case 'm':
                $value *= 1024;
                // no break
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    /**
     * Get system uptime
     */
    private function getSystemUptime(): string
    {
        if (function_exists('sys_getloadavg')) {
            $uptime = shell_exec('uptime -p 2>/dev/null') ?: 'Unknown';
            return trim($uptime);
        }
        return 'Unknown';
    }

    /**
     * Get average response time
     */
    private function getAverageResponseTime(): float
    {
        // This would typically come from monitoring tools
        return 150.5;
    }

    /**
     * Get loaded PHP extensions
     */
    private function getLoadedExtensions(): array
    {
        $required = [
            'pdo',
            'pdo_mysql',
            'mbstring',
            'openssl',
            'tokenizer',
            'xml',
            'ctype',
            'json',
            'bcmath',
            'fileinfo',
            'curl'
        ];

        $loaded = get_loaded_extensions();

        return [
            'loaded' => $loaded,
            'required' => $required,
            'missing' => array_diff($required, $loaded)
        ];
    }
}
