# Validasi Gender untuk Voting OSIS

## Overview
Sistem validasi gender untuk voting OSIS memastikan bahwa:
- **Siswa** hanya dapat memilih calon yang sesuai dengan jenis kelamin mereka
- **Guru/Admin** dapat memilih semua calon tanpa batasan gender

## Implementasi

### 1. Database Schema
- Menambahkan field `jenis_kelamin` (enum: L, P) ke tabel `pemilihs`
- Field `jenis_kelamin` sudah ada di tabel `calons`

### 2. Model Updates
**Pemilih Model:**
- Menambahkan `jenis_kelamin` ke `$fillable`
- Menambahkan `getGenderDisplayAttribute()` method
- Menambahkan `scopeByGender()` method

**Calon Model:**
- Sudah memiliki field `jenis_kelamin` dan method `scopeByGender()`

### 3. Controller Logic
**OSISController::voting():**
- Filter calon berdasarkan jenis kelamin siswa
- Siswa laki-laki hanya melihat calon laki-laki
- Siswa perempuan hanya melihat calon perempuan

**OSISController::processVote():**
- Validasi gender saat memproses vote
- Siswa hanya bisa memilih calon dengan gender yang sama
- Guru/Admin bisa memilih semua calon

**OSISController::teacherView():**
- Menampilkan semua calon tanpa filter gender
- Khusus untuk guru/admin/superadmin

### 4. View Updates
**Voting View:**
- Menampilkan pesan informasi tentang filter gender
- "Anda melihat calon Laki-laki/Perempuan"

**Teacher View:**
- Menampilkan semua calon tanpa filter
- Pesan informasi bahwa guru dapat melihat semua calon

**Forms:**
- Menambahkan field jenis kelamin di form create/edit pemilih
- Validasi required untuk jenis kelamin

### 5. Import/Export
**Template Import:**
- Menambahkan kolom `jenis_kelamin` di template Excel
- Sample data dengan jenis kelamin yang bervariasi

**Export:**
- Include jenis kelamin dalam export data

## Validasi Rules

### Untuk Siswa:
1. Hanya dapat melihat calon dengan jenis kelamin yang sama
2. Hanya dapat memilih calon dengan jenis kelamin yang sama
3. Jika jenis kelamin tidak sesuai, akan muncul error message

### Untuk Guru/Admin:
1. Dapat melihat semua calon (teacher view)
2. Dapat memilih calon dengan jenis kelamin apapun
3. Tidak ada batasan gender dalam voting

## Error Messages
- "Anda hanya dapat memilih calon yang sesuai dengan jenis kelamin Anda."
- "Hanya guru dan admin yang dapat mengakses halaman ini."

## Database Migration
```php
// Migration: add_gender_to_pemilihs_table.php
$table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('kelas');
```

## Testing
1. Login sebagai siswa laki-laki → hanya melihat calon laki-laki
2. Login sebagai siswa perempuan → hanya melihat calon perempuan  
3. Login sebagai guru → melihat semua calon di teacher view
4. Test voting dengan gender yang tidak sesuai → error message
5. Test voting dengan gender yang sesuai → berhasil

## Files Modified
- `database/migrations/2025_10_05_111708_add_gender_to_pemilihs_table.php`
- `app/Models/Pemilih.php`
- `app/Http/Controllers/OSISController.php`
- `resources/views/osis/pemilih/create.blade.php`
- `resources/views/osis/pemilih/edit.blade.php`
- `resources/views/osis/voting.blade.php`
- `resources/views/osis/teacher-view.blade.php`
- `resources/views/dashboards/guru.blade.php`

## Status: ✅ COMPLETED
Semua fitur validasi gender untuk voting OSIS telah berhasil diimplementasikan dan siap digunakan.
