# 🔐 ROLE & PERMISSION SYSTEM GUIDE

## 📋 **Overview**

Sistem Role & Permission yang fleksibel seperti Accurate - hanya superadmin yang bisa akses dashboard dan mengelola user dengan role dinamis.

---

## 🎯 **Konsep Sistem**

### **🔑 Superadmin Only Access**
- **Hanya superadmin** yang bisa akses dashboard dan menu System
- **User lain** tidak bisa akses dashboard kecuali diundang dengan role tertentu
- **Role dibuat dinamis** - tidak ada role tetap (admin, guru, siswa, sarpras)

### **🎨 Dynamic Role Creation**
- **78 permissions** yang lengkap dan terorganisir per module
- **Custom role** bisa dibuat sesuai kebutuhan
- **Permission granular** untuk setiap role

---

## 🚀 **Cara Penggunaan**

### **1. Login sebagai Superadmin**
```
Email: superadmin@sekolah.com
Password: password
```

### **2. Akses Menu System**
- Klik menu **"System"** di navigation
- Pilih **"User Management"** atau **"Role & Permissions"**

### **3. Buat Role Baru**
1. Buka **"Role & Permissions"**
2. Klik **"Create New Role"**
3. Masukkan nama role (contoh: "Admin Baru", "Staff Sarpras", "Viewer")
4. Assign permissions sesuai kebutuhan
5. Klik **"Create Role"**

### **4. Invite User Baru**
1. Buka **"User Management"**
2. Klik **"Invite User"**
3. Masukkan:
   - **Full Name**: Nama lengkap user
   - **Email Address**: Email user
   - **Role**: Pilih role yang sudah dibuat
   - **Send invitation email**: Centang jika ingin kirim email
4. Klik **"Invite User"**
5. Sistem akan generate temporary password

### **5. Kelola User**
- **Edit User**: Klik icon edit untuk mengubah data user
- **Toggle Status**: Klik icon toggle untuk aktif/nonaktif user
- **Delete User**: Klik icon delete untuk hapus user
- **Search**: Gunakan search box untuk mencari user

---

## 📊 **Permission System**

### **Module Permissions**
```
users.view, users.create, users.edit, users.delete, users.export, users.import
guru.view, guru.create, guru.edit, guru.delete, guru.export, guru.import
siswa.view, siswa.create, siswa.edit, siswa.delete, siswa.export, siswa.import
osis.view, osis.create, osis.edit, osis.delete, osis.vote, osis.results
sarpras.view, sarpras.create, sarpras.edit, sarpras.delete, sarpras.barcode, sarpras.maintenance
pages.view, pages.create, pages.edit, pages.delete, pages.publish
instagram.view, instagram.manage
system.analytics, system.health, system.notifications
roles.view, roles.create, roles.edit, roles.delete
permissions.view, permissions.create, permissions.edit, permissions.delete
```

### **Action Permissions**
- **view**: Melihat data
- **create**: Menambah data baru
- **edit**: Mengedit data
- **delete**: Menghapus data
- **export**: Export data ke Excel
- **import**: Import data dari Excel
- **manage**: Kelola penuh (untuk fitur khusus)

---

## 🎯 **Contoh Skenario**

### **Skenario 1: Admin Baru**
```
Role: "Admin Baru"
Permissions:
- users.view, users.create, users.edit
- guru.view, guru.create, guru.edit
- siswa.view, siswa.create, siswa.edit
- osis.view, osis.results
- pages.view, pages.create, pages.edit
- sarpras.view
```
**Hasil**: User bisa mengelola data tapi tidak bisa delete atau akses fitur advanced

### **Skenario 2: Staff Sarpras**
```
Role: "Staff Sarpras"
Permissions:
- sarpras.view, sarpras.create, sarpras.edit, sarpras.delete
- sarpras.barcode, sarpras.maintenance
- pages.view
```
**Hasil**: User hanya bisa akses modul Sarpras dan barcode system

### **Skenario 3: Viewer**
```
Role: "Viewer"
Permissions:
- users.view
- guru.view
- siswa.view
- osis.view
- pages.view
- sarpras.view
```
**Hasil**: User hanya bisa melihat data, tidak bisa edit atau delete

