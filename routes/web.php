<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\InstagramAnalyticsController;
use App\Http\Controllers\InstagramManagementController;
use App\Http\Controllers\InstagramSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OSISController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route - redirects based on user role
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email'])->name('dashboard');

// Role-specific dashboard routes
Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email', 'role:superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email', 'role:admin'])->name('admin.dashboard');
Route::get('/guru/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email', 'role:guru'])->name('guru.dashboard');
Route::get('/siswa/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email', 'role:siswa'])->name('siswa.dashboard');
Route::get('/sarpras/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email', 'role:sarpras'])->name('sarpras.dashboard');

// Superadmin Routes
Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperadminController::class, 'dashboard'])->name('index');

    // User Management
    Route::get('/users', [SuperadminController::class, 'users'])->name('users');
    Route::get('/users/create', [SuperadminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperadminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [SuperadminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [SuperadminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [SuperadminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperadminController::class, 'destroyUser'])->name('users.destroy');

    // Module Access Management
    Route::get('/users/{user}/module-access', [SuperadminController::class, 'moduleAccess'])->name('users.module-access');
    Route::put('/users/{user}/module-access', [SuperadminController::class, 'updateModuleAccess'])->name('users.module-access.update');

    // Instagram Settings Management
    Route::get('/instagram-settings', [InstagramSettingController::class, 'index'])->name('instagram-settings');
    Route::post('/instagram-settings', [InstagramSettingController::class, 'store'])->name('instagram-settings.store');
    Route::post('/instagram-settings/test-connection', [InstagramSettingController::class, 'testConnection'])->name('instagram-settings.test-connection');
    Route::post('/instagram-settings/sync', [InstagramSettingController::class, 'syncData'])->name('instagram-settings.sync');
    Route::post('/instagram-settings/deactivate', [InstagramSettingController::class, 'deactivate'])->name('instagram-settings.deactivate');
    Route::get('/instagram-settings/current', [InstagramSettingController::class, 'getSettings'])->name('instagram-settings.current');
});

// Page Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Page CRUD Routes
    Route::resource('pages', PageController::class);

    // Page Additional Actions
    Route::post('/pages/{page}/publish', [PageController::class, 'publish'])->name('pages.publish');
    Route::post('/pages/{page}/unpublish', [PageController::class, 'unpublish'])->name('pages.unpublish');
    Route::post('/pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');

    // Page Versioning Routes
    Route::get('/pages/{page}/versions', [PageController::class, 'versions'])->name('pages.versions');
    Route::post('/pages/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('pages.versions.restore');
    Route::get('/pages/{page}/versions/{version1}/compare/{version2}', [PageController::class, 'compareVersions'])->name('pages.versions.compare');
});

// Guru Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('guru', GuruController::class);
});

// Siswa Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('siswa', SiswaController::class);
});

// OSIS Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/osis', [OSISController::class, 'index'])->name('osis.index');
    Route::get('/osis/calon', [OSISController::class, 'calonIndex'])->name('osis.calon.index');
    Route::get('/osis/calon/create', [OSISController::class, 'createCalon'])->name('osis.calon.create');
    Route::post('/osis/calon', [OSISController::class, 'storeCalon'])->name('osis.calon.store');
    Route::get('/osis/calon/{calon}', [OSISController::class, 'showCalon'])->name('osis.calon.show');
    Route::get('/osis/calon/{calon}/edit', [OSISController::class, 'editCalon'])->name('osis.calon.edit');
    Route::put('/osis/calon/{calon}', [OSISController::class, 'updateCalon'])->name('osis.calon.update');
    Route::delete('/osis/calon/{calon}', [OSISController::class, 'destroyCalon'])->name('osis.calon.destroy');

    Route::get('/osis/pemilih', [OSISController::class, 'pemilihIndex'])->name('osis.pemilih.index');
    Route::get('/osis/pemilih/create', [OSISController::class, 'createPemilih'])->name('osis.pemilih.create');
    Route::post('/osis/pemilih', [OSISController::class, 'storePemilih'])->name('osis.pemilih.store');
    Route::get('/osis/pemilih/{pemilih}', [OSISController::class, 'showPemilih'])->name('osis.pemilih.show');
    Route::get('/osis/pemilih/{pemilih}/edit', [OSISController::class, 'editPemilih'])->name('osis.pemilih.edit');
    Route::put('/osis/pemilih/{pemilih}', [OSISController::class, 'updatePemilih'])->name('osis.pemilih.update');
    Route::delete('/osis/pemilih/{pemilih}', [OSISController::class, 'destroyPemilih'])->name('osis.pemilih.destroy');

    Route::get('/osis/voting', [OSISController::class, 'voting'])->name('osis.voting');
    Route::post('/osis/vote', [OSISController::class, 'processVote'])->name('osis.vote');
    Route::get('/osis/results', [OSISController::class, 'results'])->name('osis.results');
    Route::get('/osis/analytics', [OSISController::class, 'analytics'])->name('osis.analytics');
});

