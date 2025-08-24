<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected $accessToken;
    protected $userId;
    protected $baseUrl = 'https://graph.instagram.com/v12.0';

    public function __construct()
    {
        // In production, these would come from environment variables
        $this->accessToken = config('services.instagram.access_token');
        $this->userId = config('services.instagram.user_id');
    }

    /**
     * Fetch Instagram posts from API
     */
    public function fetchPosts($limit = 20)
    {
        try {
            // For demo purposes, return mock data
            // In production, uncomment the real API call below
            return $this->getMockPosts();

            // Real Instagram API call (uncomment when ready)
            /*
            $response = Http::get($this->baseUrl . "/{$this->userId}/media", [
                'fields' => 'id,caption,media_type,media_url,permalink,timestamp,like_count,comment_count',
                'access_token' => $this->accessToken,
                'limit' => $limit
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }

            Log::error('Instagram API error: ' . $response->body());
            return [];
            */
        } catch (\Exception $e) {
            Log::error('Instagram service error: ' . $e->getMessage());
            return [];
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
     */
    public function getAccountInfo()
    {
        try {
            // Mock account info
            return [
                'id' => $this->userId,
                'username' => 'sekolah_official',
                'account_type' => 'BUSINESS',
                'media_count' => 156,
                'followers_count' => 1234,
                'following_count' => 89
            ];

            // Real API call (uncomment when ready)
            /*
            $response = Http::get($this->baseUrl . "/{$this->userId}", [
                'fields' => 'id,username,account_type,media_count',
                'access_token' => $this->accessToken
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
            */
        } catch (\Exception $e) {
            Log::error('Instagram account info error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Validate Instagram access token
     */
    public function validateToken()
    {
        try {
            // Mock validation
            return true;

            // Real validation (uncomment when ready)
            /*
            $response = Http::get($this->baseUrl . "/debug_token", [
                'input_token' => $this->accessToken,
                'access_token' => $this->accessToken
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['is_valid'] ?? false;
            }

            return false;
            */
        } catch (\Exception $e) {
            Log::error('Instagram token validation error: ' . $e->getMessage());
            return false;
        }
    }
}
