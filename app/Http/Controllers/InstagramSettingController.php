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
    public function index(Request $request)
    {
        // Get latest settings from database (if any)
        $settings = InstagramSetting::latest()->first();

        // Capture OAuth data from session flash (OAuth redirect)
        $urlAccessToken = session('oauth_access_token');
        $urlUserId = session('oauth_user_id');
        $urlPermissions = session('oauth_permissions');
        $urlExpiresIn = session('oauth_expires_in');

        // Generate Instagram Business Login authorization URL
        $authorizationUrl = app(\App\Services\InstagramService::class)->getAuthorizationUrl();

        return view('superadmin.instagram-settings', compact(
            'settings',
            'urlAccessToken',
            'urlUserId',
            'urlPermissions',
            'urlExpiresIn',
            'authorizationUrl'
        ));
    }

    /**
     * Generate Instagram Business Login authorization URL
     * Returns URL for OAuth flow
     */
    public function getAuthorizationUrl()
    {
        try {
            $instagramService = app(\App\Services\InstagramService::class);
            $authUrl = $instagramService->getAuthorizationUrl();

            if (!$authUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate authorization URL. Please configure App ID first.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'authorization_url' => $authUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Generate authorization URL error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update Instagram settings
     * Updated for Instagram Platform API
     */
    public function store(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'user_id' => 'required|string',
            'app_id' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'redirect_uri' => 'nullable|url',
            'webhook_verify_token' => 'nullable|string|max:255',
            'sync_frequency' => 'required|integer|min:5|max:1440',
            'auto_sync_enabled' => 'boolean',
            'cache_duration' => 'required|integer|min:300|max:86400',
        ]);

        try {
            // Test the connection first and get account info
            $accountInfo = $this->testInstagramConnectionWithInfo($request->access_token, $request->user_id);

            if (!$accountInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Instagram credentials. Please check your access token and user ID.'
                ], 400);
            }

            // Calculate token expiry (Instagram User tokens are typically long-lived: 60 days)
            $tokenExpiresAt = now()->addDays(60);

            // Create or update settings
            $settings = InstagramSetting::updateOrCreate(
                ['id' => 1], // Always use ID 1 for single settings
                [
                    'access_token' => $request->access_token,
                    'user_id' => $request->user_id,
                    'username' => $accountInfo['username'] ?? null,
                    'account_type' => $accountInfo['account_type'] ?? null,
                    'app_id' => $request->app_id,
                    'app_secret' => $request->app_secret,
                    'redirect_uri' => $request->redirect_uri,
                    'webhook_verify_token' => $request->webhook_verify_token ?? 'mySchoolWebhook2025',
                    'is_active' => true,
                    'token_expires_at' => $tokenExpiresAt,
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
                'message' => 'Instagram settings saved successfully! Token will expire on ' . $tokenExpiresAt->format('M d, Y'),
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
     * Updated for Instagram Platform API v20.0
     */
    private function testInstagramConnection($accessToken, $userId)
    {
        try {
            $response = Http::timeout(10)->get("https://graph.instagram.com/v20.0/{$userId}", [
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
     * Test connection and get account info in one call
     * NEW: Combined method for Instagram Platform API
     */
    private function testInstagramConnectionWithInfo($accessToken, $userId)
    {
        try {
            $response = Http::timeout(15)->get("https://graph.instagram.com/v20.0/{$userId}", [
                'fields' => 'id,username,name,account_type,media_count,profile_picture_url',
                'access_token' => $accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Instagram API connection test failed', [
                'status' => $response->status(),
                'error' => $response->json()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Instagram API test error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Instagram account information
     * Updated for Instagram Platform API v20.0
     */
    private function getAccountInfo($accessToken, $userId)
    {
        try {
            $response = Http::timeout(10)->get("https://graph.instagram.com/v20.0/{$userId}", [
                'fields' => 'id,username,name,account_type,media_count,profile_picture_url',
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
