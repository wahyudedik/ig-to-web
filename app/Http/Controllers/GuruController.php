<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::with('user');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status_aktif', $request->status);
        }

        // Filter by employment status
        if ($request->has('employment_status') && $request->employment_status !== '') {
            $query->where('status_kepegawaian', $request->employment_status);
        }

        // Filter by subject
        if ($request->has('subject') && $request->subject !== '') {
            $query->whereJsonContains('mata_pelajaran', $request->subject);
        }

        // Search by name or NIP
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'nama_lengkap');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $gurus = $query->paginate(15);
        $statuses = ['aktif', 'tidak_aktif', 'pensiun', 'meninggal'];
        $employmentStatuses = ['PNS', 'CPNS', 'GTT', 'GTY', 'Honorer'];
        $subjects = $this->getAvailableSubjects();

        return view('guru.index', compact('gurus', 'statuses', 'employmentStatuses', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get subjects from database first, fallback to hardcoded if empty
        $dbSubjects = MataPelajaran::pluck('nama')->toArray();
        $subjects = !empty($dbSubjects) ? $dbSubjects : $this->getAvailableSubjects();

        // Get users that are not already assigned to any teacher
        $usedUserIds = Guru::whereNotNull('user_id')->pluck('user_id')->toArray();
        $users = User::where('user_type', 'guru')
            ->whereNotIn('id', $usedUserIds)
            ->get();

        return view('guru.create', compact('subjects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip',
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_kepegawaian' => 'required|in:PNS,CPNS,GTT,GTY,Honorer',
            'jabatan' => 'nullable|string|max:100',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
            'status_aktif' => 'required|in:aktif,tidak_aktif,pensiun,meninggal',
            'pendidikan_terakhir' => 'required|string',
            'universitas' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:4',
            'sertifikasi' => 'nullable|string',
            'mata_pelajaran' => 'required|array|min:1',
            'mata_pelajaran.*' => 'required|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id|unique:gurus,user_id',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru/photos', 'public');
        }

        $guru = Guru::create($data);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        // Get subjects from database first, fallback to hardcoded if empty
        $dbSubjects = MataPelajaran::pluck('nama')->toArray();
        $subjects = !empty($dbSubjects) ? $dbSubjects : $this->getAvailableSubjects();

        // Get users that are not already assigned to any teacher, plus the current teacher's user
        $usedUserIds = Guru::whereNotNull('user_id')
            ->where('id', '!=', $guru->id)
            ->pluck('user_id')
            ->toArray();
        $users = User::where('user_type', 'guru')
            ->where(function ($query) use ($usedUserIds, $guru) {
                $query->whereNotIn('id', $usedUserIds)
                    ->orWhere('id', $guru->user_id);
            })
            ->get();

        return view('guru.edit', compact('guru', 'subjects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_kepegawaian' => 'required|in:PNS,CPNS,GTT,GTY,Honorer',
            'jabatan' => 'nullable|string|max:100',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
            'status_aktif' => 'required|in:aktif,tidak_aktif,pensiun,meninggal',
            'pendidikan_terakhir' => 'required|string',
            'universitas' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:4',
            'sertifikasi' => 'nullable|string',
            'mata_pelajaran' => 'required|array|min:1',
            'mata_pelajaran.*' => 'required|string',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id|unique:gurus,user_id,' . $guru->id,
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru/photos', 'public');
        }

        $guru->update($data);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        // Delete photo
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Get available subjects.
     */
    private function getAvailableSubjects()
    {
        return [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Sosiologi',
            'PPKn',
            'Pendidikan Agama',
            'Seni Budaya',
            'PJOK',
            'TIK',
            'Bahasa Arab',
            'Bahasa Mandarin',
            'Bahasa Jepang',
            'Prakarya',
            'Bimbingan Konseling',
        ];
    }
}
