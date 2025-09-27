<?php

namespace App\Http\Controllers;

use App\Models\InstagramSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramSettingController extends Controller
{
    /**
     * Display Instagram settings management page
     */
    public function index()
    {
        $settings = InstagramSetting::latest()->first();
        return view('superadmin.instagram-settings', compact('settings'));
    }

    /**
     * Store or update Instagram settings
     */
    public function store(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'user_id' => 'required|string',
            'app_id' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'redirect_uri' => 'nullable|url',
            'sync_frequency' => 'required|integer|min:5|max:1440',
            'auto_sync_enabled' => 'boolean',
            'cache_duration' => 'required|integer|min:300|max:86400',
        ]);

        try {
            // Test the connection first
            $isValid = $this->testInstagramConnection($request->access_token, $request->user_id);

            if (!$isValid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Instagram credentials. Please check your access token and user ID.'
                ], 400);
            }

            // Create or update settings
            $settings = InstagramSetting::updateOrCreate(
                ['id' => 1], // Always use ID 1 for single settings
                [
                    'access_token' => $request->access_token,
                    'user_id' => $request->user_id,
                    'app_id' => $request->app_id,
                    'app_secret' => $request->app_secret,
                    'redirect_uri' => $request->redirect_uri,
                    'is_active' => true,
                    'sync_frequency' => $request->sync_frequency,
                    'auto_sync_enabled' => $request->boolean('auto_sync_enabled'),
                    'cache_duration' => $request->cache_duration,
                    'updated_by' => Auth::id(),
                ]
            );

            // Clear existing cache
            Cache::forget('instagram_posts');
            Cache::forget('instagram_analytics');

            return response()->json([
                'success' => true,
                'message' => 'Instagram settings saved successfully!',
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Instagram settings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Instagram settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Instagram connection
     */
    public function testConnection(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'user_id' => 'required|string',
        ]);

        try {
            $isValid = $this->testInstagramConnection($request->access_token, $request->user_id);

            if ($isValid) {
                $accountInfo = $this->getAccountInfo($request->access_token, $request->user_id);

                return response()->json([
                    'success' => true,
                    'message' => 'Instagram connection successful!',
                    'account_info' => $accountInfo
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Instagram connection failed. Please check your credentials.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Instagram connection test error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync Instagram data manually
     */
    public function syncData()
    {
        try {
            $settings = InstagramSetting::active()->first();

            if (!$settings) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active Instagram settings found.'
                ], 400);
            }

            // Clear cache and force refresh
            Cache::forget('instagram_posts');
            Cache::forget('instagram_analytics');

            // Update last sync time
            $settings->updateLastSync();

            return response()->json([
                'success' => true,
                'message' => 'Instagram data synced successfully!',
                'last_sync' => $settings->fresh()->last_sync
            ]);
        } catch (\Exception $e) {
            Log::error('Instagram sync error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current settings
     */
    public function getSettings()
    {
        $settings = InstagramSetting::latest()->first();

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Deactivate Instagram settings
     */
    public function deactivate()
    {
        try {
            $settings = InstagramSetting::active()->first();

            if ($settings) {
                $settings->update([
                    'is_active' => false,
                    'updated_by' => Auth::id()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Instagram settings deactivated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Instagram deactivation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate Instagram settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Instagram connection with provided credentials
     */
    private function testInstagramConnection($accessToken, $userId)
    {
        try {
            $response = Http::timeout(10)->get("https://graph.instagram.com/v12.0/{$userId}", [
                'fields' => 'id,username,account_type',
                'access_token' => $accessToken
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Instagram API test error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Instagram account information
     */
    private function getAccountInfo($accessToken, $userId)
    {
        try {
            $response = Http::timeout(10)->get("https://graph.instagram.com/v12.0/{$userId}", [
                'fields' => 'id,username,account_type,media_count',
                'access_token' => $accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Instagram account info error: ' . $e->getMessage());
            return null;
        }
    }
}
