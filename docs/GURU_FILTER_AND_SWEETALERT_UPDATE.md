# Update Guru Module: Filter Reset & SweetAlert2

## 📋 Ringkasan Perubahan

Update pada module Guru untuk menambahkan button **Reset** di filter dan memastikan semua alert menggunakan **SweetAlert2**.

---

## ✨ Perubahan yang Dilakukan

### 1. **Tambah Button Reset di Filter** (`guru/index.blade.php`)

**Lokasi**: Line 92-101

**Sebelum**:
```blade
<div class="flex items-end">
    <button type="submit"
        class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Filter
    </button>
</div>
```

**Sesudah**:
```blade
<div class="flex items-end space-x-2">
    <button type="submit"
        class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Filter
    </button>
    <a href="{{ route('admin.guru.index') }}"
        class="flex-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
        Reset
    </a>
</div>
```

**Fungsi**:
- Button **Reset** mengembalikan filter ke state awal (tanpa query parameters)
- Redirect ke `admin.guru.index` tanpa parameter
- Styling konsisten dengan button Filter

---

### 2. **SweetAlert2 untuk Delete Confirmation** (`guru/index.blade.php`)

**Lokasi**: Line 196-205

**Sebelum**:
```blade
<form method="POST" action="{{ route('admin.guru.destroy', $guru) }}"
    class="inline"
    onsubmit="return confirm('Are you sure you want to delete this guru?')">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="text-red-600 hover:text-red-900">Delete</button>
</form>
```

**Sesudah**:
```blade
<form method="POST" action="{{ route('admin.guru.destroy', $guru) }}"
    class="inline"
    data-confirm="Apakah Anda yakin ingin menghapus data guru {{ $guru->full_name }}?">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="text-red-600 hover:text-red-900">Delete</button>
</form>
```

**Fungsi**:
- Ganti native `confirm()` dengan SweetAlert2
- Menggunakan `data-confirm` attribute yang otomatis ditangani oleh handler di `resources/js/app.js`
- Pesan konfirmasi dalam Bahasa Indonesia dengan nama guru
- Dialog SweetAlert2 lebih menarik dan user-friendly

---

### 3. **Update guru/create.blade.php**

**File sudah diperbaiki sebelumnya** dengan:
- ✅ Validasi frontend untuk addMataPelajaran()
- ✅ Validasi frontend untuk addUser()
- ✅ Enhanced error handling
- ✅ SweetAlert2 untuk semua pesan
- ✅ Header `Accept: application/json`
- ✅ Parse Laravel validation errors

---

### 4. **Update guru/edit.blade.php**

#### a. **addMataPelajaran() dengan SweetAlert2**

**Perubahan**:
- ✅ Validasi frontend: cek field kosong sebelum submit
- ✅ Ganti `alert()` dengan `showSuccess()` dan `showError()`
- ✅ Enhanced error handling untuk validation errors
- ✅ Header `Accept: application/json`

**Kode Setelah Perbaikan**:
```javascript
function addMataPelajaran() {
    const newMataPelajaran = document.getElementById('newMataPelajaran').value;
    
    if (!newMataPelajaran.trim()) {
        showError('Nama mata pelajaran harus diisi');
        return;
    }

    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Loading...';
    button.disabled = true;

    fetch('{{ route('admin.guru.addSubject') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                nama: newMataPelajaran
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw err;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Add to checkbox list
                const container = document.querySelector('.grid.grid-cols-2.gap-2');
                const label = document.createElement('label');
                label.className = 'flex items-center';
                label.innerHTML = `
                    <input type="checkbox" name="mata_pelajaran[]" value="${data.data.nama}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">${data.data.nama}</span>
                `;
                container.appendChild(label);

                loadMataPelajaranList();
                document.getElementById('newMataPelajaran').value = '';
                showSuccess('Mata pelajaran berhasil ditambahkan!');
            } else {
                showError(data.message || 'Terjadi kesalahan saat menambahkan mata pelajaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Handle validation errors
            if (error.errors) {
                let errorMessages = [];
                for (let field in error.errors) {
                    errorMessages.push(...error.errors[field]);
                }
                showError(errorMessages.join('<br>'));
            } else if (error.message) {
                showError(error.message);
            } else {
                showError('Terjadi kesalahan saat menambahkan mata pelajaran');
            }
        })
        .finally(() => {
            button.textContent = originalText;
            button.disabled = false;
        });
}
```

