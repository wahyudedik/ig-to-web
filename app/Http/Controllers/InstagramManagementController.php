<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstagramService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class InstagramManagementController extends Controller
{
    protected $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    /**
     * Display Instagram management dashboard
     */
    public function index()
    {
        $accountInfo = $this->instagramService->getAccountInfo();
        $connectionStatus = $this->instagramService->validateToken();
        $posts = $this->instagramService->getCachedPosts();

        return view('instagram.management', compact('accountInfo', 'connectionStatus', 'posts'));
    }

    /**
     * Update Instagram API configuration
     */
    public function updateConfig(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'user_id' => 'required|string',
            'app_id' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'redirect_uri' => 'nullable|url',
        ]);

        // In production, this would update environment variables
        // For now, we'll just validate the configuration
        $isValid = $this->validateInstagramConfig($request->all());

        if ($isValid) {
            // Clear cache to force refresh with new config
            $this->instagramService->clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Instagram configuration updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Instagram configuration'
        ], 400);
    }

    /**
     * Validate Instagram configuration
     */
    private function validateInstagramConfig($config)
    {
        try {
            // Mock validation - in production, validate with Instagram API
            return !empty($config['access_token']) && !empty($config['user_id']);
        } catch (\Exception $e) {
            Log::error('Instagram config validation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Test Instagram connection
     */
    public function testConnection()
    {
        $isValid = $this->instagramService->validateToken();
        $accountInfo = $this->instagramService->getAccountInfo();

        return response()->json([
            'success' => $isValid,
            'message' => $isValid ? 'Instagram connection successful' : 'Instagram connection failed',
            'account_info' => $accountInfo
        ]);
    }

    /**
     * Filter and moderate posts
     */
    public function filterPosts(Request $request)
    {
        $request->validate([
            'filter_type' => 'required|in:all,images,videos,carousel',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'min_likes' => 'nullable|integer|min:0',
            'min_comments' => 'nullable|integer|min:0',
            'keyword' => 'nullable|string|max:255',
        ]);

        $posts = $this->instagramService->getCachedPosts();
        $filteredPosts = $this->applyFilters($posts, $request->all());

        return response()->json([
            'success' => true,
            'data' => $filteredPosts,
            'total_filtered' => count($filteredPosts),
            'total_original' => count($posts)
        ]);
    }

    /**
     * Apply filters to posts
     */
    private function applyFilters($posts, $filters)
    {
        $filtered = collect($posts);

        // Filter by media type
        if ($filters['filter_type'] !== 'all') {
            $filtered = $filtered->filter(function ($post) use ($filters) {
                return $post['media_type'] === strtoupper($filters['filter_type']);
            });
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $filtered = $filtered->filter(function ($post) use ($filters) {
                return $post['timestamp'] >= $filters['date_from'];
            });
        }

        if (!empty($filters['date_to'])) {
            $filtered = $filtered->filter(function ($post) use ($filters) {
                return $post['timestamp'] <= $filters['date_to'];
            });
        }

        // Filter by minimum likes
        if (!empty($filters['min_likes'])) {
            $filtered = $filtered->filter(function ($post) use ($filters) {
                return $post['like_count'] >= $filters['min_likes'];
            });
        }

        // Filter by minimum comments
        if (!empty($filters['min_comments'])) {
            $filtered = $filtered->filter(function ($post) use ($filters) {
                return $post['comment_count'] >= $filters['min_comments'];
            });
        }

        // Filter by keyword in caption
        if (!empty($filters['keyword'])) {
            $keyword = strtolower($filters['keyword']);
            $filtered = $filtered->filter(function ($post) use ($keyword) {
                return strpos(strtolower($post['caption']), $keyword) !== false;
            });
        }

        return $filtered->values()->toArray();
    }

    /**
     * Schedule content (mock implementation)
     */
    public function scheduleContent(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'scheduled_time' => 'required|date|after:now',
            'media_url' => 'nullable|url',
            'caption' => 'nullable|string|max:2200',
        ]);

        // Mock scheduling - in production, integrate with Instagram API
        $scheduledPost = [
            'id' => \uniqid(),
            'content' => $request->input('content'),
            'scheduled_time' => $request->input('scheduled_time'),
            'media_url' => $request->input('media_url'),
            'caption' => $request->input('caption'),
            'status' => 'scheduled',
            'created_at' => now()
        ];

        // Store in cache (in production, store in database)
        $scheduledPosts = Cache::get('scheduled_posts', []);
        $scheduledPosts[] = $scheduledPost;
        Cache::put('scheduled_posts', $scheduledPosts, 86400); // 24 hours

        return response()->json([
            'success' => true,
            'message' => 'Content scheduled successfully',
            'data' => $scheduledPost
        ]);
    }

    /**
     * Get scheduled content
     */
    public function getScheduledContent()
    {
        $scheduledPosts = Cache::get('scheduled_posts', []);

        return response()->json([
            'success' => true,
            'data' => $scheduledPosts
        ]);
    }

    /**
     * Cancel scheduled content
     */
    public function cancelScheduledContent(Request $request)
    {
        $request->validate([
            'post_id' => 'required|string'
        ]);

        $scheduledPosts = Cache::get('scheduled_posts', []);
        $filteredPosts = collect($scheduledPosts)
            ->reject(function ($post) use ($request) {
                return $post['id'] === $request->input('post_id');
            })
            ->values()
            ->toArray();

        Cache::put('scheduled_posts', $filteredPosts, 86400);

        return response()->json([
            'success' => true,
            'message' => 'Scheduled content cancelled successfully'
        ]);
    }

    /**
     * Get Instagram insights
     */
    public function getInsights()
    {
        $posts = $this->instagramService->getCachedPosts();

        $insights = [
            'total_posts' => count($posts),
            'total_likes' => array_sum(array_column($posts, 'like_count')),
            'total_comments' => array_sum(array_column($posts, 'comment_count')),
            'avg_engagement' => 0,
            'best_performing_post' => null,
            'recent_trends' => []
        ];

        if (!empty($posts)) {
            $totalEngagement = $insights['total_likes'] + $insights['total_comments'];
            $insights['avg_engagement'] = round($totalEngagement / count($posts), 2);

            // Find best performing post
            $bestPost = collect($posts)
                ->sortByDesc(function ($post) {
                    return $post['like_count'] + $post['comment_count'];
                })
                ->first();

            $insights['best_performing_post'] = $bestPost;
        }

        return response()->json([
            'success' => true,
            'data' => $insights
        ]);
    }
}
