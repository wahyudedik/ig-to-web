<?php

namespace App\Services;

use App\Models\InstagramSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected $accessToken;
    protected $userId;
    protected $baseUrl = 'https://graph.instagram.com/v20.0'; // Updated to latest version

    public function __construct()
    {
        // Get settings from database first, fallback to config
        $settings = InstagramSetting::active()->first();

        if ($settings && $settings->isComplete()) {
            $this->accessToken = $settings->access_token;
            $this->userId = $settings->user_id;
        } else {
            // Fallback to environment variables
            $this->accessToken = config('services.instagram.access_token');
            $this->userId = config('services.instagram.user_id');
        }
    }

    /**
     * Fetch Instagram posts from API
     * Using Instagram Platform API with Instagram Login
     */
    public function fetchPosts($limit = 20)
    {
        try {
            // Check if credentials are available
            if (empty($this->accessToken) || empty($this->userId)) {
                Log::warning('Instagram credentials not configured');
                return $this->getMockPosts();
            }

            // Real Instagram Platform API call
            $response = Http::timeout(30)->get($this->baseUrl . "/{$this->userId}/media", [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,like_count,comments_count,children{media_url,media_type}',
                'access_token' => $this->accessToken,
                'limit' => $limit
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Log success
                Log::info('Instagram API: Successfully fetched ' . count($data['data'] ?? []) . ' posts');

                return $data['data'] ?? [];
            }

            // Log error with details
            $error = $response->json();
            Log::error('Instagram API error', [
                'status' => $response->status(),
                'error' => $error['error']['message'] ?? 'Unknown error',
                'code' => $error['error']['code'] ?? null
            ]);

            // Return mock data as fallback
            return $this->getMockPosts();
        } catch (\Exception $e) {
            Log::error('Instagram service error: ' . $e->getMessage());
            return $this->getMockPosts();
        }
    }

    /**
     * Get cached Instagram posts
     */
    public function getCachedPosts($limit = 20)
    {
        return Cache::remember('instagram_posts', 3600, function () use ($limit) {
            return $this->fetchPosts($limit);
        });
    }

    /**
     * Clear Instagram posts cache
     */
    public function clearCache()
    {
        Cache::forget('instagram_posts');
    }

    /**
     * Refresh Instagram posts
     */
    public function refreshPosts($limit = 20)
    {
        $this->clearCache();
        return $this->getCachedPosts($limit);
    }

    /**
     * Mock Instagram posts for demo purposes
     */
    private function getMockPosts()
    {
        return [
            [
                'id' => 1,
                'caption' => 'Kegiatan belajar mengajar di kelas 10A hari ini sangat seru! Siswa-siswi antusias mengikuti pelajaran Matematika dengan metode pembelajaran yang interaktif.',
                'media_url' => 'https://images.unsplash.com/photo-1523240798132-8757214e76ba?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example1/',
                'timestamp' => now()->subHours(2),
                'like_count' => 45,
                'comment_count' => 12
            ],
            [
                'id' => 2,
                'caption' => 'Kegiatan ekstrakurikuler basket berjalan dengan baik. Tim basket sekolah siap menghadapi turnamen antar sekolah yang akan diselenggarakan bulan depan!',
                'media_url' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example2/',
                'timestamp' => now()->subHours(5),
                'like_count' => 78,
                'comment_count' => 23
            ],
            [
                'id' => 3,
                'caption' => 'Kunjungan ke museum sejarah dalam rangka pembelajaran sejarah Indonesia. Siswa-siswi sangat tertarik dengan koleksi museum dan mendapatkan wawasan baru.',
                'media_url' => 'https://images.unsplash.com/photo-1568667256549-094345857637?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example3/',
                'timestamp' => now()->subDay(),
                'like_count' => 92,
                'comment_count' => 34
            ],
            [
                'id' => 4,
                'caption' => 'Kegiatan upacara bendera hari Senin berjalan dengan khidmat. Semoga semangat nasionalisme selalu tertanam di hati siswa-siswi untuk membangun bangsa yang lebih baik.',
                'media_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example4/',
                'timestamp' => now()->subDays(2),
                'like_count' => 156,
                'comment_count' => 28
            ],
            [
                'id' => 5,
                'caption' => 'Kegiatan praktikum laboratorium kimia. Siswa-siswi melakukan eksperimen dengan penuh semangat dan kehati-hatian. Praktikum ini membantu memahami konsep kimia secara langsung.',
                'media_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example5/',
                'timestamp' => now()->subDays(3),
                'like_count' => 203,
                'comment_count' => 45
            ],
            [
                'id' => 6,
                'caption' => 'Kegiatan seni budaya. Siswa-siswi menampilkan tarian tradisional dengan kostum yang indah dan gerakan yang gemulai. Melestarikan budaya Indonesia melalui seni.',
                'media_url' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example6/',
                'timestamp' => now()->subDays(4),
                'like_count' => 187,
                'comment_count' => 56
            ],
            [
                'id' => 7,
                'caption' => 'Kegiatan olahraga pagi bersama. Siswa-siswi melakukan senam pagi untuk menjaga kesehatan dan kebugaran tubuh. Olahraga rutin penting untuk perkembangan fisik.',
                'media_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example7/',
                'timestamp' => now()->subDays(5),
                'like_count' => 134,
                'comment_count' => 31
            ],
            [
                'id' => 8,
                'caption' => 'Kegiatan perpustakaan. Siswa-siswi antusias membaca buku di perpustakaan sekolah. Membaca adalah jendela dunia yang membuka wawasan dan pengetahuan.',
                'media_url' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=500&h=500&fit=crop',
                'media_type' => 'IMAGE',
                'permalink' => 'https://www.instagram.com/p/example8/',
                'timestamp' => now()->subDays(6),
                'like_count' => 98,
                'comment_count' => 22
            ]
        ];
    }

    /**
     * Get Instagram account information
     * Using Instagram Platform API
     */
    public function getAccountInfo()
    {
        try {
            if (empty($this->accessToken) || empty($this->userId)) {
                return null;
            }

            // Real Instagram Platform API call
            $response = Http::timeout(15)->get($this->baseUrl . "/{$this->userId}", [
                'fields' => 'id,username,name,account_type,media_count,profile_picture_url',
                'access_token' => $this->accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Instagram account info error', [
                'status' => $response->status(),
                'error' => $response->json()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Instagram account info error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Validate Instagram access token
     * Test connection by fetching account info
     */
    public function validateToken()
    {
        try {
            // Check if we have valid access token and user ID
            if (empty($this->accessToken) || empty($this->userId)) {
                return false;
            }

            // Validate by trying to get account info
            $accountInfo = $this->getAccountInfo();

            if ($accountInfo && isset($accountInfo['id'])) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Instagram token validation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get media insights
     * NEW: Instagram Platform API feature
     */
    public function getMediaInsights($mediaId, $metrics = ['engagement', 'impressions', 'reach'])
    {
        try {
            if (empty($this->accessToken)) {
                return null;
            }

            $response = Http::timeout(15)->get($this->baseUrl . "/{$mediaId}/insights", [
                'metric' => implode(',', $metrics),
                'access_token' => $this->accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Instagram media insights error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get account insights
     * NEW: Instagram Platform API feature
     */
    public function getAccountInsights($period = 'day', $metrics = ['impressions', 'reach', 'profile_views'])
    {
        try {
            if (empty($this->accessToken) || empty($this->userId)) {
                return null;
            }

            $response = Http::timeout(15)->get($this->baseUrl . "/{$this->userId}/insights", [
                'metric' => implode(',', $metrics),
                'period' => $period, // day, week, days_28, lifetime
                'access_token' => $this->accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Instagram account insights error: ' . $e->getMessage());
            return null;
        }
    }
}
