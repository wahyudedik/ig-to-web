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

// ========================================
// PUBLIC ROUTES (Landing Page & Public Features)
// ========================================

Route::get('/', function () {
    return view('welcome'); // Landing page - fully customizable
})->name('landing');

// Public graduation check
Route::get('/check-graduation', [KelulusanController::class, 'checkStatus'])->name('public.graduation.check');
Route::post('/check-graduation', [KelulusanController::class, 'processCheck'])->name('public.graduation.check.process');

// Public Instagram activities (Kegiatan Instagram untuk publik)
Route::get('/instagram', [InstagramController::class, 'index'])->name('public.instagram');
Route::get('/instagram/refresh', [InstagramController::class, 'refresh'])->name('public.instagram.refresh');
Route::get('/instagram/posts', [InstagramController::class, 'getPosts'])->name('public.instagram.posts');

// Alternative route for kegiatan (clean URL)
Route::get('/kegiatan', [InstagramController::class, 'index'])->name('public.kegiatan');

// Custom pages example
Route::get('/custom-example', function () {
    return view('pages.custom-example');
})->name('public.custom.example');

// ========================================
// ADMIN PANEL (All authenticated users)
// ========================================

// Single admin dashboard - redirects based on user role
Route::get('/admin', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email'])->name('admin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified.email'])->name('admin.dashboard.redirect');

// Admin profile management
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});

// ========================================
// SUPERADMIN ROUTES (Superadmin only)
// ========================================

Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('admin/superadmin')->name('admin.superadmin.')->group(function () {
    Route::get('/', [SuperadminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [SuperadminController::class, 'users'])->name('users');
    Route::get('/users/create', [SuperadminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperadminController::class, 'storeUser'])->name('users.store');

    // User Import/Export (must be before {user} routes to avoid conflicts)
    Route::get('/users/import', [SuperadminController::class, 'importUsers'])->name('users.import');
    Route::get('/users/import/template', [SuperadminController::class, 'downloadUserTemplate'])->name('users.downloadTemplate');
    Route::post('/users/import', [SuperadminController::class, 'processUserImport'])->name('users.processImport');
    Route::get('/users/export', [SuperadminController::class, 'exportUsers'])->name('users.export');

    // User CRUD with model binding (must be after specific routes)
    Route::get('/users/{user}', [SuperadminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [SuperadminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [SuperadminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperadminController::class, 'destroyUser'])->name('users.destroy');

    // Module Access Management (must be after other {user} routes)
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

// Permission Management Routes
Route::middleware(['auth', 'verified', 'role:superadmin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/bulk-create', [App\Http\Controllers\PermissionController::class, 'bulkCreate'])->name('permissions.bulk-create');
    Route::post('permissions/bulk-create', [App\Http\Controllers\PermissionController::class, 'bulkStore'])->name('permissions.bulk-store');
});

// Page Management (Access: admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/pages')->name('admin.pages.')->group(function () {
    // Page CRUD Routes
    Route::get('/', [PageController::class, 'admin'])->name('index');
    Route::get('/create', [PageController::class, 'create'])->name('create');
    Route::post('/', [PageController::class, 'store'])->name('store');
    Route::get('/{page}', [PageController::class, 'show'])->name('show');
    Route::get('/{page}/edit', [PageController::class, 'edit'])->name('edit');
    Route::put('/{page}', [PageController::class, 'update'])->name('update');
    Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy');

    // Page Additional Actions
    Route::post('/{page}/publish', [PageController::class, 'publish'])->name('publish');
    Route::post('/{page}/unpublish', [PageController::class, 'unpublish'])->name('unpublish');
    Route::post('/{page}/duplicate', [PageController::class, 'duplicate'])->name('duplicate');

    // Page Versioning Routes
    Route::get('/{page}/versions', [PageController::class, 'versions'])->name('versions');
    Route::post('/{page}/versions/{version}/restore', [PageController::class, 'restoreVersion'])->name('versions.restore');
    Route::get('/{page}/versions/{version1}/compare/{version2}', [PageController::class, 'compareVersions'])->name('versions.compare');
});

// ========================================
// MODULE MANAGEMENT ROUTES (Role-based access)
// ========================================

// Guru Management (Access: guru, admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/guru')->name('admin.guru.')->group(function () {
    // Import/Export routes (must be before resource routes)
    Route::get('/import', [GuruController::class, 'import'])->name('import');
    Route::get('/import/template', [GuruController::class, 'downloadTemplate'])->name('downloadTemplate');
    Route::post('/import', [GuruController::class, 'processImport'])->name('processImport');
    Route::get('/export', [GuruController::class, 'export'])->name('export');

    // Subject management routes
    Route::post('/add-subject', [GuruController::class, 'addSubject'])->name('addSubject');

    // CRUD routes
    Route::get('/', [GuruController::class, 'index'])->name('index');
    Route::get('/create', [GuruController::class, 'create'])->name('create');
    Route::post('/', [GuruController::class, 'store'])->name('store');
    Route::get('/{guru}', [GuruController::class, 'show'])->name('show');
    Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('edit');
    Route::put('/{guru}', [GuruController::class, 'update'])->name('update');
    Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('destroy');
});