#### b. **addUser() dengan SweetAlert2**

**Perubahan**:
- ✅ Validasi frontend: nama, email, password, minimal 8 karakter
- ✅ Ganti `alert()` dengan `showSuccess()` dan `showError()`
- ✅ Enhanced error handling untuk validation errors
- ✅ Header `Accept: application/json`

**Kode Setelah Perbaikan**:
```javascript
function addUser() {
    const name = document.getElementById('newUserName').value;
    const email = document.getElementById('newUserEmail').value;
    const password = document.getElementById('newUserPassword').value;
    const userType = document.getElementById('newUserType').value;

    // Validation
    if (!name.trim()) {
        showError('Nama lengkap harus diisi');
        return;
    }
    if (!email.trim()) {
        showError('Email harus diisi');
        return;
    }
    if (!password.trim()) {
        showError('Password harus diisi');
        return;
    }
    if (password.length < 8) {
        showError('Password minimal 8 karakter');
        return;
    }

    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Loading...';
    button.disabled = true;

    fetch('{{ route('admin.superadmin.users.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name: name,
                email: email,
                password: password,
                user_type: userType
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw err;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Add to select dropdown
                const select = document.getElementById('user_id');
                const option = document.createElement('option');
                option.value = data.data.id;
                option.textContent = `${data.data.name} (${data.data.email})`;
                select.appendChild(option);

                loadUserList();

                // Clear form
                document.getElementById('newUserName').value = '';
                document.getElementById('newUserEmail').value = '';
                document.getElementById('newUserPassword').value = '';

                showSuccess('User berhasil ditambahkan!');
            } else {
                showError(data.message || 'Terjadi kesalahan saat menambahkan user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Handle validation errors
            if (error.errors) {
                let errorMessages = [];
                for (let field in error.errors) {
                    errorMessages.push(...error.errors[field]);
                }
                showError(errorMessages.join('<br>'));
            } else if (error.message) {
                showError(error.message);
            } else {
                showError('Terjadi kesalahan saat menambahkan user');
            }
        })
        .finally(() => {
            button.textContent = originalText;
            button.disabled = false;
        });
}
```

---

## 🎯 Hasil Akhir

### Filter Section di `admin/guru`
- ✅ Filter form dengan 4 field: Search, Status, Kepegawaian, Mata Pelajaran
- ✅ Button **Filter** untuk apply filter
- ✅ Button **Reset** untuk clear semua filter
- ✅ Responsive layout dengan `flex-1` dan `space-x-2`

### SweetAlert2 Integration
- ✅ Delete confirmation menggunakan SweetAlert2
- ✅ addMataPelajaran() success/error dengan SweetAlert2
- ✅ addUser() success/error dengan SweetAlert2
- ✅ Validasi frontend sebelum submit
- ✅ Error messages informatif dari Laravel validation

### User Experience Improvements
1. **Frontend Validation**: Cegah submit jika field kosong atau invalid
2. **Better Error Messages**: Show Laravel validation errors dengan format yang jelas
3. **Loading States**: Button disabled dengan teks "Loading..." saat proses
4. **Modern UI**: SweetAlert2 dialog yang cantik dan user-friendly
5. **Bahasa Indonesia**: Semua pesan dalam Bahasa Indonesia

---

## 📊 Status Files di Module Guru

