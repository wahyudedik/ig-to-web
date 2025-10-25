<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\InstagramService;
use App\Models\InstagramSetting;

class InstagramController extends Controller
{
    protected $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    /**
     * Display the Instagram activities page
     */
    public function index()
    {
        // Get Instagram posts from service
        $posts = $this->instagramService->getCachedPosts();

        return view('instagram.activities', compact('posts'));
    }

    /**
     * Refresh Instagram posts from API
     */
    public function refresh()
    {
        // Refresh posts using service
        $this->instagramService->refreshPosts();

        return redirect()->route('public.kegiatan')->with('success', 'Data Instagram berhasil diperbarui!');
    }

    /**
     * Get Instagram posts via AJAX
     */
    public function getPosts()
    {
        $posts = $this->instagramService->getCachedPosts();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Get Instagram account information
     */
    public function getAccountInfo()
    {
        $accountInfo = $this->instagramService->getAccountInfo();

        return response()->json([
            'success' => true,
            'data' => $accountInfo
        ]);
    }

    /**
     * Validate Instagram connection
     */
    public function validateConnection()
    {
        $isValid = $this->instagramService->validateToken();

        return response()->json([
            'success' => $isValid,
            'message' => $isValid ? 'Koneksi Instagram valid' : 'Koneksi Instagram tidak valid'
        ]);
    }

    /**
     * Verify webhook (GET request from Meta)
     * Called once when you configure webhook in Meta Dashboard
     */
    public function verifyWebhook(Request $request)
    {
        $mode = $request->input('hub_mode');
        $token = $request->input('hub_verify_token');
        $challenge = $request->input('hub_challenge');

        // Get verify token from settings or config
        $settings = InstagramSetting::where('is_active', true)->first();
        $verifyToken = $settings->webhook_verify_token ??
            config('services.instagram.webhook_verify_token', 'mySchoolWebhook2025');

        Log::info('Instagram Webhook Verification Attempt', [
            'mode' => $mode,
            'token_received' => $token,
            'token_expected' => $verifyToken,
            'challenge' => $challenge,
            'ip' => $request->ip()
        ]);

        // Meta expects exactly this response for successful verification
        if ($mode === 'subscribe' && $token === $verifyToken) {
            Log::info('✅ Webhook verified successfully');
            return response($challenge, 200)
                ->header('Content-Type', 'text/plain');
        }

        Log::error('❌ Webhook verification failed', [
            'expected_token' => $verifyToken,
            'received_token' => $token
        ]);

        return response('Forbidden', 403);
    }

    /**
     * Handle webhook notifications (POST request from Meta)
     * Called when Instagram events happen (new post, comment, etc)
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        Log::info('Instagram Webhook Event Received', [
            'data' => $data,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Verify signature (security check)
        $signature = $request->header('X-Hub-Signature-256');
        if ($signature) {
            $appSecret = config('services.instagram.app_secret');
            if ($appSecret) {
                $expectedSignature = 'sha256=' . hash_hmac('sha256', $request->getContent(), $appSecret);

                if (!hash_equals($expectedSignature, $signature)) {
                    Log::error('❌ Invalid webhook signature');
                    return response('Invalid signature', 403);
                }
                Log::info('✅ Webhook signature verified');
            }
        }

        // Process webhook data
        if (isset($data['entry'])) {
            foreach ($data['entry'] as $entry) {
                if (isset($entry['changes'])) {
                    foreach ($entry['changes'] as $change) {
                        $this->processWebhookChange($change);
                    }
                }
            }
        }

        // Meta expects 200 response immediately
        return response('EVENT_RECEIVED', 200);
    }

    /**
     * Process individual webhook change
     */
    private function processWebhookChange($change)
    {
        $field = $change['field'] ?? null;
        $value = $change['value'] ?? null;

        Log::info('Processing webhook change', [
            'field' => $field,
            'value_type' => is_array($value) ? 'array' : gettype($value)
        ]);

        try {
            // Handle different webhook events
            switch ($field) {
                case 'comments':
                    // New comment on a post
                    Log::info('New comment webhook', ['comment_data' => $value]);
                    // You can add auto-reply logic here
                    break;

                case 'media':
                    // New media post
                    Log::info('New media webhook', ['media_data' => $value]);
                    // Clear cache to refresh posts
                    Cache::forget('instagram_posts');
                    Cache::forget('instagram_analytics');
                    break;

                case 'mentions':
                    // Brand mentioned
                    Log::info('New mention webhook', ['mention_data' => $value]);
                    break;

                default:
                    Log::info('Unknown webhook field', ['field' => $field]);
            }
        } catch (\Exception $e) {
            Log::error('Error processing webhook change', [
                'error' => $e->getMessage(),
                'field' => $field
            ]);
        }
    }
}