// Siswa Management (Access: siswa, admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/siswa')->name('admin.siswa.')->group(function () {
    // Import/Export routes (must be before resource routes)
    Route::get('/import', [SiswaController::class, 'import'])->name('import');
    Route::get('/import/template', [SiswaController::class, 'downloadTemplate'])->name('downloadTemplate');
    Route::post('/import', [SiswaController::class, 'processImport'])->name('processImport');
    Route::get('/export', [SiswaController::class, 'export'])->name('export');

    // CRUD routes
    Route::get('/', [SiswaController::class, 'index'])->name('index');
    Route::get('/create', [SiswaController::class, 'create'])->name('create');
    Route::post('/', [SiswaController::class, 'store'])->name('store');
    Route::get('/{siswa}', [SiswaController::class, 'show'])->name('show');
    Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('edit');
    Route::put('/{siswa}', [SiswaController::class, 'update'])->name('update');
    Route::delete('/{siswa}', [SiswaController::class, 'destroy'])->name('destroy');
});

// OSIS Management (Access: admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/osis')->name('admin.osis.')->group(function () {
    Route::get('/', [OSISController::class, 'index'])->name('index');

    // Calon Import/Export routes
    Route::get('/calon/import', [OSISController::class, 'importCalon'])->name('calon.import');
    Route::get('/calon/import/template', [OSISController::class, 'downloadCalonTemplate'])->name('calon.downloadTemplate');
    Route::post('/calon/import', [OSISController::class, 'processCalonImport'])->name('calon.processImport');
    Route::get('/calon/export', [OSISController::class, 'exportCalon'])->name('calon.export');

    Route::get('/calon', [OSISController::class, 'calonIndex'])->name('calon.index');
    Route::get('/calon/create', [OSISController::class, 'createCalon'])->name('calon.create');
    Route::post('/calon', [OSISController::class, 'storeCalon'])->name('calon.store');
    Route::get('/calon/{calon}', [OSISController::class, 'showCalon'])->name('calon.show');
    Route::get('/calon/{calon}/edit', [OSISController::class, 'editCalon'])->name('calon.edit');
    Route::put('/calon/{calon}', [OSISController::class, 'updateCalon'])->name('calon.update');
    Route::delete('/calon/{calon}', [OSISController::class, 'destroyCalon'])->name('calon.destroy');

    Route::get('/pemilih', [OSISController::class, 'pemilihIndex'])->name('pemilih.index');
    Route::get('/pemilih/create', [OSISController::class, 'createPemilih'])->name('pemilih.create');
    Route::post('/pemilih', [OSISController::class, 'storePemilih'])->name('pemilih.store');
    Route::post('/pemilih/generate-from-users', [OSISController::class, 'generatePemilihFromUsers'])->name('pemilih.generate-from-users');

    // Pemilih CRUD with model binding (must be after specific routes)
    Route::get('/pemilih/{pemilih}', [OSISController::class, 'showPemilih'])->name('pemilih.show');
    Route::get('/pemilih/{pemilih}/edit', [OSISController::class, 'editPemilih'])->name('pemilih.edit');
    Route::put('/pemilih/{pemilih}', [OSISController::class, 'updatePemilih'])->name('pemilih.update');
    Route::delete('/pemilih/{pemilih}', [OSISController::class, 'destroyPemilih'])->name('pemilih.destroy');

    Route::get('/voting', [OSISController::class, 'voting'])->name('voting');
    Route::post('/vote', [OSISController::class, 'processVote'])->name('vote');
    Route::get('/results', [OSISController::class, 'results'])->name('results');
    Route::get('/analytics', [OSISController::class, 'analytics'])->name('analytics');
    Route::get('/teacher-view', [OSISController::class, 'teacherView'])->name('teacher-view');
});

