<?php

namespace App\Imports;

use App\Models\Kelulusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class KelulusanImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Kelulusan([
            'nama' => $row['nama'],
            'nisn' => $row['nisn'],
            'nis' => $row['nis'] ?? null,
            'jurusan' => $row['jurusan'] ?? null,
            'tahun_ajaran' => $row['tahun_ajaran'],
            'status' => $row['status'],
            'tempat_kuliah' => $row['tempat_kuliah'] ?? null,
            'tempat_kerja' => $row['tempat_kerja'] ?? null,
            'jurusan_kuliah' => $row['jurusan_kuliah'] ?? null,
            'jabatan_kerja' => $row['jabatan_kerja'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'no_wa' => $row['no_wa'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'prestasi' => $row['prestasi'] ?? null,
            'catatan' => $row['catatan'] ?? null,
            'tanggal_lulus' => $row['tanggal_lulus'] ?? null,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.nama' => 'required|string|max:255',
            '*.nisn' => 'required|string|unique:kelulusans,nisn',
            '*.nis' => 'nullable|string|unique:kelulusans,nis',
            '*.tahun_ajaran' => 'required|integer|min:2000|max:' . date('Y'),
            '*.status' => 'required|in:lulus,tidak_lulus,mengulang',
        ];
    }
}
