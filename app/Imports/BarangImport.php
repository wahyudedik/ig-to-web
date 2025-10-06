<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\KategoriSarpras;
use App\Models\Ruang;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class BarangImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    protected $rowCount = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if barang already exists by kode_barang
        $existing = Barang::where('kode_barang', $row['kode_barang'])->first();

        if ($existing) {
            Log::info("Skipping duplicate kode_barang: {$row['kode_barang']} for {$row['nama']}");
            return null;
        }

        // Find kategori by name
        $kategoriId = null;
        if (!empty($row['kategori'])) {
            $kategori = KategoriSarpras::where('nama', trim($row['kategori']))->first();
            if ($kategori) {
                $kategoriId = $kategori->id;
            } else {
                Log::warning("Kategori not found: {$row['kategori']} - will be imported without kategori");
            }
        }

        // Find ruang by name
        $ruangId = null;
        if (!empty($row['ruang'])) {
            $ruang = Ruang::where('nama', trim($row['ruang']))->first();
            if ($ruang) {
                $ruangId = $ruang->id;
            } else {
                Log::warning("Ruang not found: {$row['ruang']} - will be imported without ruang");
            }
        }

        // Parse tanggal_pembelian
        $tanggalPembelian = null;
        if (!empty($row['tanggal_pembelian'])) {
            try {
                $tanggalPembelian = \Carbon\Carbon::parse($row['tanggal_pembelian']);
            } catch (\Exception $e) {
                Log::warning("Invalid date format for tanggal_pembelian: {$row['tanggal_pembelian']}");
            }
        }

        // Generate barcode and QR code if not provided
        $barcode = !empty($row['barcode']) ? trim($row['barcode']) : 'BAR-' . str_pad($this->rowCount + 1, 6, '0', STR_PAD_LEFT);
        $qrCode = !empty($row['qr_code']) ? trim($row['qr_code']) : 'QR-' . str_pad($this->rowCount + 1, 6, '0', STR_PAD_LEFT);

        $this->rowCount++;

        return new Barang([
            'nama' => trim($row['nama']),
            'kode_barang' => trim($row['kode_barang']),
            'kategori_id' => $kategoriId,
            'ruang_id' => $ruangId,
            'jumlah' => !empty($row['jumlah']) ? (int)$row['jumlah'] : 1,
            'kondisi' => !empty($row['kondisi']) ? trim($row['kondisi']) : 'baik',
            'status' => !empty($row['status']) ? trim($row['status']) : 'aktif',
            'harga' => !empty($row['harga']) ? (float)$row['harga'] : 0,
            'tanggal_pembelian' => $tanggalPembelian,
            'supplier' => !empty($row['supplier']) ? trim($row['supplier']) : null,
            'deskripsi' => !empty($row['deskripsi']) ? trim($row['deskripsi']) : null,
            'barcode' => $barcode,
            'qr_code' => $qrCode,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.nama' => 'required|string|max:255',
            '*.kode_barang' => 'required|string|max:50',
            '*.jumlah' => 'nullable|integer|min:1',
            '*.kondisi' => 'nullable|in:baik,rusak_ringan,rusak_berat,hilang',
            '*.status' => 'nullable|in:aktif,tidak_aktif,maintenance',
            '*.kategori' => 'nullable|string|max:255',
            '*.ruang' => 'nullable|string|max:255',
            '*.harga' => 'nullable|numeric|min:0',
            '*.tanggal_pembelian' => 'nullable|date',
            '*.supplier' => 'nullable|string|max:255',
            '*.deskripsi' => 'nullable|string',
            '*.barcode' => 'nullable|string|max:255',
            '*.qr_code' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the number of rows imported
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
