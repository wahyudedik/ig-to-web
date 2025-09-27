<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Pemilih;
use App\Models\Voting;
use App\Models\Siswa;
use App\Models\OsisElection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OSISController extends Controller
{
    /**
     * Display OSIS dashboard.
     */
    public function index()
    {
        $stats = [
            'total_calon' => Calon::active()->count(),
            'total_pemilih' => Pemilih::active()->count(),
            'total_votes' => Voting::valid()->count(),
            'voting_percentage' => $this->getVotingPercentage(),
        ];

        $calons = Calon::active()->ordered()->withCount('votings')->get();
        $recentVotes = Voting::with(['calon', 'pemilih'])
            ->valid()
            ->latest()
            ->limit(10)
            ->get();

        return view('osis.index', compact('stats', 'calons', 'recentVotes'));
    }

    /**
     * Display calon management.
     */
    public function calonIndex(Request $request)
    {
        $query = Calon::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by pencalonan type
        if ($request->has('jenis_pencalonan') && $request->jenis_pencalonan !== '') {
            $query->where('jenis_pencalonan', $request->jenis_pencalonan);
        }

        // Search by name
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ketua', 'like', '%' . $search . '%')
                    ->orWhere('nama_wakil', 'like', '%' . $search . '%');
            });
        }

        $calons = $query->withCount('votings')->paginate(15);
        $pencalonanTypes = ['ketua', 'wakil', 'pasangan'];

        return view('osis.calon.index', compact('calons', 'pencalonanTypes'));
    }

    /**
     * Show the form for creating a new calon.
     */
    public function createCalon()
    {
        return view('osis.calon.create');
    }

    /**
     * Store a newly created calon.
     */
    public function storeCalon(Request $request)
    {
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'foto_ketua' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_wakil' => 'nullable|string|max:255',
            'foto_wakil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi_misi' => 'required|string',
            'jenis_pencalonan' => 'required|in:ketua,wakil,pasangan',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle photo uploads
        if ($request->hasFile('foto_ketua')) {
            $data['foto_ketua'] = $request->file('foto_ketua')->store('osis/calon', 'public');
        }
        if ($request->hasFile('foto_wakil')) {
            $data['foto_wakil'] = $request->file('foto_wakil')->store('osis/calon', 'public');
        }

        Calon::create($data);

        return redirect()->route('osis.calon.index')
            ->with('success', 'Calon berhasil ditambahkan.');
    }

    /**
     * Display the specified calon.
     */
    public function showCalon(Calon $calon)
    {
        $calon->loadCount('votings');
        return view('osis.calon.show', compact('calon'));
    }

    /**
     * Show the form for editing the specified calon.
     */
    public function editCalon(Calon $calon)
    {
        return view('osis.calon.edit', compact('calon'));
    }

    /**
     * Update the specified calon.
     */
    public function updateCalon(Request $request, Calon $calon)
    {
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'foto_ketua' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_wakil' => 'nullable|string|max:255',
            'foto_wakil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi_misi' => 'required|string',
            'jenis_pencalonan' => 'required|in:ketua,wakil,pasangan',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle photo uploads
        if ($request->hasFile('foto_ketua')) {
            if ($calon->foto_ketua) {
                Storage::disk('public')->delete($calon->foto_ketua);
            }
            $data['foto_ketua'] = $request->file('foto_ketua')->store('osis/calon', 'public');
        }
        if ($request->hasFile('foto_wakil')) {
            if ($calon->foto_wakil) {
                Storage::disk('public')->delete($calon->foto_wakil);
            }
            $data['foto_wakil'] = $request->file('foto_wakil')->store('osis/calon', 'public');
        }

        $calon->update($data);

        return redirect()->route('osis.calon.index')
            ->with('success', 'Calon berhasil diperbarui.');
    }

    /**
     * Remove the specified calon.
     */
    public function destroyCalon(Calon $calon)
    {
        // Delete photos
        if ($calon->foto_ketua) {
            Storage::disk('public')->delete($calon->foto_ketua);
        }
        if ($calon->foto_wakil) {
            Storage::disk('public')->delete($calon->foto_wakil);
        }

        $calon->delete();

        return redirect()->route('osis.calon.index')
            ->with('success', 'Calon berhasil dihapus.');
    }

    /**
     * Display pemilih management.
     */
    public function pemilihIndex(Request $request)
    {
        $query = Pemilih::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'sudah_memilih') {
                $query->sudahMemilih();
            } elseif ($request->status === 'belum_memilih') {
                $query->belumMemilih();
            }
        }

        // Filter by class
        if ($request->has('kelas') && $request->kelas !== '') {
            $query->kelas($request->kelas);
        }

        // Search by name or NIS
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }

        $pemilihs = $query->orderBy('nama')->paginate(15);
        $kelas = $this->getAvailableClasses();

        return view('osis.pemilih.index', compact('pemilihs', 'kelas'));
    }

    /**
     * Show the form for creating a new pemilih.
     */
    public function createPemilih()
    {
        $kelas = $this->getAvailableClasses();
        return view('osis.pemilih.create', compact('kelas'));
    }

    /**
     * Store a newly created pemilih.
     */
    public function storePemilih(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:pemilihs,nis',
            'kelas' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        Pemilih::create($request->all());

        return redirect()->route('osis.pemilih.index')
            ->with('success', 'Pemilih berhasil ditambahkan.');
    }

    /**
     * Display the specified pemilih.
     */
    public function showPemilih(Pemilih $pemilih)
    {
        $pemilih->load('votings.calon');
        return view('osis.pemilih.show', compact('pemilih'));
    }

    /**
     * Show the form for editing the specified pemilih.
     */
    public function editPemilih(Pemilih $pemilih)
    {
        $kelas = $this->getAvailableClasses();
        return view('osis.pemilih.edit', compact('pemilih', 'kelas'));
    }

    /**
     * Update the specified pemilih.
     */
    public function updatePemilih(Request $request, Pemilih $pemilih)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:pemilihs,nis,' . $pemilih->id,
            'kelas' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $pemilih->update($request->all());

        return redirect()->route('osis.pemilih.index')
            ->with('success', 'Pemilih berhasil diperbarui.');
    }

    /**
     * Remove the specified pemilih.
     */
    public function destroyPemilih(Pemilih $pemilih)
    {
        $pemilih->delete();

        return redirect()->route('osis.pemilih.index')
            ->with('success', 'Pemilih berhasil dihapus.');
    }

    /**
     * Display voting interface.
     */
    public function voting()
    {
        // Check if user is a student
        $user = Auth::user();
        if ($user->user_type !== 'siswa') {
            return redirect()->route('dashboard')
                ->with('error', 'Hanya siswa yang dapat memilih.');
        }

        // Get student data
        $siswa = Siswa::where('user_id', $user->id)->first();
        if (!$siswa) {
            return redirect()->route('dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Check if student has already voted
        if ($siswa->hasVotedOsis()) {
            return redirect()->route('osis.results')
                ->with('info', 'Anda sudah memilih dalam pemilihan OSIS ini.');
        }

        // Get active election
        $election = OsisElection::active()->first();
        if (!$election) {
            return redirect()->route('osis.index')
                ->with('error', 'Tidak ada pemilihan OSIS yang sedang berlangsung.');
        }

        // Check if student's class is allowed to vote
        if ($election->allowed_classes && !in_array($siswa->kelas, $election->allowed_classes)) {
            return redirect()->route('osis.index')
                ->with('error', 'Kelas Anda tidak diizinkan untuk memilih dalam pemilihan ini.');
        }

        $calons = $election->candidates()->active()->ordered()->get();

        return view('osis.voting', compact('calons', 'siswa', 'election'));
    }

    /**
     * Process vote.
     */
    public function processVote(Request $request)
    {
        $request->validate([
            'calon_id' => 'required|exists:calons,id',
        ]);

        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        if ($siswa->hasVotedOsis()) {
            return redirect()->route('osis.voting')
                ->with('error', 'Anda sudah memilih dalam pemilihan OSIS ini.');
        }

        // Get active election
        $election = OsisElection::active()->first();
        if (!$election) {
            return redirect()->route('osis.index')
                ->with('error', 'Tidak ada pemilihan OSIS yang sedang berlangsung.');
        }

        $calon = Calon::findOrFail($request->calon_id);

        // Create vote record
        Voting::create([
            'calon_id' => $calon->id,
            'pemilih_id' => null, // We'll use student ID instead
            'siswa_id' => $siswa->id,
            'election_id' => $election->id,
            'voted_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_valid' => true,
        ]);

        // Mark student as voted
        $siswa->markAsVoted($request->ip(), $request->userAgent());

        return redirect()->route('osis.results')
            ->with('success', 'Terima kasih! Suara Anda telah tercatat.');
    }

    /**
     * Display voting results.
     */
    public function results()
    {
        $calons = Calon::active()->ordered()->withCount('votings')->get();
        $totalVotes = Voting::valid()->count();
        $totalPemilih = Pemilih::active()->count();
        $votingPercentage = $totalPemilih > 0 ? round(($totalVotes / $totalPemilih) * 100, 2) : 0;

        return view('osis.results', compact('calons', 'totalVotes', 'totalPemilih', 'votingPercentage'));
    }

    /**
     * Display voting analytics.
     */
    public function analytics()
    {
        $stats = [
            'total_calon' => Calon::active()->count(),
            'total_pemilih' => Pemilih::active()->count(),
            'total_votes' => Voting::valid()->count(),
            'voting_percentage' => $this->getVotingPercentage(),
        ];

        $calons = Calon::active()->ordered()->withCount('votings')->get();
        $recentVotes = Voting::with(['calon', 'pemilih'])
            ->valid()
            ->latest()
            ->limit(10)
            ->get();

        return view('osis.analytics', compact('stats', 'calons', 'recentVotes'));
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
     * Get voting percentage.
     */
    private function getVotingPercentage(): float
    {
        $totalPemilih = Pemilih::active()->count();
        $totalVotes = Voting::valid()->count();

        if ($totalPemilih === 0) {
            return 0;
        }

        return round(($totalVotes / $totalPemilih) * 100, 2);
    }
}