// E-Lulus Management (Access: admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/lulus')->name('admin.lulus.')->group(function () {
    // Import/Export routes (must be before resource routes)
    Route::get('/import', [KelulusanController::class, 'import'])->name('import');
    Route::get('/import/template', [KelulusanController::class, 'downloadTemplate'])->name('downloadTemplate');
    Route::post('/import', [KelulusanController::class, 'processImport'])->name('processImport');
    Route::get('/export', [KelulusanController::class, 'export'])->name('export');
    Route::get('/check', [KelulusanController::class, 'checkStatus'])->name('check');
    Route::post('/check', [KelulusanController::class, 'processCheck'])->name('check.process');

    // CRUD routes
    Route::get('/', [KelulusanController::class, 'index'])->name('index');
    Route::get('/create', [KelulusanController::class, 'create'])->name('create');
    Route::post('/', [KelulusanController::class, 'store'])->name('store');
    Route::get('/{kelulusan}', [KelulusanController::class, 'show'])->name('show');
    Route::get('/{kelulusan}/edit', [KelulusanController::class, 'edit'])->name('edit');
    Route::put('/{kelulusan}', [KelulusanController::class, 'update'])->name('update');
    Route::delete('/{kelulusan}', [KelulusanController::class, 'destroy'])->name('destroy');
    Route::get('/{kelulusan}/certificate', [KelulusanController::class, 'generateCertificate'])->name('certificate');
});

