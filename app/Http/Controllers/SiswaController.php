<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by class
        if ($request->has('kelas') && $request->kelas !== '') {
            $query->where('kelas', $request->kelas);
        }

        // Filter by year
        if ($request->has('tahun_masuk') && $request->tahun_masuk !== '') {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }

        // Search by name, NIS, or NISN
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'nama_lengkap');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $siswas = $query->paginate(15);
        $statuses = ['aktif', 'lulus', 'pindah', 'keluar', 'meninggal'];
        $kelas = $this->getAvailableClasses();
        $tahunMasuk = Siswa::distinct()->pluck('tahun_masuk')->sort()->values();

        return view('siswa.index', compact('siswas', 'statuses', 'kelas', 'tahunMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = $this->getAvailableClasses();
        $jurusan = $this->getAvailableMajors();
        $ekstrakurikuler = $this->getAvailableExtracurriculars();
        $users = User::where('user_type', 'siswa')->get();

        return view('siswa.create', compact('kelas', 'jurusan', 'ekstrakurikuler', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswas,nis',
            'nisn' => 'required|string|unique:siswas,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
            'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
            'tahun_lulus' => 'nullable|integer|min:2000|max:' . date('Y'),
            'status' => 'required|in:aktif,lulus,pindah,keluar,meninggal',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'no_telepon_ortu' => 'nullable|string|max:20',
            'alamat_ortu' => 'nullable|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'ekstrakurikuler' => 'nullable|array',
            'ekstrakurikuler.*' => 'string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa/photos', 'public');
        }

        $siswa = Siswa::create($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('user');
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = $this->getAvailableClasses();
        $jurusan = $this->getAvailableMajors();
        $ekstrakurikuler = $this->getAvailableExtracurriculars();
        $users = User::where('user_type', 'siswa')->get();

        return view('siswa.edit', compact('siswa', 'kelas', 'jurusan', 'ekstrakurikuler', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
            'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
            'tahun_lulus' => 'nullable|integer|min:2000|max:' . date('Y'),
            'status' => 'required|in:aktif,lulus,pindah,keluar,meninggal',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'no_telepon_ortu' => 'nullable|string|max:20',
            'alamat_ortu' => 'nullable|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'ekstrakurikuler' => 'nullable|array',
            'ekstrakurikuler.*' => 'string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa/photos', 'public');
        }

        $siswa->update($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        // Delete photo
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Get available classes.
     */
    private function getAvailableClasses()
    {
        return [
            'X IPA 1',
            'X IPA 2',
            'X IPA 3',
            'X IPS 1',
            'X IPS 2',
            'X IPS 3',
            'XI IPA 1',
            'XI IPA 2',
            'XI IPA 3',
            'XI IPS 1',
            'XI IPS 2',
            'XI IPS 3',
            'XII IPA 1',
            'XII IPA 2',
            'XII IPA 3',
            'XII IPS 1',
            'XII IPS 2',
            'XII IPS 3',
        ];
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

    /**
     * Get available extracurriculars.
     */
    private function getAvailableExtracurriculars()
    {
        return [
            'Basket',
            'Futsal',
            'Voli',
            'Badminton',
            'Paduan Suara',
            'Tari Tradisional',
            'Teater',
            'Fotografi',
            'Debat Bahasa Inggris',
            'Matematika Club',
            'Science Club',
            'Literasi Digital',
            'Pramuka',
            'Paskibra',
            'OSIS',
            'PMR',
            'KIR',
        ];
    }
}
