<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstagramService;

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
}
