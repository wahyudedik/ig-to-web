<?php

namespace App\Http\Controllers;

use App\Models\Kelulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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

        return redirect()->route('admin.lulus.index')
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

        return redirect()->route('admin.lulus.index')
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

        return redirect()->route('admin.lulus.index')
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
     * Download template Excel for import.
     */
    public function downloadTemplate()
    {
        // Create sample data for template
        $sampleData = [
            [
                'nama' => 'Ahmad Rizki',
                'nisn' => '1234567890',
                'nis' => '2024001',
                'jurusan' => 'IPA (Ilmu Pengetahuan Alam)',
                'tahun_ajaran' => '2024',
                'status' => 'lulus',
                'tempat_kuliah' => 'Universitas Indonesia',
                'tempat_kerja' => '',
                'jurusan_kuliah' => 'Teknik Informatika',
                'jabatan_kerja' => '',
                'no_hp' => '08123456789',
                'no_wa' => '08123456789',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
                'prestasi' => 'Juara 1 Olimpiade Matematika',
                'catatan' => 'Siswa berprestasi',
                'tanggal_lulus' => '2024-06-15'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'nisn' => '0987654321',
                'nis' => '2024002',
                'jurusan' => 'IPS (Ilmu Pengetahuan Sosial)',
                'tahun_ajaran' => '2024',
                'status' => 'lulus',
                'tempat_kuliah' => '',
                'tempat_kerja' => 'PT Contoh',
                'jurusan_kuliah' => '',
                'jabatan_kerja' => 'Staff Admin',
                'no_hp' => '08987654321',
                'no_wa' => '08987654321',
                'alamat' => 'Jl. Contoh No. 456, Bandung',
                'prestasi' => 'Juara 2 Lomba Debat',
                'catatan' => 'Siswa aktif',
                'tanggal_lulus' => '2024-06-15'
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
                    'nisn',
                    'nis',
                    'jurusan',
                    'tahun_ajaran',
                    'status',
                    'tempat_kuliah',
                    'tempat_kerja',
                    'jurusan_kuliah',
                    'jabatan_kerja',
                    'no_hp',
                    'no_wa',
                    'alamat',
                    'prestasi',
                    'catatan',
                    'tanggal_lulus',
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
                    'C' => 15,
                    'D' => 20,
                    'E' => 15,
                    'F' => 15,
                    'G' => 25,
                    'H' => 25,
                    'I' => 20,
                    'J' => 20,
                    'K' => 15,
                    'L' => 15,
                    'M' => 30,
                    'N' => 20,
                    'O' => 30,
                    'P' => 15,
                ];
            }
        };

        return Excel::download($templateExport, 'template-import-kelulusan.xlsx');
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
            // Get file info for logging
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            Log::info("Starting import process", [
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'user_id' => Auth::id()
            ]);

            // Create import instance
            $import = new KelulusanImport();

            // Import the file
            Excel::import($import, $file);

            // Get import results
            $importedCount = $import->getRowCount() ?? 0;
            $errors = $import->errors();
            $failures = $import->failures();

            Log::info("Import completed", [
                'imported_count' => $importedCount,
                'errors_count' => count($errors),
                'failures_count' => count($failures)
            ]);

            // Prepare success message with details
            $message = "Data kelulusan berhasil diimpor!";
            $details = [];

            if ($importedCount > 0) {
                $details[] = "Berhasil mengimpor {$importedCount} data";
            }

            if (count($failures) > 0) {
                $details[] = count($failures) . " data gagal diimpor (cek log untuk detail)";
            }

            if (count($errors) > 0) {
                $details[] = count($errors) . " data memiliki error validasi";
            }

            if (!empty($details)) {
                $message .= " (" . implode(', ', $details) . ")";
            }

            return redirect()->route('admin.lulus.index')
                ->with('success', $message);
        } catch (\Maatwebsite\Excel\Exceptions\SheetNotFoundException $e) {
            Log::error("Sheet not found in Excel file", ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'File Excel tidak memiliki sheet yang valid. Pastikan file Excel memiliki data di sheet pertama.');
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            Log::error("File type not detected", ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Format file tidak dikenali. Pastikan file dalam format Excel (.xlsx, .xls) atau CSV (.csv).');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Validation failed during import", [
                'errors' => $e->errors(),
                'file_name' => $request->file('file')->getClientOriginalName()
            ]);

            $errorMessages = [];
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages[] = $message;
                }
            }

            return redirect()->back()
                ->with('error', 'Validasi gagal: ' . implode(', ', array_slice($errorMessages, 0, 3)) . (count($errorMessages) > 3 ? '...' : ''));
        } catch (\Exception $e) {
            Log::error("Import failed", [
                'error' => $e->getMessage(),
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
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

        $query = Kelulusan::with('siswa');

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

        // Check if student is eligible (only grade 12 or graduated)
        if (!$kelulusan->isEligibleForCheck()) {
            $kelas = $kelulusan->siswa?->kelas ?? 'Tidak diketahui';
            return redirect()->back()
                ->with('error', "Maaf, fitur E-Lulus hanya untuk siswa kelas XII atau alumni. Kelas Anda: {$kelas}");
        }

        // Record the check attempt
        $kelulusan->recordCheck($request->ip(), $request->userAgent());

        return view('lulus.result', compact('kelulusan'));
    }

    /**
     * Generate certificate.
     */
    public function generateCertificate(Kelulusan $kelulusan)
    {
        try {
            // Generate PDF using DomPDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('lulus.certificate', compact('kelulusan'));

            // Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // Generate filename
            $filename = 'Sertifikat_Kelulusan_' . $kelulusan->nama . '_' . $kelulusan->tahun_ajaran . '.pdf';

            // Return PDF download
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat sertifikat: ' . $e->getMessage());
        }
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
