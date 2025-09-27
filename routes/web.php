<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OSISController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\SarprasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route - redirects based on user role
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboard routes
Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');
Route::get('/guru/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:guru'])->name('guru.dashboard');
Route::get('/siswa/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:siswa'])->name('siswa.dashboard');
Route::get('/sarpras/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:sarpras'])->name('sarpras.dashboard');

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
    Route::resource('lulus', KelulusanController::class);
    Route::get('/lulus/import', [KelulusanController::class, 'import'])->name('lulus.import');
    Route::post('/lulus/import', [KelulusanController::class, 'processImport'])->name('lulus.processImport');
    Route::get('/lulus/export', [KelulusanController::class, 'export'])->name('lulus.export');
    Route::get('/lulus/check', [KelulusanController::class, 'checkStatus'])->name('lulus.check');
    Route::post('/lulus/check', [KelulusanController::class, 'processCheck'])->name('lulus.processCheck');
    Route::get('/lulus/{kelulusan}/certificate', [KelulusanController::class, 'generateCertificate'])->name('lulus.certificate');
});

// Sarpras Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