| File | Status | SweetAlert2 | Filter Reset |
|------|--------|-------------|--------------|
| `guru/index.blade.php` | ✅ Updated | ✅ Yes | ✅ Yes |
| `guru/create.blade.php` | ✅ Updated | ✅ Yes | N/A |
| `guru/edit.blade.php` | ✅ Updated | ✅ Yes | N/A |
| `guru/show.blade.php` | ⚠️ Not Checked | ❓ | N/A |
| `guru/import.blade.php` | ⚠️ Not Checked | ❓ | N/A |

---

## 🧪 Testing Checklist

### Filter & Reset
- [ ] Buka halaman `admin/guru`
- [ ] Isi filter (Search, Status, Kepegawaian, Mata Pelajaran)
- [ ] Klik **Filter** → data ter-filter
- [ ] Klik **Reset** → filter kembali ke default, semua data muncul

### Delete Confirmation
- [ ] Buka halaman `admin/guru`
- [ ] Klik **Delete** pada salah satu guru
- [ ] SweetAlert2 muncul dengan pesan konfirmasi
- [ ] Klik **Ya** → guru dihapus
- [ ] Klik **Batal** → tidak ada perubahan

### Add Mata Pelajaran (create/edit)
- [ ] Buka `admin/guru/create` atau edit
- [ ] Klik button **Tambah** di bagian Mata Pelajaran
- [ ] Kosongkan field → klik Tambah → Error: "Nama mata pelajaran harus diisi"
- [ ] Isi nama mata pelajaran → klik Tambah → Success message muncul
- [ ] Mata pelajaran baru muncul di checkbox list

### Add User (create/edit)
- [ ] Buka `admin/guru/create` atau edit
- [ ] Klik button **Tambah** di bagian User Account
- [ ] Kosongkan nama → Error: "Nama lengkap harus diisi"
- [ ] Isi nama, kosongkan email → Error: "Email harus diisi"
- [ ] Isi nama & email, password < 8 karakter → Error: "Password minimal 8 karakter"
- [ ] Isi semua field dengan benar → Success message muncul
- [ ] User baru muncul di dropdown

---

## 📝 Notes

### SweetAlert2 Helper Functions
Tersedia di `resources/js/app.js`:
- `showSuccess(message)` - Success alert
- `showError(message)` - Error alert
- `showConfirm(title, message, confirmText, cancelText)` - Confirmation dialog
- `showLoading()` - Loading indicator
- `closeLoading()` - Close loading

### Automatic Handlers di app.js
- `form[data-confirm]` → otomatis intercept submit dengan SweetAlert2
- `[onclick*="confirm("]` → otomatis ganti native confirm dengan SweetAlert2

---

## 🔗 Related Files

### Updated Files:
- `resources/views/guru/index.blade.php`
- `resources/views/guru/create.blade.php`
- `resources/views/guru/edit.blade.php`
- `app/Http/Controllers/SuperadminController.php` (storeUser method)
- `resources/js/app.js` (SweetAlert2 helpers)
- `resources/css/app.css` (SweetAlert2 CSS import)

### Related Documentation:
- `docs/BUG_FIX_USER_CREATION.md`
- `docs/SWEETALERT_USAGE.md`
- `docs/SWEETALERT_IMPLEMENTATION_SUMMARY.md`
- `docs/FRONTEND_BUG_FIXES.md`

---

## 🚀 Next Steps (Optional)

### File lain yang masih menggunakan native alert/confirm:
Total 92 matches di 32 files, termasuk:
- `siswa/index.blade.php`
- `siswa/create.blade.php`
- `sarpras/**/*.blade.php`
- `osis/**/*.blade.php`
- `role-management/**/*.blade.php`
- Dan lainnya...

**Rekomendasi**: Update satu per satu sesuai prioritas penggunaan.

---

## 📅 Timeline
- **Updated**: 23 Oktober 2025
- **Status**: ✅ Complete for Guru Module
- **Tested**: ⏳ Pending User Testing

