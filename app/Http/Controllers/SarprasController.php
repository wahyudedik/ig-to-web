<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarpras;
use App\Models\Barang;
use App\Models\Ruang;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $recent_maintenance = Maintenance::with(['user', 'item'])
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
        ]);

        KategoriSarpras::create($request->all());

        return redirect()->route('sarpras.kategori.index')
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
        ]);

        $kategori->update($request->all());

        return redirect()->route('sarpras.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroyKategori(KategoriSarpras $kategori)
    {
        if ($kategori->barang()->count() > 0) {
            return redirect()->route('sarpras.kategori.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki barang.');
        }

        $kategori->delete();

        return redirect()->route('sarpras.kategori.index')
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
            'lokasi' => 'nullable|string|max:255',
            'ruang_id' => 'nullable|exists:ruang,id',
            'status' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('sarpras.barang.index')
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
            'lokasi' => 'nullable|string|max:255',
            'ruang_id' => 'nullable|exists:ruang,id',
            'status' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('sarpras.barang.index')
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

        return redirect()->route('sarpras.barang.index')
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
            'jenis_ruang' => 'required|string|max:100',
            'luas_ruang' => 'nullable|numeric|min:0',
            'kapasitas' => 'nullable|integer|min:0',
            'lantai' => 'nullable|string|max:50',
            'gedung' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,renovasi',
            'status' => 'required|in:aktif,tidak_aktif,renovasi',
            'fasilitas' => 'nullable|array',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        Ruang::create($data);

        return redirect()->route('sarpras.ruang.index')
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
            'jenis_ruang' => 'required|string|max:100',
            'luas_ruang' => 'nullable|numeric|min:0',
            'kapasitas' => 'nullable|integer|min:0',
            'lantai' => 'nullable|string|max:50',
            'gedung' => 'nullable|string|max:100',
            'kondisi' => 'required|in:baik,rusak,renovasi',
            'status' => 'required|in:aktif,tidak_aktif,renovasi',
            'fasilitas' => 'nullable|array',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($ruang->foto) {
                Storage::disk('public')->delete($ruang->foto);
            }
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        $ruang->update($data);

        return redirect()->route('sarpras.ruang.index')
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

        return redirect()->route('sarpras.ruang.index')
            ->with('success', 'Ruang berhasil dihapus.');
    }

    // ==================== MAINTENANCE MANAGEMENT ====================

    /**
     * Display a listing of maintenance.
     */
    public function maintenanceIndex(Request $request)
    {
        $query = Maintenance::with(['user', 'item']);

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
        $data['user_id'] = auth()->id();
        $data['kode_maintenance'] = 'MTN-' . strtoupper(Str::random(8));

        // Handle photo uploads
        if ($request->hasFile('foto_sebelum')) {
            $data['foto_sebelum'] = $request->file('foto_sebelum')->store('maintenance', 'public');
        }

        if ($request->hasFile('foto_sesudah')) {
            $data['foto_sesudah'] = $request->file('foto_sesudah')->store('maintenance', 'public');
        }

        Maintenance::create($data);

        return redirect()->route('sarpras.maintenance.index')
            ->with('success', 'Maintenance berhasil ditambahkan.');
    }

    /**
     * Display the specified maintenance.
     */
    public function showMaintenance(Maintenance $maintenance)
    {
        $maintenance->load(['user', 'item']);
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

        return redirect()->route('sarpras.maintenance.index')
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

        return redirect()->route('sarpras.maintenance.index')
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

        return view('sarpras.reports', compact('stats', 'kategori_stats', 'maintenance_by_month'));
    }
}
