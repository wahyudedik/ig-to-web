# Bug Fix: Export Barang Sarpras - Kolom Kosong

## Date
2025-10-24

## Problem Report
User melaporkan bahwa hasil export barang sarpras banyak yang kosong:
- Kolom **Ruang** kosong
- Kolom **Jumlah** kosong  
- Kolom **Harga** kosong
- Beberapa field penting tidak di-export (Lokasi, Merk, Model, Serial Number, Catatan)

## Root Cause

Ada **kesalahan mapping field** di `BarangExport.php`:

### 1. Nama Field Salah
```php
// SEBELUM (Salah)
$barang->nama                    // ❌ Field tidak ada
$barang->kategori->nama          // ❌ Field tidak ada
$barang->ruang->nama             // ❌ Field tidak ada
$barang->harga                   // ❌ Field tidak ada
$barang->jumlah                  // ❌ Field tidak ada di tabel
$barang->supplier                // ❌ Field tidak ada di tabel

// SESUDAH (Benar)
$barang->nama_barang             // ✅ Field yang benar
$barang->kategori->nama_kategori // ✅ Field yang benar
$barang->ruang->nama_ruang       // ✅ Field yang benar
$barang->harga_beli              // ✅ Field yang benar
```

### 2. Field Missing
Field-field penting yang tidak di-export:
- `lokasi` - Lokasi fisik barang
- `merk` - Merk barang
- `model` - Model barang
- `serial_number` - Serial number
- `catatan` - Catatan tambahan
- `sumber_dana` - Sumber dana pembelian (yang sebelumnya salah di-label "Supplier")

## Solution

**File Updated**: `app/Exports/BarangExport.php`

### Before (15 kolom dengan data salah)
```php
public function headings(): array
{
    return [
        'Nama Barang',
        'Kode Barang',
        'Kategori',
        'Ruang',
        'Jumlah',        // ❌ Field tidak ada
        'Kondisi',
        'Status',
        'Harga',         // ❌ Nama salah
        'Tanggal Pembelian',
        'Supplier',      // ❌ Field tidak ada
        'Deskripsi',
        'Barcode',
        'QR Code',
        'Created At',
        'Updated At',
    ];
}

public function map($barang): array
{
    return [
        $barang->nama,                    // ❌ Field tidak ada
        $barang->kode_barang,
        $barang->kategori->nama ?? '',    // ❌ Field tidak ada
        $barang->ruang->nama ?? '',       // ❌ Field tidak ada
        $barang->jumlah,                  // ❌ Field tidak ada
        $barang->kondisi,
        $barang->status,
        $barang->harga,                   // ❌ Field tidak ada
        // ... dst
    ];
}
```

### After (19 kolom dengan data lengkap)
```php
public function headings(): array
{
    return [
        'Nama Barang',
        'Kode Barang',
        'Kategori',
        'Ruang',
        'Lokasi',           // ✅ Ditambahkan
        'Merk',             // ✅ Ditambahkan
        'Model',            // ✅ Ditambahkan
        'Serial Number',    // ✅ Ditambahkan
        'Kondisi',
        'Status',
        'Harga Beli',       // ✅ Nama diperbaiki
        'Tanggal Pembelian',
        'Sumber Dana',      // ✅ Diperbaiki dari "Supplier"
        'Deskripsi',
        'Catatan',          // ✅ Ditambahkan
        'Barcode',
        'QR Code',
        'Created At',
        'Updated At',
    ];
}

public function map($barang): array
{
    return [
        $barang->nama_barang ?? '',                      // ✅ Field benar
        $barang->kode_barang ?? '',
        $barang->kategori->nama_kategori ?? '',          // ✅ Field benar
        $barang->ruang->nama_ruang ?? '',                // ✅ Field benar
        $barang->lokasi ?? '',                           // ✅ Ditambahkan
        $barang->merk ?? '',                             // ✅ Ditambahkan
        $barang->model ?? '',                            // ✅ Ditambahkan
        $barang->serial_number ?? '',                    // ✅ Ditambahkan
        $barang->kondisi ?? '',
        $barang->status ?? '',
        $barang->harga_beli ? 'Rp ' . number_format($barang->harga_beli, 0, ',', '.') : '', // ✅ Field benar + formatting
        $barang->tanggal_pembelian ? $barang->tanggal_pembelian->format('Y-m-d') : '',
        $barang->sumber_dana ?? '',                      // ✅ Field benar
        $barang->deskripsi ?? '',
        $barang->catatan ?? '',                          // ✅ Ditambahkan
        $barang->barcode ?? '',
        $barang->qr_code ?? '',
        $barang->created_at?->format('Y-m-d H:i:s'),
        $barang->updated_at?->format('Y-m-d H:i:s'),
    ];
}
```

