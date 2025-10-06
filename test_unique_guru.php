<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimpleGuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        echo "DEBUG: Processing - NIP: " . ($row['nip'] ?? 'N/A') . ", Nama: " . ($row['nama_lengkap'] ?? 'N/A') . "\n";

        // Check if guru already exists
        $existing = Guru::where('nip', $row['nip'])->first();
        if ($existing) {
            echo "DEBUG: Skipping duplicate NIP: " . $row['nip'] . " (existing: " . $existing->nama_lengkap . ")\n";
            return null;
        }

        echo "DEBUG: Creating guru with NIP: " . $row['nip'] . "\n";

        $guru = new Guru([
            'nip' => $row['nip'],
            'nama_lengkap' => $row['nama_lengkap'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tanggal_lahir' => now()->subYears(25),
            'tempat_lahir' => 'Tidak Diketahui',
            'alamat' => 'Alamat belum diisi',
            'status_kepegawaian' => 'PNS',
            'tanggal_masuk' => now(),
            'pendidikan_terakhir' => 'S1',
            'universitas' => 'Universitas',
            'tahun_lulus' => '2000',
            'mata_pelajaran' => ['Matematika'],
        ]);

        $saved = $guru->save();
        if ($saved) {
            echo "DEBUG: Guru saved successfully with ID: " . $guru->id . "\n";
        } else {
            echo "DEBUG: Failed to save guru\n";
        }

        return $guru;
    }
}

echo "Testing unique Guru import...\n";

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$headers = ['nip', 'nama_lengkap', 'jenis_kelamin'];
foreach ($headers as $col => $header) {
    $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
}

// Set test data with truly unique NIP
$uniqueNip = '999999999999999999';
$testData = [$uniqueNip, 'Unique Test Guru', 'P'];
foreach ($testData as $col => $value) {
    $sheet->setCellValueByColumnAndRow($col + 1, 2, $value);
}

// Save file
$writer = new Xlsx($spreadsheet);
$fileName = 'test_unique_guru.xlsx';
$writer->save($fileName);

echo "✅ Excel file created: $fileName\n";

// Test import
try {
    $import = new SimpleGuruImport();
    Excel::import($import, $fileName);
    echo "✅ Import completed!\n";

    // Check database
    $guru = Guru::where('nip', $uniqueNip)->first();
    if ($guru) {
        echo "✅ Data found in database: " . $guru->nama_lengkap . "\n";
        echo "Total guru in database: " . Guru::count() . "\n";
    } else {
        echo "❌ Data not found in database\n";
        echo "Total guru in database: " . Guru::count() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

// Clean up
if (file_exists($fileName)) {
    unlink($fileName);
    echo "🧹 Test file cleaned up\n";
}