### **Skenario 4: OSIS Manager**
```
Role: "OSIS Manager"
Permissions:
- osis.view, osis.create, osis.edit, osis.delete
- osis.vote, osis.results
- users.view
- pages.view
```
**Hasil**: User bisa mengelola sistem OSIS sepenuhnya

---

## 🔗 **Akses Fitur**

### **URLs Penting**
- **User Management**: `/admin/user-management`
- **Role & Permissions**: `/admin/role-permissions`
- **Analytics Dashboard**: `/admin/analytics`
- **System Health**: `/admin/system/health`
- **Notification Center**: `/admin/notifications`

### **Navigation Menu**
- **System** → **User Management**: Kelola user dan assign role
- **System** → **Role & Permissions**: Buat dan kelola role
- **System** → **Analytics Dashboard**: Lihat statistik sistem
- **System** → **System Health**: Monitor kesehatan sistem
- **System** → **Notification Center**: Kelola notifikasi

---

## 🛡️ **Security Features**

### **Superadmin Protection**
- **Superadmin role** tidak bisa dihapus
- **Superadmin user** tidak bisa dihapus atau dinonaktifkan
- **Hanya superadmin** yang bisa akses menu System

### **Role Protection**
- **Role yang memiliki user** tidak bisa dihapus
- **Permission validation** di setiap aksi
- **Audit logging** untuk semua perubahan

### **User Protection**
- **Email unique** - tidak bisa ada email duplikat
- **Password hashing** - password di-hash dengan bcrypt
- **Session management** - session aman dengan database driver

---

## 📈 **Best Practices**

### **1. Role Naming**
- Gunakan nama yang jelas: "Admin Baru", "Staff Sarpras", "Viewer"
- Hindari nama generik: "admin", "user", "staff"
- Gunakan format: "Module + Level" (contoh: "Sarpras Manager")

### **2. Permission Assignment**
- **Principle of Least Privilege**: Berikan permission minimal yang diperlukan
- **Module-based**: Group permissions berdasarkan module
- **Action-based**: Pisahkan view, create, edit, delete

### **3. User Management**
- **Invite dengan email** untuk user baru
- **Assign role** yang sesuai dengan job description
- **Toggle status** untuk nonaktifkan user sementara
- **Delete user** hanya jika benar-benar tidak diperlukan

### **4. Testing**
- **Test role** setelah dibuat
- **Test permission** dengan user yang berbeda
- **Test navigation** untuk memastikan menu sesuai role

---

## 🚨 **Troubleshooting**

### **Problem: User tidak bisa akses menu**
**Solution**: 
1. Pastikan user sudah di-assign role
2. Pastikan role memiliki permission yang diperlukan
3. Clear cache: `php artisan cache:clear`

### **Problem: Role tidak bisa dihapus**
**Solution**: 
1. Pastikan role tidak memiliki user yang assigned
2. Unassign semua user dari role tersebut
3. Baru hapus role

### **Problem: Permission tidak berfungsi**
**Solution**: 
1. Pastikan permission sudah di-assign ke role
2. Pastikan user memiliki role yang benar
3. Clear cache: `php artisan config:clear`

### **Problem: Menu System tidak muncul**
**Solution**: 
1. Pastikan user adalah superadmin
2. Check role assignment: `php artisan tinker`
3. Clear cache: `php artisan route:clear`

---

## 📚 **Commands Berguna**

### **Artisan Commands**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Fix user roles
php artisan fix:user-roles

# Seed permissions
php artisan db:seed --class=PermissionSeeder

# Check routes
php artisan route:list --name=admin
```

### **Tinker Commands**
```php
// Check user roles
$user = User::find(1);
$user->roles;
$user->permissions;

// Check role permissions
$role = Role::find(1);
$role->permissions;

// Assign role to user
$user->assignRole('admin');

// Give permission to role
$role->givePermissionTo('users.view');
```

---

## 🎉 **Kesimpulan**

Sistem Role & Permission ini memberikan:
- **Fleksibilitas** - Role dibuat dinamis sesuai kebutuhan
- **Keamanan** - Hanya superadmin yang bisa akses dashboard
- **Kontrol** - Permission granular untuk setiap aksi
- **Kemudahan** - Interface yang user-friendly
- **Skalabilitas** - Mudah ditambah role dan permission baru

**Sistem siap digunakan untuk production!** 🚀

---

*Dokumentasi ini akan terus diupdate sesuai perkembangan sistem.*
