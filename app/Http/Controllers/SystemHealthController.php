<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SystemHealthController extends Controller
{
    public function index()
    {
        $health = [
            'status' => 'healthy',
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'version' => config('app.version', '1.0.0'),
            'environment' => config('app.env'),
            'checks' => [
                'database' => $this->checkDatabase(),
                'cache' => $this->checkCache(),
                'storage' => $this->checkStorage(),
                'memory' => $this->checkMemory(),
                'disk_space' => $this->checkDiskSpace(),
            ],
            'metrics' => [
                'system' => $this->getSystemMetrics(),
                'application' => $this->getApplicationMetrics(),
            ]
        ];

        // Determine overall status
        $allHealthy = collect($health['checks'])->every(function ($check) {
            return in_array($check['status'], ['healthy', 'warning']);
        });

        $health['status'] = $allHealthy ? 'healthy' : 'degraded';

        return view('system.health', compact('health'));
    }

    private function checkDatabase(): array
    {
        try {
            $startTime = microtime(true);
            DB::select('SELECT 1');
            $responseTime = (microtime(true) - $startTime) * 1000;

            return [
                'status' => 'healthy',
                'response_time_ms' => round($responseTime, 2),
                'version' => DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

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
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

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
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

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
        ];
    }

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

    private function getSystemMetrics(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'operating_system' => PHP_OS,
            'timezone' => config('app.timezone')
        ];
    }

    private function getApplicationMetrics(): array
    {
        return [
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'database_driver' => config('database.default')
        ];
    }

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
}