// Sarpras Management (Access: sarpras, admin, superadmin)
Route::middleware(['auth', 'verified'])->prefix('admin/sarpras')->name('admin.sarpras.')->group(function () {
    Route::get('/', [SarprasController::class, 'index'])->name('index');
    Route::get('/reports', [SarprasController::class, 'reports'])->name('reports');

    // Kategori Management
    Route::get('/kategori', [SarprasController::class, 'kategoriIndex'])->name('kategori.index');
    Route::get('/kategori/create', [SarprasController::class, 'createKategori'])->name('kategori.create');
    Route::post('/kategori', [SarprasController::class, 'storeKategori'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [SarprasController::class, 'editKategori'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [SarprasController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [SarprasController::class, 'destroyKategori'])->name('kategori.destroy');

    // Barang Management
    Route::get('/barang', [SarprasController::class, 'barangIndex'])->name('barang.index');
    Route::get('/barang/create', [SarprasController::class, 'createBarang'])->name('barang.create');
    Route::post('/barang', [SarprasController::class, 'storeBarang'])->name('barang.store');

    // Barang Import/Export (must be before {barang} routes to avoid conflicts)
    Route::get('/barang/import', [SarprasController::class, 'importBarang'])->name('barang.import');
    Route::get('/barang/import/template', [SarprasController::class, 'downloadBarangTemplate'])->name('barang.downloadTemplate');
    Route::post('/barang/import', [SarprasController::class, 'processBarangImport'])->name('barang.processImport');
    Route::get('/barang/export', [SarprasController::class, 'exportBarang'])->name('barang.export');

    // Barang CRUD with model binding (must be after specific routes)
    Route::get('/barang/{barang}', [SarprasController::class, 'showBarang'])->name('barang.show');
    Route::get('/barang/{barang}/edit', [SarprasController::class, 'editBarang'])->name('barang.edit');
    Route::put('/barang/{barang}', [SarprasController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/barang/{barang}', [SarprasController::class, 'destroyBarang'])->name('barang.destroy');

    // Ruang Management
    Route::get('/ruang', [SarprasController::class, 'ruangIndex'])->name('ruang.index');
    Route::get('/ruang/create', [SarprasController::class, 'createRuang'])->name('ruang.create');
    Route::post('/ruang', [SarprasController::class, 'storeRuang'])->name('ruang.store');
    Route::get('/ruang/{ruang}', [SarprasController::class, 'showRuang'])->name('ruang.show');
    Route::get('/ruang/{ruang}/edit', [SarprasController::class, 'editRuang'])->name('ruang.edit');
    Route::put('/ruang/{ruang}', [SarprasController::class, 'updateRuang'])->name('ruang.update');
    Route::delete('/ruang/{ruang}', [SarprasController::class, 'destroyRuang'])->name('ruang.destroy');

    // Maintenance Management
    Route::get('/maintenance', [SarprasController::class, 'maintenanceIndex'])->name('maintenance.index');
    Route::get('/maintenance/create', [SarprasController::class, 'createMaintenance'])->name('maintenance.create');
    Route::post('/maintenance', [SarprasController::class, 'storeMaintenance'])->name('maintenance.store');
    Route::get('/maintenance/{maintenance}', [SarprasController::class, 'showMaintenance'])->name('maintenance.show');
    Route::get('/maintenance/{maintenance}/edit', [SarprasController::class, 'editMaintenance'])->name('maintenance.edit');
    Route::put('/maintenance/{maintenance}', [SarprasController::class, 'updateMaintenance'])->name('maintenance.update');
    Route::delete('/maintenance/{maintenance}', [SarprasController::class, 'destroyMaintenance'])->name('maintenance.destroy');
});

// ========================================
// INSTAGRAM MANAGEMENT ROUTES (Admin only)
// ========================================

Route::middleware(['auth', 'verified'])->prefix('admin/instagram')->name('admin.instagram.')->group(function () {
    // Instagram Management (Admin only - untuk pengaturan, bukan kegiatan publik)
    Route::get('/management', [InstagramManagementController::class, 'index'])->name('management');
    Route::post('/management/update-config', [InstagramManagementController::class, 'updateConfig'])->name('management.update-config');
    Route::get('/management/test-connection', [InstagramManagementController::class, 'testConnection'])->name('management.test-connection');
    Route::post('/management/filter-posts', [InstagramManagementController::class, 'filterPosts'])->name('management.filter-posts');
    Route::post('/management/schedule-content', [InstagramManagementController::class, 'scheduleContent'])->name('management.schedule-content');
    Route::get('/management/scheduled-content', [InstagramManagementController::class, 'getScheduledContent'])->name('management.scheduled-content');
    Route::post('/management/cancel-scheduled', [InstagramManagementController::class, 'cancelScheduledContent'])->name('management.cancel-scheduled');
    Route::get('/management/insights', [InstagramManagementController::class, 'getInsights'])->name('management.insights');

    // Instagram Analytics (Admin only)
    Route::get('/analytics', [InstagramAnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/data', [InstagramAnalyticsController::class, 'getAnalyticsData'])->name('analytics.data');
    Route::get('/analytics/engagement', [InstagramAnalyticsController::class, 'getEngagementData'])->name('analytics.engagement');
    Route::post('/analytics/refresh', [InstagramAnalyticsController::class, 'refreshAnalytics'])->name('analytics.refresh');
    Route::get('/analytics/top-posts', [InstagramAnalyticsController::class, 'getTopPosts'])->name('analytics.top-posts');

    // Instagram Account Info (Admin only)
    Route::get('/account', [InstagramController::class, 'getAccountInfo'])->name('account');
    Route::get('/validate', [InstagramController::class, 'validateConnection'])->name('validate');
    Route::get('/posts', [InstagramController::class, 'getPosts'])->name('posts');
    Route::get('/refresh', [InstagramController::class, 'refresh'])->name('refresh');
});

// ========================================
// PUBLIC PAGE ROUTES (Must be last to avoid conflicts)
// ========================================

Route::get('/pages', [PageController::class, 'publicIndex'])->name('pages.public.index');
Route::get('/page/{slug}', [PageController::class, 'publicShow'])->name('pages.public.show');

// Documentation Routes
Route::get('/docs/instagram-setup', function () {
    return view('docs.instagram-setup');
})->name('docs.instagram-setup');

// Barcode Routes
Route::get('/barcode/{code}', [SarprasController::class, 'generateBarcode'])->name('sarpras.barcode');
Route::get('/qrcode/{code}', [SarprasController::class, 'generateQRCode'])->name('sarpras.qrcode');

// Additional Barcode Routes (for authenticated users)
Route::middleware(['auth', 'verified', 'role:sarpras'])->group(function () {
    Route::post('/sarpras/barcode/generate-all', [SarprasController::class, 'generateAllBarcodes'])->name('sarpras.barcode.generate-all');
    Route::get('/sarpras/barcode/print/{barang}', [SarprasController::class, 'printBarcode'])->name('sarpras.barcode.print');
    Route::post('/sarpras/barcode/bulk-print', [SarprasController::class, 'bulkPrintBarcodes'])->name('sarpras.barcode.bulk-print');
    Route::get('/sarpras/barcode/scan', [SarprasController::class, 'showScanPage'])->name('sarpras.barcode.scan');
    Route::post('/sarpras/barcode/scan', [SarprasController::class, 'processScan'])->name('sarpras.barcode.scan.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email Verification Routes - handled in routes/auth.php

Route::get('/email/verify/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendForGuest'])->name('verification.resend-guest');
Route::post('/email/verify/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendForGuest'])->name('verification.resend-guest.post');

// Email Verification for Authenticated Users (moved from auth.php)
Route::post('/email/verify/resend-auth', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('auth');

// Registration Routes
// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// ========================================
// SETTINGS & API ROUTES (Admin only)
// ========================================

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/data-management', [SettingsController::class, 'dataManagement'])->name('settings.data-management');
    Route::get('/settings/kelas-jurusan', [SettingsController::class, 'kelasJurusan'])->name('settings.kelas-jurusan');

    // Data Management CRUD Routes
    Route::prefix('settings/data-management')->name('settings.data-management.')->group(function () {
        // Kelas routes
        Route::post('/kelas', [DataManagementController::class, 'storeKelas'])->name('kelas.store');
        Route::put('/kelas/{id}', [DataManagementController::class, 'updateKelas'])->name('kelas.update');
        Route::delete('/kelas/{id}', [DataManagementController::class, 'deleteKelas'])->name('kelas.delete');

        // Jurusan routes
        Route::post('/jurusan', [DataManagementController::class, 'storeJurusan'])->name('jurusan.store');
        Route::put('/jurusan/{id}', [DataManagementController::class, 'updateJurusan'])->name('jurusan.update');
        Route::delete('/jurusan/{id}', [DataManagementController::class, 'deleteJurusan'])->name('jurusan.delete');

        // Ekstrakurikuler routes
        Route::post('/ekstrakurikuler', [DataManagementController::class, 'storeEkstrakurikuler'])->name('ekstrakurikuler.store');
        Route::put('/ekstrakurikuler/{id}', [DataManagementController::class, 'updateEkstrakurikuler'])->name('ekstrakurikuler.update');
        Route::delete('/ekstrakurikuler/{id}', [DataManagementController::class, 'deleteEkstrakurikuler'])->name('ekstrakurikuler.delete');

        // Mata Pelajaran routes
        Route::post('/mata-pelajaran', [DataManagementController::class, 'storeMataPelajaran'])->name('mata-pelajaran.store');
        Route::put('/mata-pelajaran/{id}', [DataManagementController::class, 'updateMataPelajaran'])->name('mata-pelajaran.update');
        Route::delete('/mata-pelajaran/{id}', [DataManagementController::class, 'deleteMataPelajaran'])->name('mata-pelajaran.delete');
    });

    // Landing Page Management Routes
    Route::get('/settings/landing-page', [SettingsController::class, 'landingPage'])->name('settings.landing-page');
    Route::post('/settings/landing-page', [SettingsController::class, 'updateLandingPage'])->name('settings.landing-page.update');
    Route::post('/settings/landing-page/reset', [SettingsController::class, 'resetLandingPage'])->name('settings.landing-page.reset');
    Route::get('/settings/seo', [SettingsController::class, 'seoSettings'])->name('settings.seo');
    Route::post('/settings/seo', [SettingsController::class, 'updateSeoSettings'])->name('settings.seo.update');


    // Premium API Routes for Envato
    // Dashboard Analytics API
    // Analytics Dashboard
    Route::get('/analytics', function () {
        return view('analytics.dashboard');
    })->name('admin.analytics');

    Route::get('/api/dashboard/analytics', [App\Http\Controllers\API\DashboardAnalyticsController::class, 'index'])->name('api.dashboard.analytics');

    // System Health Dashboard
    Route::get('/system/health', function () {
        return view('system.health');
    })->name('admin.system.health');

    // System Health API
    Route::get('/api/system/health', [App\Http\Controllers\API\SystemHealthController::class, 'index'])->name('api.system.health');
    Route::get('/api/system/metrics', [App\Http\Controllers\API\SystemHealthController::class, 'metrics'])->name('api.system.metrics');

    // Notification Center Dashboard
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('admin.notifications');

    // Notification API
    Route::prefix('api/notifications')->group(function () {
        Route::get('/list', [App\Http\Controllers\API\NotificationController::class, 'list'])->name('api.notifications.list');
        Route::get('/stats', [App\Http\Controllers\API\NotificationController::class, 'stats'])->name('api.notifications.stats');
        Route::post('/send', [App\Http\Controllers\API\NotificationController::class, 'send'])->name('api.notifications.send');
        Route::post('/mark-all-read', [App\Http\Controllers\API\NotificationController::class, 'markAllAsRead'])->name('api.notifications.mark-all-read');
        Route::delete('/{id}', [App\Http\Controllers\API\NotificationController::class, 'delete'])->name('api.notifications.delete');
    });

    // User Management (Superadmin only)
    Route::prefix('user-management')->name('admin.user-management.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserManagementController::class, 'index'])->name('index');
        Route::post('/invite', [App\Http\Controllers\UserManagementController::class, 'inviteUser'])->name('invite');
        Route::post('/create', [App\Http\Controllers\UserManagementController::class, 'createUser'])->name('create');
        Route::put('/users/{user}', [App\Http\Controllers\UserManagementController::class, 'updateUser'])->name('update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserManagementController::class, 'deleteUser'])->name('delete');
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\UserManagementController::class, 'toggleUserStatus'])->name('toggle-status');
        Route::get('/roles', [App\Http\Controllers\UserManagementController::class, 'getUserRoles'])->name('roles');
    });

    // Role & Permission Management (Superadmin only)
    Route::prefix('role-permissions')->name('admin.role-permissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\RolePermissionController::class, 'index'])->name('index');
        Route::post('/roles', [App\Http\Controllers\RolePermissionController::class, 'createRole'])->name('store');
        Route::put('/roles/{role}', [App\Http\Controllers\RolePermissionController::class, 'updateRole'])->name('update');
        Route::delete('/roles/{role}', [App\Http\Controllers\RolePermissionController::class, 'deleteRole'])->name('destroy');
        Route::post('/assign-role', [App\Http\Controllers\RolePermissionController::class, 'assignRoleToUser'])->name('assign-role');
        Route::post('/remove-role', [App\Http\Controllers\RolePermissionController::class, 'removeRoleFromUser'])->name('remove-role');
        Route::get('/roles/{role}/permissions', [App\Http\Controllers\RolePermissionController::class, 'getRolePermissions'])->name('role-permissions');
        Route::get('/users', [App\Http\Controllers\RolePermissionController::class, 'getUsersWithRoles'])->name('users');
    });

    // Admin-only System Notifications
    Route::post('/api/admin/notifications/send', [App\Http\Controllers\API\NotificationController::class, 'sendSystemNotification'])->name('api.admin.notifications.send');
    Route::post('/api/admin/notifications/bulk-send', [App\Http\Controllers\API\NotificationController::class, 'sendBulkNotifications'])->name('api.admin.notifications.bulk-send');
});

require __DIR__ . '/auth.php';
