<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\KategoriSarpras;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaranaController extends Controller
{
    /**
     * Display a listing of the sarana.
     */
    public function index(Request $request)
    {
        $query = Sarana::with(['ruang', 'barang.kategori']);

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->kategori($request->kategori_id);
        }

        // Filter by sumber dana
        if ($request->filled('sumber_dana')) {
            $query->sumberDana($request->sumber_dana);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_inventaris', 'like', "%{$search}%")
                    ->orWhere('sumber_dana', 'like', "%{$search}%")
                    ->orWhere('kode_sumber_dana', 'like', "%{$search}%")
                    ->orWhereHas('ruang', function ($r) use ($search) {
                        $r->where('nama_ruang', 'like', "%{$search}%");
                    })
                    ->orWhereHas('barang', function ($b) use ($search) {
                        $b->where('nama_barang', 'like', "%{$search}%");
                    });
            });
        }

        $saranas = $query->latest('tanggal')->paginate(15);
        $kategoris = KategoriSarpras::active()->orderBy('nama_kategori')->get();
        $sumberDanas = Sarana::distinct()->whereNotNull('sumber_dana')->pluck('sumber_dana')->sort()->values();

        return view('sarpras.sarana.index', compact('saranas', 'kategoris', 'sumberDanas'));
    }

    /**
     * Show the form for creating a new sarana.
     */
    public function create()
    {
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();
        
        // Get barang IDs that are already used in other sarana
        $usedBarangIds = \DB::table('sarana_barang')->pluck('barang_id')->unique()->toArray();
        
        // Get available barang:
        // 1. Barang yang belum punya ruang (ruang_id = null) dan belum digunakan
        // 2. Barang yang sudah digunakan akan di-filter via AJAX berdasarkan ruang yang dipilih
        $barangs = Barang::with('kategori')
            ->active()
            ->whereNotIn('id', $usedBarangIds)
            ->orderBy('nama_barang')
            ->get();
        
        $kategoris = KategoriSarpras::active()->orderBy('nama_kategori')->get();

        // Prepare barang data for JavaScript
        $barangsJson = $barangs->map(function($b) use ($usedBarangIds) {
            return [
                'id' => $b->id,
                'nama_barang' => $b->nama_barang,
                'kode_barang' => $b->kode_barang,
                'kategori' => $b->kategori->nama_kategori ?? '-',
                'ruang_id' => $b->ruang_id, // Include ruang_id to check if barang has room
                'harga_beli' => $b->harga_beli ?? 0, // Include harga
                'is_used' => in_array($b->id, $usedBarangIds), // Indikator apakah sudah digunakan (seharusnya false karena sudah di-filter)
            ];
        })->values()->all();

        return view('sarpras.sarana.create', compact('ruangs', 'barangs', 'kategoris', 'barangsJson'));
    }

    /**
     * Store a newly created sarana.
     */
    public function store(Request $request)
    {
        \Log::info('Sarana store method called', [
            'request_data' => $request->all(),
            'barang_ids' => $request->barang_ids ?? [],
            'jumlah' => $request->jumlah ?? [],
            'kondisi' => $request->kondisi ?? [],
        ]);

        try {
            // Filter out empty values from barang_ids before validation
            $originalBarangIds = $request->barang_ids ?? [];
            $filteredBarangIds = array_filter($originalBarangIds, function($id) {
                return !empty($id) && $id !== '';
            });
            
            if (empty($filteredBarangIds)) {
                \Log::warning('No valid barang_ids found', ['original' => $originalBarangIds]);
                return back()->withErrors(['barang_ids' => 'Minimal satu barang harus dipilih.'])->withInput();
            }
            
            // Rebuild jumlah and kondisi arrays to match filtered barang_ids
            $filteredJumlah = [];
            $filteredKondisi = [];
            $newIndex = 0;
            
            foreach ($originalBarangIds as $oldIndex => $barangId) {
                if (!empty($barangId) && $barangId !== '') {
                    $filteredJumlah[$newIndex] = $request->jumlah[$oldIndex] ?? 1;
                    $filteredKondisi[$newIndex] = $request->kondisi[$oldIndex] ?? 'baik';
                    $newIndex++;
                }
            }
            
            $request->merge([
                'barang_ids' => array_values($filteredBarangIds),
                'jumlah' => $filteredJumlah,
                'kondisi' => $filteredKondisi,
            ]);
            
            \Log::info('After filtering and merging', [
                'barang_ids' => $request->barang_ids,
                'jumlah' => $request->jumlah,
                'kondisi' => $request->kondisi,
            ]);
            
            $request->validate([
                'ruang_id' => 'required|exists:ruang,id',
                'barang_ids' => 'required|array|min:1',
                'barang_ids.*' => 'required|exists:barang,id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1',
                'kondisi' => 'required|array',
                'kondisi.*' => 'required|in:baik,rusak,hilang',
                'sumber_dana' => 'nullable|string|max:255',
                'kode_sumber_dana' => 'required|string|max:100',
                'tanggal' => 'required|date',
                'catatan' => 'nullable|string',
            ], [
                'ruang_id.required' => 'Ruang harus dipilih.',
                'ruang_id.exists' => 'Ruang yang dipilih tidak valid.',
                'barang_ids.required' => 'Minimal satu barang harus dipilih.',
                'barang_ids.min' => 'Minimal satu barang harus dipilih.',
                'barang_ids.*.required' => 'Barang harus dipilih.',
                'barang_ids.*.exists' => 'Barang yang dipilih tidak valid.',
                'kode_sumber_dana.required' => 'Kode sumber dana harus diisi.',
                'tanggal.required' => 'Tanggal harus diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
            ]);

            \Log::info('Validation passed');

            // Use DB transaction to ensure data consistency
            return \DB::transaction(function() use ($request) {
                \Log::info('Starting DB transaction');
                
                // Check if any barang is already used in other sarana
                $usedBarangIds = \DB::table('sarana_barang')->pluck('barang_id')->unique()->toArray();
                $conflictingBarangs = [];
                
                // Prepare barang data and validate
                $barangData = [];
                $totalJumlah = 0;
                $firstBarang = null;
                
                foreach ($request->barang_ids as $index => $barangId) {
                    if (empty($barangId)) continue;
                    
                    // Check if barang is already used
                    if (in_array($barangId, $usedBarangIds)) {
                        $barang = Barang::find($barangId);
                        $conflictingBarangs[] = $barang ? $barang->nama_barang . ' (' . $barang->kode_barang . ')' : 'Barang ID: ' . $barangId;
                        continue;
                    }
                    
                    $jumlah = isset($request->jumlah[$index]) ? (int)$request->jumlah[$index] : 1;
                    $kondisi = $request->kondisi[$index] ?? 'baik';
                    
                    $totalJumlah += $jumlah;
                    if ($firstBarang === null) {
                        $firstBarang = Barang::find($barangId);
                    }
                    $barangData[$barangId] = [
                        'jumlah' => $jumlah,
                        'kondisi' => $kondisi,
                    ];
                }
                
                \Log::info('Barang data prepared', [
                    'barang_data' => $barangData,
                    'total_jumlah' => $totalJumlah,
                ]);
                
                if (!empty($conflictingBarangs)) {
                    \Log::warning('Conflicting barangs found', ['conflicting' => $conflictingBarangs]);
                    throw new \Illuminate\Validation\ValidationException(
                        \Validator::make([], []),
                        ['barang_ids' => 'Barang berikut sudah digunakan di sarana lain: ' . implode(', ', $conflictingBarangs)]
                    );
                }

                if (empty($barangData)) {
                    \Log::warning('No barang data after filtering');
                    throw new \Illuminate\Validation\ValidationException(
                        \Validator::make([], []),
                        ['barang_ids' => 'Minimal satu barang harus dipilih.']
                    );
                }

                \Log::info('Creating sarana record');
                // Create sarana with temporary kode_inventaris
                $sarana = Sarana::create([
                    'ruang_id' => $request->ruang_id,
                    'sumber_dana' => $request->sumber_dana,
                    'kode_sumber_dana' => $request->kode_sumber_dana,
                    'tanggal' => $request->tanggal,
                    'catatan' => $request->catatan,
                    'kode_inventaris' => 'TEMP', // Temporary, will be updated
                ]);
                
                \Log::info('Sarana created', ['sarana_id' => $sarana->id]);

                \Log::info('Attaching barang to sarana');
                // Attach barang with pivot data
                $sarana->barang()->attach($barangData);
                
                \Log::info('Barang attached successfully');

                // Update ruang_id di tabel barang untuk barang yang ditambahkan
                $barangIdsToUpdate = array_keys($barangData);
                if (!empty($barangIdsToUpdate)) {
                    \Log::info('Updating ruang_id for barang', ['barang_ids' => $barangIdsToUpdate]);
                    $updated = Barang::whereIn('id', $barangIdsToUpdate)
                        ->update(['ruang_id' => $request->ruang_id]);
                    
                    \Log::info('Updated ruang_id for barang', [
                        'barang_ids' => $barangIdsToUpdate,
                        'ruang_id' => $request->ruang_id,
                        'updated_count' => $updated
                    ]);
                }

                // Generate kode inventaris after barang is attached
                $lastSarana = Sarana::orderBy('id', 'desc')->where('id', '!=', $sarana->id)->first();
                $no = $lastSarana ? $lastSarana->id + 1 : $sarana->id;
                $sarana->kode_inventaris = $sarana->generateKodeInventaris(
                    $no,
                    $totalJumlah,
                    $firstBarang ? $firstBarang->kode_barang : null
                );
                $sarana->save();
                
                \Log::info('Sarana saved successfully', [
                    'sarana_id' => $sarana->id,
                    'kode_inventaris' => $sarana->kode_inventaris
                ]);

                return redirect()->route('admin.sarpras.sarana.index')
                    ->with('success', 'Sarana berhasil ditambahkan.');
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation exception', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing sarana: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified sarana.
     */
    public function show(Sarana $sarana)
    {
        $sarana->load(['ruang', 'barang.kategori']);
        return view('sarpras.sarana.show', compact('sarana'));
    }

    /**
     * Show the form for editing the specified sarana.
     */
    public function edit(Sarana $sarana)
    {
        $sarana->load(['ruang', 'barang.kategori']);
        $ruangs = Ruang::active()->orderBy('nama_ruang')->get();
        
        // Get barang IDs that are already used in other sarana (exclude current sarana)
        $usedBarangIds = \DB::table('sarana_barang')
            ->where('sarana_id', '!=', $sarana->id)
            ->pluck('barang_id')
            ->unique()
            ->toArray();
        
        // Get available barang:
        // 1. Barang yang belum punya ruang (ruang_id = null) dan belum digunakan
        // 2. Barang yang ada di ruang yang sama dengan sarana ini dan belum digunakan
        // 3. Barang yang sudah ada di sarana ini (bisa tetap digunakan)
        $barangs = Barang::with('kategori')
            ->active()
            ->where(function($query) use ($usedBarangIds, $sarana) {
                $query->where(function($q) use ($usedBarangIds, $sarana) {
                    // Barang yang belum punya ruang atau ada di ruang yang sama
                    $q->whereNull('ruang_id')
                        ->orWhere('ruang_id', $sarana->ruang_id);
                })
                ->where(function($q) use ($usedBarangIds, $sarana) {
                    // Exclude yang sudah digunakan di sarana lain, tapi include yang sudah ada di sarana ini
                    $q->whereNotIn('id', $usedBarangIds)
                        ->orWhereIn('id', $sarana->barang->pluck('id')->toArray());
                });
            })
            ->orderBy('nama_barang')
            ->get();
        
        $kategoris = KategoriSarpras::active()->orderBy('nama_kategori')->get();

        // Prepare barang data for JavaScript
        $currentSaranaBarangIds = $sarana->barang->pluck('id')->toArray();
        $barangsJson = $barangs->map(function($b) use ($usedBarangIds, $currentSaranaBarangIds) {
            // Barang dianggap "sudah digunakan" jika ada di sarana lain (bukan sarana yang sedang diedit)
            $isUsed = in_array($b->id, $usedBarangIds) && !in_array($b->id, $currentSaranaBarangIds);
            return [
                'id' => $b->id,
                'nama_barang' => $b->nama_barang,
                'kode_barang' => $b->kode_barang,
                'kategori' => $b->kategori->nama_kategori ?? '-',
                'ruang_id' => $b->ruang_id, // Include ruang_id
                'harga_beli' => $b->harga_beli ?? 0, // Include harga
                'is_used' => $isUsed, // Indikator apakah sudah digunakan di sarana lain
            ];
        })->values()->all();

        // Prepare sarana barang data for JavaScript
        $saranaBarangsJson = $sarana->barang->map(function($b) {
            return [
                'barang_id' => $b->id,
                'jumlah' => $b->pivot->jumlah,
                'kondisi' => $b->pivot->kondisi,
                'harga_beli' => $b->harga_beli ?? 0, // Include harga
            ];
        })->values()->all();

        return view('sarpras.sarana.edit', compact('sarana', 'ruangs', 'barangs', 'kategoris', 'barangsJson', 'saranaBarangsJson'));
    }

    /**
     * Update the specified sarana.
     */
    public function update(Request $request, Sarana $sarana)
    {
        try {
            $request->validate([
                'ruang_id' => 'required|exists:ruang,id',
                'barang_ids' => 'required|array|min:1',
                'barang_ids.*' => 'exists:barang,id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1',
                'kondisi' => 'required|array',
                'kondisi.*' => 'required|in:baik,rusak,hilang',
                'sumber_dana' => 'nullable|string|max:255',
                'kode_sumber_dana' => 'required|string|max:100',
                'tanggal' => 'required|date',
                'catatan' => 'nullable|string',
            ], [
                'ruang_id.required' => 'Ruang harus dipilih.',
                'ruang_id.exists' => 'Ruang yang dipilih tidak valid.',
                'barang_ids.required' => 'Minimal satu barang harus dipilih.',
                'barang_ids.min' => 'Minimal satu barang harus dipilih.',
                'kode_sumber_dana.required' => 'Kode sumber dana harus diisi.',
                'tanggal.required' => 'Tanggal harus diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
            ]);

            // Update sarana
            $sarana->update([
                'ruang_id' => $request->ruang_id,
                'sumber_dana' => $request->sumber_dana,
                'kode_sumber_dana' => $request->kode_sumber_dana,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
            ]);

            // Check if any barang is already used in other sarana (exclude current sarana)
            $usedBarangIds = \DB::table('sarana_barang')
                ->where('sarana_id', '!=', $sarana->id)
                ->pluck('barang_id')
                ->unique()
                ->toArray();
            
            $currentSaranaBarangIds = $sarana->barang->pluck('id')->toArray();
            $conflictingBarangs = [];
            
            // Sync barang with pivot data
            $barangData = [];
            $totalJumlah = 0;
            $firstBarang = null;
            foreach ($request->barang_ids as $index => $barangId) {
                if (empty($barangId)) continue; // Skip empty values
                
                // Check if barang is already used in other sarana (but allow if it's from current sarana)
                if (in_array($barangId, $usedBarangIds) && !in_array($barangId, $currentSaranaBarangIds)) {
                    $barang = Barang::find($barangId);
                    $conflictingBarangs[] = $barang ? $barang->nama_barang . ' (' . $barang->kode_barang . ')' : 'Barang ID: ' . $barangId;
                    continue;
                }
                
                $jumlah = isset($request->jumlah[$index]) ? (int)$request->jumlah[$index] : 1;
                $totalJumlah += $jumlah;
                if ($firstBarang === null) {
                    $firstBarang = Barang::find($barangId);
                }
                $barangData[$barangId] = [
                    'jumlah' => $jumlah,
                    'kondisi' => $request->kondisi[$index] ?? 'baik',
                ];
            }
            
            if (!empty($conflictingBarangs)) {
                return back()->withErrors([
                    'barang_ids' => 'Barang berikut sudah digunakan di sarana lain: ' . implode(', ', $conflictingBarangs)
                ])->withInput();
            }

            if (empty($barangData)) {
                return back()->withErrors(['barang_ids' => 'Minimal satu barang harus dipilih.'])->withInput();
            }

            $sarana->barang()->sync($barangData);

            // Update ruang_id di tabel barang untuk barang yang ditambahkan
            foreach (array_keys($barangData) as $barangId) {
                Barang::where('id', $barangId)->update(['ruang_id' => $request->ruang_id]);
            }

            // Regenerate kode inventaris
            $sarana->kode_inventaris = $sarana->generateKodeInventaris(
                $sarana->id,
                $totalJumlah,
                $firstBarang ? $firstBarang->kode_barang : null
            );
            $sarana->save();

            return redirect()->route('admin.sarpras.sarana.index')
                ->with('success', 'Sarana berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating sarana: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified sarana.
     */
    public function destroy(Sarana $sarana)
    {
        $sarana->delete();

        return redirect()->route('admin.sarpras.sarana.index')
            ->with('success', 'Sarana berhasil dihapus.');
    }

    /**
     * Get barang by ruang_id (AJAX).
     */
    public function getBarangByRuang(Request $request)
    {
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id',
            'sarana_id' => 'nullable|exists:sarana,id', // For edit mode
        ]);

        // Get barang IDs that are already used in other sarana
        $usedBarangIds = \DB::table('sarana_barang')
            ->when($request->filled('sarana_id'), function($query) use ($request) {
                // Exclude barang from current sarana being edited
                return $query->where('sarana_id', '!=', $request->sarana_id);
            })
            ->pluck('barang_id')
            ->unique()
            ->toArray();

        // Get barang yang bisa dipilih:
        // 1. Barang yang ada di ruang yang dipilih (HARUS muncul, meskipun sudah digunakan di sarana lain - untuk konsistensi dengan detail ruang)
        // 2. Barang yang belum punya ruang (ruang_id = null) dan belum digunakan di sarana lain
        $barangs = Barang::with('kategori')
            ->where(function($query) use ($request, $usedBarangIds) {
                // Barang di ruang yang dipilih (selalu tampilkan, meskipun sudah digunakan)
                $query->where('ruang_id', $request->ruang_id)
                    // Atau barang yang belum punya ruang dan belum digunakan
                    ->orWhere(function($q) use ($usedBarangIds) {
                        $q->whereNull('ruang_id')
                            ->whereNotIn('id', $usedBarangIds);
                    });
            })
            ->active()
            ->orderByRaw("CASE WHEN ruang_id = ? THEN 0 ELSE 1 END", [$request->ruang_id])
            ->orderBy('nama_barang')
            ->get();

        return response()->json([
            'success' => true,
            'barangs' => $barangs->map(function ($barang) use ($usedBarangIds) {
                $isUsed = in_array($barang->id, $usedBarangIds);
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'kode_barang' => $barang->kode_barang,
                    'kategori' => $barang->kategori->nama_kategori ?? '-',
                    'ruang_id' => $barang->ruang_id, // Include ruang_id
                    'harga_beli' => $barang->harga_beli ?? 0, // Include harga
                    'is_used' => $isUsed, // Indikator apakah sudah digunakan di sarana lain
                ];
            }),
        ]);
    }

    /**
     * Print invoice for sarana.
     */
    public function printInvoice(Sarana $sarana)
    {
        $sarana->load(['ruang', 'barang.kategori']);
        
        $pdf = Pdf::loadView('sarpras.sarana.invoice', compact('sarana'));
        $pdf->setPaper('a4', 'portrait');

        // Sanitize filename: replace invalid characters with dashes
        $filename = 'invoice-sarana-' . $sarana->kode_inventaris . '.pdf';
        $filename = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $filename);
        
        return $pdf->download($filename);
    }
}