// E-Lulus Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Specific routes must come BEFORE resource routes
    Route::get('/lulus/import', [KelulusanController::class, 'import'])->name('lulus.import');
    Route::post('/lulus/import', [KelulusanController::class, 'processImport'])->name('lulus.processImport');
    Route::get('/lulus/export', [KelulusanController::class, 'export'])->name('lulus.export');
    Route::get('/lulus/check', [KelulusanController::class, 'checkStatus'])->name('lulus.check');
    Route::post('/lulus/check', [KelulusanController::class, 'processCheck'])->name('lulus.processCheck');
    Route::get('/lulus/{kelulusan}/certificate', [KelulusanController::class, 'generateCertificate'])->name('lulus.certificate');

    // Resource routes come last
    Route::resource('lulus', KelulusanController::class)->parameters(['lulus' => 'kelulusan']);
});

// Public E-Lulus Routes (tanpa auth)
Route::get('/kelulusan/check', [KelulusanController::class, 'checkStatus'])->name('kelulusan.check');
Route::post('/kelulusan/check', [KelulusanController::class, 'processCheck'])->name('kelulusan.processCheck');

// Sarpras Management Routes
Route::middleware(['auth', 'verified', 'role:sarpras'])->group(function () {
    Route::get('/sarpras', [SarprasController::class, 'index'])->name('sarpras.index');
    Route::get('/sarpras/reports', [SarprasController::class, 'reports'])->name('sarpras.reports');

    // Kategori Management
    Route::get('/sarpras/kategori', [SarprasController::class, 'kategoriIndex'])->name('sarpras.kategori.index');
    Route::get('/sarpras/kategori/create', [SarprasController::class, 'createKategori'])->name('sarpras.kategori.create');
    Route::post('/sarpras/kategori', [SarprasController::class, 'storeKategori'])->name('sarpras.kategori.store');
    Route::get('/sarpras/kategori/{kategori}/edit', [SarprasController::class, 'editKategori'])->name('sarpras.kategori.edit');
    Route::put('/sarpras/kategori/{kategori}', [SarprasController::class, 'updateKategori'])->name('sarpras.kategori.update');
    Route::delete('/sarpras/kategori/{kategori}', [SarprasController::class, 'destroyKategori'])->name('sarpras.kategori.destroy');

    // Barang Management
    Route::get('/sarpras/barang', [SarprasController::class, 'barangIndex'])->name('sarpras.barang.index');
    Route::get('/sarpras/barang/create', [SarprasController::class, 'createBarang'])->name('sarpras.barang.create');
    Route::post('/sarpras/barang', [SarprasController::class, 'storeBarang'])->name('sarpras.barang.store');
    Route::get('/sarpras/barang/{barang}', [SarprasController::class, 'showBarang'])->name('sarpras.barang.show');
    Route::get('/sarpras/barang/{barang}/edit', [SarprasController::class, 'editBarang'])->name('sarpras.barang.edit');
    Route::put('/sarpras/barang/{barang}', [SarprasController::class, 'updateBarang'])->name('sarpras.barang.update');
    Route::delete('/sarpras/barang/{barang}', [SarprasController::class, 'destroyBarang'])->name('sarpras.barang.destroy');

    // Ruang Management
    Route::get('/sarpras/ruang', [SarprasController::class, 'ruangIndex'])->name('sarpras.ruang.index');
    Route::get('/sarpras/ruang/create', [SarprasController::class, 'createRuang'])->name('sarpras.ruang.create');
    Route::post('/sarpras/ruang', [SarprasController::class, 'storeRuang'])->name('sarpras.ruang.store');
    Route::get('/sarpras/ruang/{ruang}', [SarprasController::class, 'showRuang'])->name('sarpras.ruang.show');
    Route::get('/sarpras/ruang/{ruang}/edit', [SarprasController::class, 'editRuang'])->name('sarpras.ruang.edit');
    Route::put('/sarpras/ruang/{ruang}', [SarprasController::class, 'updateRuang'])->name('sarpras.ruang.update');
    Route::delete('/sarpras/ruang/{ruang}', [SarprasController::class, 'destroyRuang'])->name('sarpras.ruang.destroy');

    // Maintenance Management
    Route::get('/sarpras/maintenance', [SarprasController::class, 'maintenanceIndex'])->name('sarpras.maintenance.index');
    Route::get('/sarpras/maintenance/create', [SarprasController::class, 'createMaintenance'])->name('sarpras.maintenance.create');
    Route::post('/sarpras/maintenance', [SarprasController::class, 'storeMaintenance'])->name('sarpras.maintenance.store');
    Route::get('/sarpras/maintenance/{maintenance}', [SarprasController::class, 'showMaintenance'])->name('sarpras.maintenance.show');
    Route::get('/sarpras/maintenance/{maintenance}/edit', [SarprasController::class, 'editMaintenance'])->name('sarpras.maintenance.edit');
    Route::put('/sarpras/maintenance/{maintenance}', [SarprasController::class, 'updateMaintenance'])->name('sarpras.maintenance.update');
    Route::delete('/sarpras/maintenance/{maintenance}', [SarprasController::class, 'destroyMaintenance'])->name('sarpras.maintenance.destroy');
});

