# 🎨 SweetAlert2 Usage Guide

Dokumentasi lengkap penggunaan SweetAlert2 di project IG-to-Web.

## 📦 Installation

SweetAlert2 sudah terinstall dan dikonfigurasi di project. Assets sudah ter-compile dan siap digunakan.

## 🚀 Quick Start

### Basic Usage

SweetAlert2 tersedia secara global melalui helper functions yang sudah didefinisikan di `resources/js/app.js`:

```javascript
// Success alert
showSuccess('Berhasil!', 'Data berhasil disimpan');

// Error alert
showError('Error!', 'Terjadi kesalahan saat menyimpan data');

// General alert
showAlert('Informasi', 'Ini adalah pesan informasi', 'info');

// Confirmation dialog
showConfirm('Konfirmasi', 'Apakah Anda yakin?', 'Ya', 'Batal').then((result) => {
    if (result.isConfirmed) {
        // User clicked "Ya"
        console.log('Confirmed');
    }
});

// Loading dialog
showLoading('Memproses...', 'Mohon tunggu sebentar');
// ... do something
closeLoading();
```

## 📚 Available Helper Functions

### 1. `showSuccess(title, text)`

Menampilkan alert sukses dengan auto-close setelah 3 detik.

```javascript
showSuccess('Berhasil!', 'Data berhasil disimpan');
```

**Parameters:**
- `title` (string): Judul alert
- `text` (string, optional): Pesan detail

**Features:**
- ✅ Auto-close setelah 3 detik
- ✅ Progress bar timer
- ✅ Warna hijau (success)

### 2. `showError(title, text)`

Menampilkan alert error.

```javascript
showError('Error!', 'Terjadi kesalahan saat menyimpan data');
```

**Parameters:**
- `title` (string): Judul alert
- `text` (string, optional): Pesan detail

**Features:**
- ❌ Manual close (tidak auto-close)
- ❌ Warna merah (error)

### 3. `showAlert(title, text, icon)`

Alert general purpose dengan icon kustom.

```javascript
showAlert('Informasi', 'Ini adalah pesan penting', 'info');
showAlert('Peringatan', 'Harap perhatikan!', 'warning');
showAlert('Berhasil', 'Operasi selesai', 'success');
```

**Parameters:**
- `title` (string): Judul alert
- `text` (string): Pesan detail
- `icon` (string): Icon type ('success', 'error', 'warning', 'info', 'question')

### 4. `showConfirm(title, text, confirmText, cancelText)`

Dialog konfirmasi dengan 2 tombol.

```javascript
showConfirm(
    'Hapus Data?',
    'Apakah Anda yakin ingin menghapus data ini?',
    'Ya, Hapus',
    'Batal'
).then((result) => {
    if (result.isConfirmed) {
        // User clicked "Ya, Hapus"
        deleteData();
    } else {
        // User clicked "Batal" or closed dialog
        console.log('Cancelled');
    }
});
```

**Parameters:**
- `title` (string): Judul dialog
- `text` (string): Pesan konfirmasi
- `confirmText` (string, default: 'Ya'): Text tombol konfirmasi
- `cancelText` (string, default: 'Batal'): Text tombol cancel

**Returns:**
- Promise yang resolve dengan object `{ isConfirmed: boolean }`

### 5. `showLoading(title, text)`

Menampilkan dialog loading. Harus di-close manual dengan `closeLoading()`.

```javascript
showLoading('Memproses...', 'Mohon tunggu sebentar');

// Lakukan operasi async
fetch('/api/data')
    .then(response => response.json())
    .then(data => {
        closeLoading();
        showSuccess('Berhasil!', 'Data berhasil dimuat');
    })
    .catch(error => {
        closeLoading();
        showError('Error!', 'Gagal memuat data');
    });
```

**Parameters:**
- `title` (string, default: 'Memproses...'): Judul loading
- `text` (string, default: 'Mohon tunggu'): Pesan loading

**Features:**
- ⏳ Spinner animation
- 🔒 Tidak bisa di-close manual (no outside click, no escape key)
- 🔒 Harus di-close dengan `closeLoading()`

### 6. `closeLoading()`

Menutup dialog loading yang sedang aktif.

```javascript
closeLoading();
```

## 🎯 Common Use Cases

### 1. Form Submission dengan Loading dan Success

```javascript
document.getElementById('myForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    showLoading('Menyimpan...', 'Mohon tunggu sebentar');
    
    fetch('/api/save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        closeLoading();
        if (data.success) {
            showSuccess('Berhasil!', 'Data berhasil disimpan').then(() => {
                window.location.href = '/success-page';
            });
        } else {
            showError('Error!', data.message);
        }
    })
    .catch(error => {
        closeLoading();
        showError('Error!', 'Terjadi kesalahan sistem');
    });
});
```

### 2. Delete Confirmation dengan Loading

