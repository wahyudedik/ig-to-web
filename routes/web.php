<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route - redirects based on user role
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboard routes
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');
Route::get('/guru/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:guru'])->name('guru.dashboard');
Route::get('/siswa/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:siswa'])->name('siswa.dashboard');
Route::get('/sarpras/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:sarpras'])->name('sarpras.dashboard');

// Instagram Activities Routes
Route::get('/kegiatan', [InstagramController::class, 'index'])->name('instagram.activities');
Route::get('/kegiatan/refresh', [InstagramController::class, 'refresh'])->name('instagram.refresh');
Route::get('/kegiatan/posts', [InstagramController::class, 'getPosts'])->name('instagram.posts');
Route::get('/kegiatan/account', [InstagramController::class, 'getAccountInfo'])->name('instagram.account');
Route::get('/kegiatan/validate', [InstagramController::class, 'validateConnection'])->name('instagram.validate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