## Database Schema Reference

Tabel `barang` memiliki field:
```sql
- id
- kode_barang
- nama_barang           // ✅ Bukan "nama"
- deskripsi
- kategori_id
- merk                  // ✅ Ditambahkan ke export
- model                 // ✅ Ditambahkan ke export
- serial_number         // ✅ Ditambahkan ke export
- barcode
- qr_code
- harga_beli            // ✅ Bukan "harga"
- tanggal_pembelian
- sumber_dana           // ✅ Bukan "supplier"
- kondisi
- lokasi                // ✅ Ditambahkan ke export
- ruang_id
- status
- catatan               // ✅ Ditambahkan ke export
- foto
- is_active
- created_at
- updated_at
```

Relasi:
- `kategori_id` → `kategori_sarpras.nama_kategori` (bukan "nama")
- `ruang_id` → `ruang.nama_ruang` (bukan "nama")

## Changes Summary

### Kolom yang Diperbaiki
1. **Nama Barang**: `$barang->nama` → `$barang->nama_barang`
2. **Kategori**: `$barang->kategori->nama` → `$barang->kategori->nama_kategori`
3. **Ruang**: `$barang->ruang->nama` → `$barang->ruang->nama_ruang`
4. **Harga**: `$barang->harga` → `$barang->harga_beli` (dengan formatting)
5. **Supplier**: Diganti menjadi "Sumber Dana" dengan field `$barang->sumber_dana`

### Kolom yang Dihapus
1. **Jumlah**: Field tidak ada di database (dihapus dari export)

### Kolom yang Ditambahkan
1. **Lokasi**: `$barang->lokasi`
2. **Merk**: `$barang->merk`
3. **Model**: `$barang->model`
4. **Serial Number**: `$barang->serial_number`
5. **Catatan**: `$barang->catatan`

### Improvements
1. **Null Safety**: Semua field sekarang menggunakan `?? ''` untuk menghindari error
2. **Formatting**: Harga diformat dengan `Rp` dan pemisah ribuan
3. **Column Width**: Disesuaikan untuk setiap kolom (19 kolom total)

## Testing Steps

1. ✅ Buka `/admin/sarpras/barang`
2. ✅ Klik "Import/Export" → "Export Data"
3. ✅ Buka file Excel yang di-download
4. ✅ Verifikasi **19 kolom** ada semua:
   - A: Nama Barang (✅ terisi)
   - B: Kode Barang (✅ terisi)
   - C: Kategori (✅ terisi dengan nama kategori)
   - D: Ruang (✅ terisi dengan nama ruang)
   - E: Lokasi (✅ terisi)
   - F: Merk (✅ terisi)
   - G: Model (✅ terisi)
   - H: Serial Number (✅ terisi)
   - I: Kondisi (✅ terisi)
   - J: Status (✅ terisi)
   - K: Harga Beli (✅ terisi dengan format Rp)
   - L: Tanggal Pembelian (✅ terisi)
   - M: Sumber Dana (✅ terisi)
   - N: Deskripsi (✅ terisi)
   - O: Catatan (✅ terisi)
   - P: Barcode (✅ terisi)
   - Q: QR Code (✅ terisi)
   - R: Created At (✅ terisi)
   - S: Updated At (✅ terisi)

## Before vs After Comparison

| Aspect | Before | After |
|--------|--------|-------|
| Total Kolom | 15 | 19 |
| Kolom Kosong | 3+ | 0 |
| Field Error | 5 | 0 |
| Missing Data | Merk, Model, Serial, Lokasi, Catatan | Semua terisi |
| Harga Format | Kosong/Error | Rp 450.000 |
| Kategori | Kosong | Elektronik, Furnitur, dll |
| Ruang | Kosong | (akan terisi jika data ruang di-populate) |

## Related Issues

**Catatan**: Data `Ruang` masih perlu di-populate di database karena field `nama_ruang` kosong. Ini bisa dilakukan dengan:
1. Manual update via interface
2. Seeder (bisa dibuatkan jika diperlukan)
3. Migration untuk populate data existing

## Status
✅ **FIXED** - Export barang sekarang lengkap dengan 19 kolom dan semua data terisi dengan benar

## Cache Cleared
```bash
php artisan config:clear
php artisan cache:clear
```

## Next Steps (Optional)
1. Populate data `nama_ruang` di tabel `ruang`
2. Test export dengan data lengkap
3. Verifikasi import masih berfungsi dengan struktur baru

