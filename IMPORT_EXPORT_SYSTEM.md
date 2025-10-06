# Sistem Import/Export Lengkap

## 🎯 **Overview**
Sistem import/export telah diterapkan untuk semua modul utama dalam aplikasi sekolah:
- ✅ User Management
- ✅ Guru
- ✅ Siswa  
- ✅ OSIS (Calon)
- ✅ E-Lulus
- ✅ Sarpras (Barang)

---

## 📋 **1. User Management Import/Export**

### **Export Class**: `app/Exports/UserExport.php`
### **Import Class**: `app/Imports/UserImport.php`
### **Controller**: `SuperadminController`

#### **Routes**:
- `GET /superadmin/users/import` - Form import
- `GET /superadmin/users/import/template` - Download template
- `POST /superadmin/users/import` - Process import
- `GET /superadmin/users/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| name | ✅ | Nama lengkap user |
| email | ✅ | Email unik |
| user_type | ✅ | superadmin/admin/guru/siswa/sarpras |
| password | ❌ | Password (default: password123) |
| email_verified_at | ❌ | Tanggal verifikasi email |
| is_verified_by_admin | ❌ | yes/no |

#### **Features**:
- ✅ Auto-create user accounts
- ✅ Duplicate email detection
- ✅ Password hashing
- ✅ Role-based validation

---

## 👨‍🏫 **2. Guru Import/Export**

### **Export Class**: `app/Exports/GuruExport.php`
### **Import Class**: `app/Imports/GuruImport.php`
### **Controller**: `GuruController`

#### **Routes**:
- `GET /guru/import` - Form import
- `GET /guru/import/template` - Download template
- `POST /guru/import` - Process import
- `GET /guru/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| nip | ✅ | Nomor Induk Pegawai |
| nama_lengkap | ✅ | Nama lengkap guru |
| jenis_kelamin | ✅ | L/P |
| tanggal_lahir | ✅ | YYYY-MM-DD |
| tempat_lahir | ✅ | Tempat lahir |
| alamat | ✅ | Alamat lengkap |
| status_kepegawaian | ✅ | PNS/CPNS/GTT/GTY/Honorer |
| tanggal_masuk | ✅ | YYYY-MM-DD |
| status_aktif | ✅ | aktif/tidak_aktif/pensiun/meninggal |
| pendidikan_terakhir | ✅ | Pendidikan terakhir |
| universitas | ✅ | Nama universitas |
| tahun_lulus | ✅ | Tahun lulus |
| mata_pelajaran | ✅ | Comma-separated subjects |
| email | ❌ | Email (auto-create user account) |

#### **Features**:
- ✅ Auto-create user accounts for guru
- ✅ Duplicate NIP detection
- ✅ Date parsing and validation
- ✅ Subject parsing (comma-separated)
- ✅ Photo upload support

---

## 👨‍🎓 **3. Siswa Import/Export**

### **Export Class**: `app/Exports/SiswaExport.php`
### **Import Class**: `app/Imports/SiswaImport.php`
### **Controller**: `SiswaController`

#### **Routes**:
- `GET /siswa/import` - Form import
- `GET /siswa/import/template` - Download template
- `POST /siswa/import` - Process import
- `GET /siswa/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| nis | ✅ | Nomor Induk Siswa |
| nisn | ✅ | Nomor Induk Siswa Nasional |
| nama_lengkap | ✅ | Nama lengkap siswa |
| jenis_kelamin | ✅ | L/P |
| tanggal_lahir | ✅ | YYYY-MM-DD |
| tempat_lahir | ✅ | Tempat lahir |
| alamat | ✅ | Alamat lengkap |
| tahun_masuk | ✅ | Tahun masuk sekolah |
| status | ✅ | aktif/lulus/pindah/keluar/meninggal |
| kelas | ❌ | Kelas saat ini |
| jurusan | ❌ | Jurusan |
| nama_ayah | ❌ | Nama ayah |
| pekerjaan_ayah | ❌ | Pekerjaan ayah |
| nama_ibu | ❌ | Nama ibu |
| pekerjaan_ibu | ❌ | Pekerjaan ibu |
| email | ❌ | Email (auto-create user account) |

#### **Features**:
- ✅ Auto-create user accounts for siswa
- ✅ Duplicate NIS detection
- ✅ Parent information tracking
- ✅ Academic records support
- ✅ Photo upload support

---

## 🗳️ **4. OSIS (Calon) Import/Export**

### **Export Class**: `app/Exports/CalonExport.php`
### **Import Class**: `app/Imports/CalonImport.php`
### **Controller**: `OSISController`

#### **Routes**:
- `GET /osis/calon/import` - Form import
- `GET /osis/calon/import/template` - Download template
- `POST /osis/calon/import` - Process import
- `GET /osis/calon/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| nama_ketua | ✅ | Nama calon ketua |
| nama_wakil | ❌ | Nama calon wakil |
| visi_misi | ✅ | Visi dan misi lengkap |
| jenis_pencalonan | ✅ | ketua/wakil/pasangan |
| status_aktif | ❌ | aktif/tidak_aktif |

#### **Features**:
- ✅ Duplicate candidate detection
- ✅ Vote counting integration
- ✅ Status management
- ✅ Election integration

---

## 🎓 **5. E-Lulus Import/Export**

### **Export Class**: `app/Exports/KelulusanExport.php` (existing)
### **Import Class**: `app/Imports/KelulusanImport.php` (improved)
### **Controller**: `KelulusanController`

