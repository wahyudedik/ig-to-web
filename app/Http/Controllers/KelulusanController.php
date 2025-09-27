<?php

namespace App\Http\Controllers;

use App\Models\Kelulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelulusanImport;
use App\Exports\KelulusanExport;

class KelulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kelulusan::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran !== '') {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Filter by major
        if ($request->has('jurusan') && $request->jurusan !== '') {
            $query->where('jurusan', $request->jurusan);
        }

        // Search by name, NISN, or NIS
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $kelulusans = $query->paginate(15);
        $statuses = ['lulus', 'tidak_lulus', 'mengulang'];
        $tahunAjaran = Kelulusan::distinct()->pluck('tahun_ajaran')->sort()->values();
        $jurusan = Kelulusan::distinct()->pluck('jurusan')->filter();

        return view('lulus.index', compact('kelulusans', 'statuses', 'tahunAjaran', 'jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = $this->getAvailableMajors();
        $tahunAjaran = range(2020, date('Y'));

        return view('lulus.create', compact('majors', 'tahunAjaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:kelulusans,nisn',
            'nis' => 'nullable|string|unique:kelulusans,nis',
            'jurusan' => 'nullable|string|max:100',
            'tahun_ajaran' => 'required|integer|min:2000|max:' . date('Y'),
            'status' => 'required|in:lulus,tidak_lulus,mengulang',
            'tempat_kuliah' => 'nullable|string|max:255',
            'tempat_kerja' => 'nullable|string|max:255',
            'jurusan_kuliah' => 'nullable|string|max:255',
            'jabatan_kerja' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_lulus' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lulus/photos', 'public');
        }

        // Set graduation date if status is lulus
        if ($request->status === 'lulus' && !$request->tanggal_lulus) {
            $data['tanggal_lulus'] = now();
        }

        Kelulusan::create($data);

        return redirect()->route('lulus.index')
            ->with('success', 'Data kelulusan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelulusan $kelulusan)
    {
        return view('lulus.show', compact('kelulusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelulusan $kelulusan)
    {
        $majors = $this->getAvailableMajors();
        $tahunAjaran = range(2020, date('Y'));

        return view('lulus.edit', compact('kelulusan', 'majors', 'tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelulusan $kelulusan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:kelulusans,nisn,' . $kelulusan->id,
            'nis' => 'nullable|string|unique:kelulusans,nis,' . $kelulusan->id,
            'jurusan' => 'nullable|string|max:100',
            'tahun_ajaran' => 'required|integer|min:2000|max:' . date('Y'),
            'status' => 'required|in:lulus,tidak_lulus,mengulang',
            'tempat_kuliah' => 'nullable|string|max:255',
            'tempat_kerja' => 'nullable|string|max:255',
            'jurusan_kuliah' => 'nullable|string|max:255',
            'jabatan_kerja' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_lulus' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($kelulusan->foto) {
                Storage::disk('public')->delete($kelulusan->foto);
            }
            $data['foto'] = $request->file('foto')->store('lulus/photos', 'public');
        }

        $kelulusan->update($data);

        return redirect()->route('lulus.index')
            ->with('success', 'Data kelulusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelulusan $kelulusan)
    {
        // Delete photo
        if ($kelulusan->foto) {
            Storage::disk('public')->delete($kelulusan->foto);
        }

        $kelulusan->delete();

        return redirect()->route('lulus.index')
            ->with('success', 'Data kelulusan berhasil dihapus.');
    }

    /**
     * Show import form.
     */
    public function import()
    {
        return view('lulus.import');
    }

    /**
     * Process import.
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new KelulusanImport, $request->file('file'));
            return redirect()->route('lulus.index')
                ->with('success', 'Data kelulusan berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }

    /**
     * Export data.
     */
    public function export(Request $request)
    {
        $query = Kelulusan::query();

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran !== '') {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->has('jurusan') && $request->jurusan !== '') {
            $query->where('jurusan', $request->jurusan);
        }

        $kelulusans = $query->get();

        return Excel::download(new KelulusanExport($kelulusans), 'kelulusan-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Check graduation status.
     */
    public function checkStatus()
    {
        return view('lulus.check');
    }

    /**
     * Process status check.
     */
    public function processCheck(Request $request)
    {
        $request->validate([
            'nisn' => 'required_without:nis|string',
            'nis' => 'required_without:nisn|string',
        ]);

        $query = Kelulusan::query();

        if ($request->nisn) {
            $query->where('nisn', $request->nisn);
        } elseif ($request->nis) {
            $query->where('nis', $request->nis);
        }

        $kelulusan = $query->first();

        if (!$kelulusan) {
            return redirect()->back()
                ->with('error', 'Data tidak ditemukan. Silakan periksa NISN atau NIS yang dimasukkan.');
        }

        return view('lulus.result', compact('kelulusan'));
    }

    /**
     * Generate certificate.
     */
    public function generateCertificate(Kelulusan $kelulusan)
    {
        // This would integrate with a PDF generation library
        // For now, we'll return a success message
        return redirect()->back()
            ->with('success', 'Sertifikat kelulusan akan segera dibuat untuk ' . $kelulusan->nama);
    }

    /**
     * Get available majors.
     */
    private function getAvailableMajors()
    {
        return [
            'IPA (Ilmu Pengetahuan Alam)',
            'IPS (Ilmu Pengetahuan Sosial)',
            'Bahasa',
            'Teknik Informatika',
            'Teknik Mesin',
            'Teknik Elektro',
            'Akuntansi',
            'Administrasi Perkantoran',
            'Pemasaran',
        ];
    }
}
