<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstagramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