#### **Routes**:
- `GET /lulus/import` - Form import
- `GET /lulus/import/template` - Download template
- `POST /lulus/import` - Process import
- `GET /lulus/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| nama | ✅ | Nama lengkap alumni |
| nisn | ✅ | Nomor Induk Siswa Nasional |
| nis | ❌ | Nomor Induk Siswa |
| jurusan | ❌ | Jurusan saat sekolah |
| tahun_ajaran | ✅ | Tahun ajaran |
| status | ✅ | lulus/tidak_lulus/mengulang |
| tempat_kuliah | ❌ | Tempat kuliah |
| tempat_kerja | ❌ | Tempat kerja |
| jurusan_kuliah | ❌ | Jurusan kuliah |
| jabatan_kerja | ❌ | Jabatan kerja |
| no_hp | ❌ | Nomor HP |
| no_wa | ❌ | Nomor WA |
| alamat | ❌ | Alamat |
| prestasi | ❌ | Prestasi |
| catatan | ❌ | Catatan |
| tanggal_lulus | ❌ | YYYY-MM-DD |

#### **Features**:
- ✅ Duplicate NISN detection
- ✅ Date parsing and validation
- ✅ Career tracking
- ✅ Certificate generation support

---

## 🏫 **6. Sarpras (Barang) Import/Export**

### **Export Class**: `app/Exports/BarangExport.php`
### **Import Class**: `app/Imports/BarangImport.php`
### **Controller**: `SarprasController`

#### **Routes**:
- `GET /sarpras/barang/import` - Form import
- `GET /sarpras/barang/import/template` - Download template
- `POST /sarpras/barang/import` - Process import
- `GET /sarpras/barang/export` - Export data

#### **Template Fields**:
| Field | Required | Description |
|-------|----------|-------------|
| nama | ✅ | Nama barang |
| kode_barang | ✅ | Kode unik barang |
| kategori | ❌ | Nama kategori |
| ruang | ❌ | Nama ruang |
| jumlah | ✅ | Jumlah barang |
| kondisi | ✅ | baik/rusak_ringan/rusak_berat/hilang |
| status | ✅ | aktif/tidak_aktif/maintenance |
| harga | ❌ | Harga pembelian |
| tanggal_pembelian | ❌ | YYYY-MM-DD |
| supplier | ❌ | Nama supplier |
| deskripsi | ❌ | Deskripsi barang |
| barcode | ❌ | Auto-generated if empty |
| qr_code | ❌ | Auto-generated if empty |

#### **Features**:
- ✅ Auto-generate barcode/QR code
- ✅ Category and room lookup
- ✅ Duplicate kode_barang detection
- ✅ Maintenance tracking support

---

## 🔧 **Technical Features**

### **Common Features All Modules**:
1. **✅ Template Download**: Sample data with proper formatting
2. **✅ Validation**: Comprehensive field validation
3. **✅ Error Handling**: Detailed error messages and logging
4. **✅ Duplicate Detection**: Skip existing records
5. **✅ Progress Tracking**: Row count and failure reporting
6. **✅ File Format Support**: .xlsx, .xls, .csv
7. **✅ File Size Limit**: 2MB maximum
8. **✅ Logging**: Complete audit trail
9. **✅ Filtered Export**: Export with filters applied
10. **✅ User Account Integration**: Auto-create user accounts where applicable

### **Error Handling**:
- ✅ Validation errors with specific field messages
- ✅ File format validation
- ✅ Database constraint handling
- ✅ Comprehensive logging to `storage/logs/laravel.log`
- ✅ User-friendly error messages

### **Security Features**:
- ✅ File type validation
- ✅ File size limits
- ✅ CSRF protection
- ✅ Authentication required
- ✅ Role-based access control
- ✅ Input sanitization

---

## 📊 **Usage Examples**

### **1. Import Users**:
```bash
# Download template
GET /superadmin/users/import/template

# Upload filled template
POST /superadmin/users/import
```

### **2. Export Guru with Filters**:
```bash
# Export all active PNS teachers
GET /guru/export?status=aktif&employment_status=PNS
```

### **3. Import Siswa Data**:
```bash
# Download template
GET /siswa/import/template

# Upload student data
POST /siswa/import
```

---

## 🎯 **Benefits**

### **For Administrators**:
- ✅ Bulk data management
- ✅ Easy data migration
- ✅ Consistent data format
- ✅ Reduced manual entry errors
- ✅ Comprehensive audit trail

### **For Users**:
- ✅ Self-service data export
- ✅ Filtered exports for specific needs
- ✅ Professional Excel formatting
- ✅ Template guidance for imports

### **For System**:
- ✅ Scalable data processing
- ✅ Robust error handling
- ✅ Performance optimized
- ✅ Maintainable code structure

---

## 🚀 **Ready for Production**

Semua sistem import/export telah:
- ✅ **Tested** - Manual testing completed
- ✅ **Validated** - Comprehensive validation rules
- ✅ **Secured** - Proper authentication and authorization
- ✅ **Logged** - Complete audit trail
- ✅ **Documented** - Clear usage instructions
- ✅ **Optimized** - Efficient data processing

**Status**: ✅ **PRODUCTION READY**

---

**Last Updated**: December 2024  
**Version**: 1.0  
**Compatibility**: Laravel 10+, PHP 8.1+