// Instagram Activities Routes
Route::get('/kegiatan', [InstagramController::class, 'index'])->name('instagram.activities');
Route::get('/kegiatan/refresh', [InstagramController::class, 'refresh'])->name('instagram.refresh');
Route::get('/kegiatan/posts', [InstagramController::class, 'getPosts'])->name('instagram.posts');
Route::get('/kegiatan/account', [InstagramController::class, 'getAccountInfo'])->name('instagram.account');
Route::get('/kegiatan/validate', [InstagramController::class, 'validateConnection'])->name('instagram.validate');

// Instagram Analytics Routes
Route::get('/instagram/analytics', [InstagramAnalyticsController::class, 'index'])->name('instagram.analytics');
Route::get('/instagram/analytics/data', [InstagramAnalyticsController::class, 'getAnalytics'])->name('instagram.analytics.data');
Route::get('/instagram/analytics/engagement', [InstagramAnalyticsController::class, 'getEngagementMetrics'])->name('instagram.analytics.engagement');
Route::get('/instagram/analytics/top-posts', [InstagramAnalyticsController::class, 'getTopPosts'])->name('instagram.analytics.top-posts');
Route::post('/instagram/analytics/refresh', [InstagramAnalyticsController::class, 'refreshAnalytics'])->name('instagram.analytics.refresh');

// Instagram Management Routes
Route::get('/instagram/management', [InstagramManagementController::class, 'index'])->name('instagram.management');
Route::post('/instagram/management/update-config', [InstagramManagementController::class, 'updateConfig'])->name('instagram.management.update-config');
Route::get('/instagram/management/test-connection', [InstagramManagementController::class, 'testConnection'])->name('instagram.management.test-connection');
Route::post('/instagram/management/filter-posts', [InstagramManagementController::class, 'filterPosts'])->name('instagram.management.filter-posts');
Route::post('/instagram/management/schedule-content', [InstagramManagementController::class, 'scheduleContent'])->name('instagram.management.schedule-content');
Route::get('/instagram/management/scheduled-content', [InstagramManagementController::class, 'getScheduledContent'])->name('instagram.management.scheduled-content');
Route::post('/instagram/management/cancel-scheduled', [InstagramManagementController::class, 'cancelScheduledContent'])->name('instagram.management.cancel-scheduled');
Route::get('/instagram/management/insights', [InstagramManagementController::class, 'getInsights'])->name('instagram.management.insights');

// Page Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Page CRUD Routes
    Route::resource('pages', PageController::class);
    Route::post('pages/{page}/publish', [PageController::class, 'publish'])->name('pages.publish');
    Route::post('pages/{page}/unpublish', [PageController::class, 'unpublish'])->name('pages.unpublish');
    Route::post('pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');
    Route::get('pages/{page}/versions', [PageController::class, 'versions'])->name('pages.versions');
    Route::post('pages/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('pages.versions.restore');
    Route::get('pages/{page}/versions/{version1}/compare/{version2}', [PageController::class, 'compareVersions'])->name('pages.versions.compare');
});

// Public Page Routes
Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