```javascript
function deleteItem(id) {
    showConfirm(
        'Hapus Data?',
        'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
        'Ya, Hapus',
        'Batal'
    ).then((result) => {
        if (result.isConfirmed) {
            showLoading('Menghapus...', 'Mohon tunggu sebentar');
            
            fetch(`/api/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                closeLoading();
                if (data.success) {
                    showSuccess('Berhasil!', 'Data berhasil dihapus').then(() => {
                        location.reload();
                    });
                } else {
                    showError('Error!', data.message);
                }
            })
            .catch(error => {
                closeLoading();
                showError('Error!', 'Gagal menghapus data');
            });
        }
    });
}
```

### 3. Validation dengan Error Alert

```javascript
function validateForm() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    
    if (!name) {
        showError('Error!', 'Nama harus diisi');
        return false;
    }
    
    if (!email) {
        showError('Error!', 'Email harus diisi');
        return false;
    }
    
    if (!isValidEmail(email)) {
        showError('Error!', 'Format email tidak valid');
        return false;
    }
    
    return true;
}
```

## 🔄 Automatic Handling

Project ini sudah dilengkapi dengan automatic handlers untuk:

### 1. Forms dengan `data-confirm` attribute

```html
<form action="/delete/123" method="POST" data-confirm="Apakah Anda yakin ingin menghapus data ini?">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

Form ini akan otomatis menampilkan SweetAlert confirm dialog sebelum submit.

### 2. Elements dengan `onclick` yang mengandung `confirm()`

```html
<!-- BEFORE (akan otomatis diconvert) -->
<button onclick="if(confirm('Yakin hapus?')) deleteItem()">Hapus</button>

<!-- Akan otomatis menggunakan SweetAlert -->
```

Semua element dengan onclick yang mengandung `confirm()` akan otomatis diconvert ke SweetAlert.

## 🎨 Customization

Jika ingin menggunakan SweetAlert dengan konfigurasi custom:

```javascript
Swal.fire({
    title: 'Custom Alert',
    text: 'Ini adalah alert dengan konfigurasi custom',
    icon: 'info',
    confirmButtonText: 'OK',
    confirmButtonColor: '#3b82f6',
    showCloseButton: true,
    showCancelButton: true,
    cancelButtonText: 'Close',
    backdrop: true,
    allowOutsideClick: false,
    // ... dan banyak opsi lainnya
});
```

Dokumentasi lengkap SweetAlert2: https://sweetalert2.github.io/

## ✅ Best Practices

### DO ✅

```javascript
// 1. Gunakan helper functions untuk consistency
showSuccess('Berhasil!', 'Data disimpan');

// 2. Selalu handle promise result di showConfirm
showConfirm('Hapus?', 'Yakin hapus?').then((result) => {
    if (result.isConfirmed) {
        // Do something
    }
});

// 3. Tutup loading sebelum tampilkan alert lain
closeLoading();
showSuccess('Selesai!', 'Operasi berhasil');

// 4. Gunakan pesan yang jelas dan informatif
showError('Gagal Menyimpan', 'Email sudah terdaftar, silakan gunakan email lain');
```

### DON'T ❌

```javascript
// 1. Jangan gunakan native alert()
alert('Pesan'); // ❌

// 2. Jangan lupa close loading
showLoading();
// ... operasi selesai
// Lupa closeLoading() // ❌

// 3. Jangan gunakan pesan yang ambigu
showError('Error!', 'Error'); // ❌
```

## 📱 Mobile Responsive

SweetAlert2 sudah responsive dan akan menyesuaikan dengan ukuran layar device.

## 🎭 Icons Available

- `success` - ✅ Green checkmark
- `error` - ❌ Red X
- `warning` - ⚠️ Yellow warning
- `info` - ℹ️ Blue information
- `question` - ❓ Question mark

## 🔧 Troubleshooting

### Alert tidak muncul?

1. Pastikan assets sudah di-compile:
   ```bash
   npm run build
   ```

2. Clear browser cache
3. Periksa console untuk error

### Style tidak sesuai?

1. Pastikan `resources/css/app.css` sudah import SweetAlert2 CSS
2. Compile ulang assets: `npm run build`

### Automatic handler tidak bekerja?

1. Pastikan element ada di DOM saat page load
2. Untuk dynamic content, inisialisasi manual:
   ```javascript
   document.querySelectorAll('form[data-confirm]').forEach(form => {
       // ... handler code
   });
   ```

## 📝 Changelog

### v1.0.0 (Current)
- ✅ Initial SweetAlert2 installation
- ✅ Helper functions (showSuccess, showError, showConfirm, showLoading)
- ✅ Automatic handlers for forms and onclick
- ✅ Updated all admin views
- ✅ Custom styling to match project theme

---

**Note:** SweetAlert2 sudah diterapkan di seluruh project. Semua native `alert()` dan `confirm()` sudah digantikan dengan SweetAlert2.

Untuk pertanyaan atau issue, silakan kontak development team.

