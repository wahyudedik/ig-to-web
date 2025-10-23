<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarpras;
use App\Models\Barang;
use App\Models\Ruang;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use App\Exports\BarangExport;

class SarprasController extends Controller
{
    /**
     * Display the Sarpras dashboard.
     */
    public function index()
    {
        $stats = [
            'total_kategori' => KategoriSarpras::count(),
            'total_barang' => Barang::count(),
            'total_ruang' => Ruang::count(),
            'total_maintenance' => Maintenance::count(),
            'barang_baik' => Barang::where('kondisi', 'baik')->count(),
            'barang_rusak' => Barang::where('kondisi', 'rusak')->count(),
            'ruang_aktif' => Ruang::where('status', 'aktif')->count(),
            'maintenance_selesai' => Maintenance::where('status', 'selesai')->count(),
        ];

        $recent_maintenance = Maintenance::with(['user', 'barang', 'ruang'])
            ->latest()
            ->limit(5)
            ->get();

        return view('sarpras.dashboard', compact('stats', 'recent_maintenance'));
    }

    // ==================== KATEGORI MANAGEMENT ====================

    /**
     * Display a listing of categories.
     */
    public function kategoriIndex(Request $request)
    {
        $query = KategoriSarpras::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('kode_kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->withCount('barang')
            ->orderBy('sort_order')
            ->orderBy('nama_kategori')
            ->paginate(15);

        return view('sarpras.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function createKategori()
    {
        return view('sarpras.kategori.create');
    }

    /**
     * Store a newly created category.
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:kategori_sarpras',
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Sanitize input data
        $data['nama_kategori'] = strip_tags($data['nama_kategori']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');

        KategoriSarpras::create($data);

        return redirect()->route('admin.sarpras.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function editKategori(KategoriSarpras $kategori)
    {
        return view('sarpras.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category.
     */
    public function updateKategori(Request $request, KategoriSarpras $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:kategori_sarpras,kode_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Sanitize input data
        $data['nama_kategori'] = strip_tags($data['nama_kategori']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');

        $kategori->update($data);

        return redirect()->route('admin.sarpras.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroyKategori(KategoriSarpras $kategori)
    {
        if ($kategori->barang()->count() > 0) {
            return redirect()->route('admin.sarpras.kategori.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki barang.');
        }

        $kategori->delete();

        return redirect()->route('admin.sarpras.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ==================== BARANG MANAGEMENT ====================

    /**
     * Display a listing of barang.
     */
    public function barangIndex(Request $request)
    {
        $query = Barang::with(['kategori', 'ruang']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by condition
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter by category
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by room
        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $barangs = $query->orderBy('nama_barang')->paginate(15);
        $kategoris = KategoriSarpras::active()->ordered()->get();
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();

        return view('sarpras.barang.index', compact('barangs', 'kategoris', 'ruangs'));
    }

    /**
     * Show the form for creating a new barang.
     */
    public function createBarang()
    {
        $kategoris = KategoriSarpras::active()->ordered()->get();
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();

        return view('sarpras.barang.create', compact('kategoris', 'ruangs'));
    }

    /**
     * Store a newly created barang.
     */
    public function storeBarang(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barang',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_sarpras,id',
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'harga_beli' => 'nullable|numeric|min:0',
            'tanggal_pembelian' => 'nullable|date',
            'sumber_dana' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'ruang_id' => 'nullable|exists:ruang,id',
            'status' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Sanitize input data
        $data['nama_barang'] = strip_tags($data['nama_barang']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');
        $data['merk'] = strip_tags($data['merk'] ?? '');
        $data['model'] = strip_tags($data['model'] ?? '');
        $data['catatan'] = strip_tags($data['catatan'] ?? '');

        // Handle photo upload - move to public storage
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active') && $request->is_active == '1';

        Barang::create($data);

        return redirect()->route('admin.sarpras.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified barang.
     */
    public function showBarang(Barang $barang)
    {
        $barang->load(['kategori', 'ruang', 'maintenance.user']);
        return view('sarpras.barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified barang.
     */
    public function editBarang(Barang $barang)
    {
        $kategoris = KategoriSarpras::active()->ordered()->get();
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();

        return view('sarpras.barang.edit', compact('barang', 'kategoris', 'ruangs'));
    }

    /**
     * Update the specified barang.
     */
    public function updateBarang(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_sarpras,id',
            'merk' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'harga_beli' => 'nullable|numeric|min:0',
            'tanggal_pembelian' => 'nullable|date',
            'sumber_dana' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'ruang_id' => 'nullable|exists:ruang,id',
            'status' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Sanitize input data
        $data['nama_barang'] = strip_tags($data['nama_barang']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');
        $data['merk'] = strip_tags($data['merk'] ?? '');
        $data['model'] = strip_tags($data['model'] ?? '');
        $data['catatan'] = strip_tags($data['catatan'] ?? '');

        // Handle photo upload - move to public storage
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active') && $request->is_active == '1';

        $barang->update($data);

        return redirect()->route('admin.sarpras.barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified barang.
     */
    public function destroyBarang(Barang $barang)
    {
        // Delete photo
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('admin.sarpras.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    // ==================== RUANG MANAGEMENT ====================

    /**
     * Display a listing of ruang.
     */
    public function ruangIndex(Request $request)
    {
        $query = Ruang::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by condition
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter by type
        if ($request->filled('jenis_ruang')) {
            $query->where('jenis_ruang', $request->jenis_ruang);
        }

        // Filter by building
        if ($request->filled('gedung')) {
            $query->where('gedung', $request->gedung);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ruang', 'like', "%{$search}%")
                    ->orWhere('kode_ruang', 'like', "%{$search}%")
                    ->orWhere('gedung', 'like', "%{$search}%");
            });
        }

        $ruangs = $query->withCount('barang')
            ->orderBy('nama_ruang')
            ->paginate(15);

        return view('sarpras.ruang.index', compact('ruangs'));
    }

    /**
     * Show the form for creating a new ruang.
     */
    public function createRuang()
    {
        return view('sarpras.ruang.create');
    }

    /**
     * Store a newly created ruang.
     */
    public function storeRuang(Request $request)
    {
        $request->validate([
            'kode_ruang' => 'required|string|max:50|unique:ruang',
            'nama_ruang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_ruang' => 'required|string|max:100',
            'luas_ruang' => 'nullable|numeric|min:0',
            'kapasitas' => 'nullable|integer|min:0',
            'lantai' => 'nullable|string|max:50',
            'gedung' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,renovasi',
            'status' => 'required|in:aktif,tidak_aktif,renovasi',
            'fasilitas' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle checkbox value
        $data['is_active'] = $request->has('is_active') && $request->is_active == '1';

        // Sanitize input data
        $data['nama_ruang'] = strip_tags($data['nama_ruang']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');
        $data['catatan'] = strip_tags($data['catatan'] ?? '');

        // Convert fasilitas string to array
        if ($request->filled('fasilitas')) {
            $data['fasilitas'] = array_map('trim', explode(',', $request->fasilitas));
        } else {
            $data['fasilitas'] = [];
        }

        // Handle photo upload - move to public storage
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        Ruang::create($data);

        return redirect()->route('admin.sarpras.ruang.index')
            ->with('success', 'Ruang berhasil ditambahkan.');
    }

    /**
     * Display the specified ruang.
     */
    public function showRuang(Ruang $ruang)
    {
        $ruang->load(['barang.kategori', 'maintenance.user']);
        return view('sarpras.ruang.show', compact('ruang'));
    }

    /**
     * Show the form for editing the specified ruang.
     */
    public function editRuang(Ruang $ruang)
    {
        return view('sarpras.ruang.edit', compact('ruang'));
    }

    /**
     * Update the specified ruang.
     */
    public function updateRuang(Request $request, Ruang $ruang)
    {
        $request->validate([
            'kode_ruang' => 'required|string|max:50|unique:ruang,kode_ruang,' . $ruang->id,
            'nama_ruang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_ruang' => 'required|string|max:100',
            'luas_ruang' => 'nullable|numeric|min:0',
            'kapasitas' => 'nullable|integer|min:0',
            'lantai' => 'nullable|string|max:50',
            'gedung' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,renovasi',
            'status' => 'required|in:aktif,tidak_aktif,renovasi',
            'fasilitas' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle checkbox value
        $data['is_active'] = $request->has('is_active') && $request->is_active == '1';

        // Sanitize input data
        $data['nama_ruang'] = strip_tags($data['nama_ruang']);
        $data['deskripsi'] = strip_tags($data['deskripsi'] ?? '');
        $data['catatan'] = strip_tags($data['catatan'] ?? '');

        // Convert fasilitas string to array
        if ($request->filled('fasilitas')) {
            $data['fasilitas'] = array_map('trim', explode(',', $request->fasilitas));
        } else {
            $data['fasilitas'] = [];
        }

        // Handle photo upload - move to public storage
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($ruang->foto) {
                Storage::disk('public')->delete($ruang->foto);
            }
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        $ruang->update($data);

        return redirect()->route('admin.sarpras.ruang.index')
            ->with('success', 'Ruang berhasil diperbarui.');
    }

    /**
     * Remove the specified ruang.
     */
    public function destroyRuang(Ruang $ruang)
    {
        // Delete photo
        if ($ruang->foto) {
            Storage::disk('public')->delete($ruang->foto);
        }

        $ruang->delete();

        return redirect()->route('admin.sarpras.ruang.index')
            ->with('success', 'Ruang berhasil dihapus.');
    }

    // ==================== MAINTENANCE MANAGEMENT ====================

    /**
     * Display a listing of maintenance.
     */
    public function maintenanceIndex(Request $request)
    {
        $query = Maintenance::with(['user', 'barang', 'ruang']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('jenis_maintenance')) {
            $query->where('jenis_maintenance', $request->jenis_maintenance);
        }

        // Filter by item type
        if ($request->filled('jenis_item')) {
            $query->where('jenis_item', $request->jenis_item);
        }

        // Filter by technician
        if ($request->filled('teknisi')) {
            $query->where('teknisi', $request->teknisi);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_maintenance', 'like', "%{$search}%")
                    ->orWhere('teknisi', 'like', "%{$search}%")
                    ->orWhere('deskripsi_masalah', 'like', "%{$search}%");
            });
        }

        $maintenances = $query->orderBy('tanggal_maintenance', 'desc')->paginate(15);

        return view('sarpras.maintenance.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new maintenance.
     */
    public function createMaintenance()
    {
        $barangs = Barang::active()->orderBy('nama_barang')->get();
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();

        return view('sarpras.maintenance.create', compact('barangs', 'ruangs'));
    }

    /**
     * Store a newly created maintenance.
     */
    public function storeMaintenance(Request $request)
    {
        $request->validate([
            'jenis_item' => 'required|in:barang,ruang',
            'item_id' => 'required|integer',
            'jenis_maintenance' => 'required|in:rutin,perbaikan,pembersihan,inspeksi',
            'deskripsi_masalah' => 'nullable|string',
            'tindakan_perbaikan' => 'nullable|string',
            'tanggal_maintenance' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_maintenance',
            'status' => 'required|in:dijadwalkan,sedang_dikerjakan,selesai,dibatalkan',
            'biaya' => 'nullable|numeric|min:0',
            'teknisi' => 'nullable|string|max:100',
            'catatan' => 'nullable|string',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['kode_maintenance'] = 'MTN-' . strtoupper(Str::random(8));

        // Handle photo uploads
        if ($request->hasFile('foto_sebelum')) {
            $data['foto_sebelum'] = $request->file('foto_sebelum')->store('maintenance', 'public');
        }

        if ($request->hasFile('foto_sesudah')) {
            $data['foto_sesudah'] = $request->file('foto_sesudah')->store('maintenance', 'public');
        }

        Maintenance::create($data);

        return redirect()->route('admin.sarpras.maintenance.index')
            ->with('success', 'Maintenance berhasil ditambahkan.');
    }

    /**
     * Display the specified maintenance.
     */
    public function showMaintenance(Maintenance $maintenance)
    {
        $maintenance->load(['user', 'barang', 'ruang']);
        return view('sarpras.maintenance.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified maintenance.
     */
    public function editMaintenance(Maintenance $maintenance)
    {
        $barangs = Barang::active()->orderBy('nama_barang')->get();
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();

        return view('sarpras.maintenance.edit', compact('maintenance', 'barangs', 'ruangs'));
    }

    /**
     * Update the specified maintenance.
     */
    public function updateMaintenance(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'jenis_item' => 'required|in:barang,ruang',
            'item_id' => 'required|integer',
            'jenis_maintenance' => 'required|in:rutin,perbaikan,pembersihan,inspeksi',
            'deskripsi_masalah' => 'nullable|string',
            'tindakan_perbaikan' => 'nullable|string',
            'tanggal_maintenance' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_maintenance',
            'status' => 'required|in:dijadwalkan,sedang_dikerjakan,selesai,dibatalkan',
            'biaya' => 'nullable|numeric|min:0',
            'teknisi' => 'nullable|string|max:100',
            'catatan' => 'nullable|string',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo uploads
        if ($request->hasFile('foto_sebelum')) {
            // Delete old photo
            if ($maintenance->foto_sebelum) {
                Storage::disk('public')->delete($maintenance->foto_sebelum);
            }
            $data['foto_sebelum'] = $request->file('foto_sebelum')->store('maintenance', 'public');
        }

        if ($request->hasFile('foto_sesudah')) {
            // Delete old photo
            if ($maintenance->foto_sesudah) {
                Storage::disk('public')->delete($maintenance->foto_sesudah);
            }
            $data['foto_sesudah'] = $request->file('foto_sesudah')->store('maintenance', 'public');
        }

        $maintenance->update($data);

        return redirect()->route('admin.sarpras.maintenance.index')
            ->with('success', 'Maintenance berhasil diperbarui.');
    }

    /**
     * Remove the specified maintenance.
     */
    public function destroyMaintenance(Maintenance $maintenance)
    {
        // Delete photos
        if ($maintenance->foto_sebelum) {
            Storage::disk('public')->delete($maintenance->foto_sebelum);
        }
        if ($maintenance->foto_sesudah) {
            Storage::disk('public')->delete($maintenance->foto_sesudah);
        }

        $maintenance->delete();

        return redirect()->route('admin.sarpras.maintenance.index')
            ->with('success', 'Maintenance berhasil dihapus.');
    }

    // ==================== REPORTS ====================

    /**
     * Display inventory reports.
     */
    public function reports()
    {
        $stats = [
            'total_barang' => Barang::count(),
            'barang_baik' => Barang::where('kondisi', 'baik')->count(),
            'barang_rusak' => Barang::where('kondisi', 'rusak')->count(),
            'barang_hilang' => Barang::where('kondisi', 'hilang')->count(),
            'total_ruang' => Ruang::count(),
            'ruang_aktif' => Ruang::where('status', 'aktif')->count(),
            'ruang_rusak' => Ruang::where('kondisi', 'rusak')->count(),
            'maintenance_selesai' => Maintenance::where('status', 'selesai')->count(),
            'maintenance_berjalan' => Maintenance::where('status', 'sedang_dikerjakan')->count(),
        ];

        $kategori_stats = KategoriSarpras::withCount('barang')
            ->orderBy('barang_count', 'desc')
            ->get();

        $maintenance_by_month = Maintenance::selectRaw('MONTH(tanggal_maintenance) as month, COUNT(*) as count')
            ->whereYear('tanggal_maintenance', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Analytics data for the view
        $analytics = [
            'total_categories' => KategoriSarpras::count(),
            'total_items' => Barang::count(),
            'total_rooms' => Ruang::count(),
            'total_value' => Barang::sum('harga_beli') ?? 0,
            'items_by_category' => $kategori_stats,
            'maintenance_pending' => Maintenance::where('status', 'dijadwalkan')->count(),
            'maintenance_in_progress' => Maintenance::where('status', 'sedang_dikerjakan')->count(),
            'maintenance_completed' => Maintenance::where('status', 'selesai')->count(),
            'maintenance_cancelled' => Maintenance::where('status', 'dibatalkan')->count(),
            'items_good' => Barang::where('kondisi', 'baik')->count(),
            'items_good_percentage' => Barang::count() > 0 ? round((Barang::where('kondisi', 'baik')->count() / Barang::count()) * 100, 1) : 0,
            'items_repair' => Barang::where('kondisi', 'rusak')->count(),
            'items_repair_percentage' => Barang::count() > 0 ? round((Barang::where('kondisi', 'rusak')->count() / Barang::count()) * 100, 1) : 0,
            'items_damaged' => Barang::where('kondisi', 'hilang')->count(),
            'items_damaged_percentage' => Barang::count() > 0 ? round((Barang::where('kondisi', 'hilang')->count() / Barang::count()) * 100, 1) : 0,
            'maintenance_cost_month' => Maintenance::whereMonth('tanggal_maintenance', now()->month)->sum('biaya') ?? 0,
            'maintenance_cost_year' => Maintenance::whereYear('tanggal_maintenance', now()->year)->sum('biaya') ?? 0,
            'maintenance_cost_total' => Maintenance::sum('biaya') ?? 0,
            'maintenance_cost_average' => Maintenance::count() > 0 ? round(Maintenance::avg('biaya'), 0) : 0,
            'recent_activities' => Maintenance::with(['user', 'barang', 'ruang'])->latest()->limit(10)->get(),
        ];

        return view('sarpras.reports', compact('stats', 'kategori_stats', 'maintenance_by_month', 'analytics'));
    }

    // ==================== BARCODE SYSTEM ====================

    /**
     * Generate barcode image.
     */
    public function generateBarcode($code)
    {
        try {
            $barcode = DNS1DFacade::getBarcodePNG($code, 'C39+', 3, 33);
            return response($barcode)->header('Content-Type', 'image/png');
        } catch (\Exception $e) {
            return response('Barcode generation failed', 500);
        }
    }

    /**
     * Generate QR code image.
     */
    public function generateQRCode($code)
    {
        try {
            $qrCode = DNS2DFacade::getBarcodePNG($code, 'QRCODE', 10, 10);
            return response($qrCode)->header('Content-Type', 'image/png');
        } catch (\Exception $e) {
            return response('QR Code generation failed', 500);
        }
    }

    /**
     * Show barcode/QR code scan page.
     */
    public function showScanPage()
    {
        return view('sarpras.scan-barcode');
    }

    /**
     * Process barcode/QR code scan.
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $barang = Barang::where('barcode', $request->code)
            ->orWhere('qr_code', $request->code)
            ->orWhere('kode_barang', $request->code)
            ->with(['kategori', 'ruang'])
            ->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang->barcode_data
        ]);
    }

    /**
     * Scan barcode/QR code (deprecated - use processScan instead).
     * @deprecated Use processScan() instead
     */
    public function scanBarcode(Request $request)
    {
        return $this->processScan($request);
    }

    /**
     * Generate barcode for all items.
     */
    public function generateAllBarcodes()
    {
        $barangs = Barang::whereNull('barcode')->orWhereNull('qr_code')->get();

        foreach ($barangs as $barang) {
            $barang->generateBarcode();
            $barang->generateQRCode();
        }

        return response()->json([
            'success' => true,
            'message' => 'Barcode berhasil digenerate untuk ' . $barangs->count() . ' barang'
        ]);
    }

    /**
     * Print barcode label.
     */
    public function printBarcode(Barang $barang)
    {
        $barang->load(['kategori', 'ruang']);
        return view('sarpras.print-barcode', compact('barang'));
    }

    /**
     * Bulk print barcodes.
     */
    public function bulkPrintBarcodes(Request $request)
    {
        $request->validate([
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'exists:barang,id',
        ]);

        $barangs = Barang::whereIn('id', $request->barang_ids)
            ->with(['kategori', 'ruang'])
            ->get();

        return view('sarpras.bulk-print-barcode', compact('barangs'));
    }

    /**
     * Show import form for barang.
     */
    public function importBarang()
    {
        return view('sarpras.barang.import');
    }

    /**
     * Download template Excel for barang import.
     */
    public function downloadBarangTemplate()
    {
        // Create sample data for template
        $sampleData = [
            [
                'nama' => 'Laptop Dell Inspiron',
                'kode_barang' => 'LPT-001',
                'kategori' => 'Elektronik',
                'ruang' => 'Lab Komputer',
                'jumlah' => '1',
                'kondisi' => 'baik',
                'status' => 'aktif',
                'harga' => '5000000',
                'tanggal_pembelian' => '2024-01-15',
                'supplier' => 'PT Teknologi',
                'deskripsi' => 'Laptop untuk pembelajaran komputer',
                'barcode' => '',
                'qr_code' => ''
            ],
            [
                'nama' => 'Meja Guru',
                'kode_barang' => 'MJG-001',
                'kategori' => 'Furnitur',
                'ruang' => 'Ruang Guru',
                'jumlah' => '1',
                'kondisi' => 'baik',
                'status' => 'aktif',
                'harga' => '800000',
                'tanggal_pembelian' => '2024-02-01',
                'supplier' => 'CV Furniture',
                'deskripsi' => 'Meja kerja untuk guru',
                'barcode' => '',
                'qr_code' => ''
            ]
        ];

        // Create a new export class for template
        $templateExport = new class($sampleData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'nama',
                    'kode_barang',
                    'kategori',
                    'ruang',
                    'jumlah',
                    'kondisi',
                    'status',
                    'harga',
                    'tanggal_pembelian',
                    'supplier',
                    'deskripsi',
                    'barcode',
                    'qr_code'
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [
                    1 => ['font' => ['bold' => true]],
                ];
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 25,
                    'B' => 15,
                    'C' => 20,
                    'D' => 20,
                    'E' => 10,
                    'F' => 15,
                    'G' => 15,
                    'H' => 15,
                    'I' => 15,
                    'J' => 20,
                    'K' => 30,
                    'L' => 15,
                    'M' => 15
                ];
            }
        };

        return Excel::download($templateExport, 'template-import-barang.xlsx');
    }

    /**
     * Process barang import.
     */
    public function processBarangImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // Get file info for logging
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            Log::info("Starting barang import process", [
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'user_id' => Auth::id()
            ]);

            // Create import instance
            $import = new BarangImport();

            // Import the file
            Excel::import($import, $file);

            // Get import results
            $importedCount = $import->getRowCount() ?? 0;
            $errors = $import->errors();
            $failures = $import->failures();

            Log::info("Barang import completed", [
                'imported_count' => $importedCount,
                'errors_count' => count($errors),
                'failures_count' => count($failures)
            ]);

            // Prepare success message with details
            $message = "Data barang berhasil diimpor!";
            $details = [];

            if ($importedCount > 0) {
                $details[] = "Berhasil mengimpor {$importedCount} barang";
            }

            if (count($failures) > 0) {
                $details[] = count($failures) . " barang gagal diimpor (cek log untuk detail)";
            }

            if (count($errors) > 0) {
                $details[] = count($errors) . " barang memiliki error validasi";
            }

            if (!empty($details)) {
                $message .= " (" . implode(', ', $details) . ")";
            }

            return redirect()->route('admin.sarpras.barang.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error("Barang import failed", [
                'error' => $e->getMessage(),
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Export barang data.
     */
    public function exportBarang(Request $request)
    {
        $query = Barang::with(['kategori', 'ruang']);

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('kondisi') && $request->kondisi !== '') {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->has('kategori_id') && $request->kategori_id !== '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('ruang_id') && $request->ruang_id !== '') {
            $query->where('ruang_id', $request->ruang_id);
        }

        $barangs = $query->get();

        return Excel::download(new BarangExport($barangs), 'barang-sarpras-' . date('Y-m-d') . '.xlsx');
    }
}