// Admin Page Routes (Superadmin only)
Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::get('/admin/pages', [PageController::class, 'admin'])->name('pages.admin');
    Route::resource('admin/pages', PageController::class)->except(['index', 'show']);
    Route::post('/admin/pages/{page}/publish', [PageController::class, 'publish'])->name('pages.publish');
    Route::post('/admin/pages/{page}/unpublish', [PageController::class, 'unpublish'])->name('pages.unpublish');
    Route::post('/admin/pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');
    Route::get('/admin/pages/{page}/versions', [PageController::class, 'versions'])->name('pages.versions');
    Route::post('/admin/pages/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('pages.versions.restore');
    Route::get('/admin/pages/{page}/versions/{version1}/compare/{version2}', [PageController::class, 'compareVersions'])->name('pages.versions.compare');
});

// Documentation Routes
Route::get('/docs/instagram-setup', function () {
    return view('docs.instagram-setup');
})->name('docs.instagram-setup');

// Barcode Routes
Route::get('/barcode/{code}', [SarprasController::class, 'generateBarcode'])->name('sarpras.barcode');
Route::get('/qrcode/{code}', [SarprasController::class, 'generateQRCode'])->name('sarpras.qrcode');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [App\Http\Controllers\Auth\EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/verify/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])->name('verification.resend');
});

Route::get('/email/verify/{id}/{hash}/{token}', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyRegistration'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('/email/verify/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendForGuest'])->name('verification.resend-guest');
Route::post('/email/verify/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendForGuest'])->name('verification.resend-guest.post');

// Registration Routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Data Management AJAX Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Kelas Management
    Route::post('/api/kelas', [DataManagementController::class, 'addKelas'])->name('api.kelas.add');
    Route::put('/api/kelas/{id}', [DataManagementController::class, 'updateKelas'])->name('api.kelas.update');
    Route::delete('/api/kelas/{id}', [DataManagementController::class, 'deleteKelas'])->name('api.kelas.delete');

    // Jurusan Management
    Route::post('/api/jurusan', [DataManagementController::class, 'addJurusan'])->name('api.jurusan.add');
    Route::put('/api/jurusan/{id}', [DataManagementController::class, 'updateJurusan'])->name('api.jurusan.update');
    Route::delete('/api/jurusan/{id}', [DataManagementController::class, 'deleteJurusan'])->name('api.jurusan.delete');

    // Ekstrakurikuler Management
    Route::post('/api/ekstrakurikuler', [DataManagementController::class, 'addEkstrakurikuler'])->name('api.ekstrakurikuler.add');
    Route::put('/api/ekstrakurikuler/{id}', [DataManagementController::class, 'updateEkstrakurikuler'])->name('api.ekstrakurikuler.update');
    Route::delete('/api/ekstrakurikuler/{id}', [DataManagementController::class, 'deleteEkstrakurikuler'])->name('api.ekstrakurikuler.delete');

    // User Management
    Route::post('/api/users', [DataManagementController::class, 'addUser'])->name('api.users.add');
    Route::put('/api/users/{id}', [DataManagementController::class, 'updateUser'])->name('api.users.update');
    Route::delete('/api/users/{id}', [DataManagementController::class, 'deleteUser'])->name('api.users.delete');

    // Mata Pelajaran Management
    Route::post('/api/mata-pelajaran', [DataManagementController::class, 'addMataPelajaran'])->name('api.mata-pelajaran.add');
    Route::put('/api/mata-pelajaran/{id}', [DataManagementController::class, 'updateMataPelajaran'])->name('api.mata-pelajaran.update');
    Route::delete('/api/mata-pelajaran/{id}', [DataManagementController::class, 'deleteMataPelajaran'])->name('api.mata-pelajaran.delete');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/data-management', [SettingsController::class, 'dataManagement'])->name('settings.data-management');
    Route::get('/settings/kelas-jurusan', [SettingsController::class, 'kelasJurusan'])->name('settings.kelas-jurusan');

    // Landing Page Management Routes
    Route::get('/settings/landing-page', [SettingsController::class, 'landingPage'])->name('settings.landing-page');
    Route::post('/settings/landing-page', [SettingsController::class, 'updateLandingPage'])->name('settings.landing-page.update');
    Route::post('/settings/landing-page/reset', [SettingsController::class, 'resetLandingPage'])->name('settings.landing-page.reset');
    Route::get('/settings/seo', [SettingsController::class, 'seoSettings'])->name('settings.seo');
    Route::post('/settings/seo', [SettingsController::class, 'updateSeoSettings'])->name('settings.seo.update');
});

require __DIR__ . '/auth.php';
