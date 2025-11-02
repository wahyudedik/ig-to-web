# User Type vs Spatie Permission Roles - Synchronization

## 📋 Overview

Aplikasi ini menggunakan **2 sistem** untuk menentukan role user:

1. **`user_type` (Column di `users` table)** - Legacy system, ENUM column
   - Values: `'superadmin'`, `'admin'`, `'guru'`, `'siswa'`, `'sarpras'`
   - Digunakan untuk backward compatibility dan quick access
   
2. **Spatie Permission Roles (Many-to-Many)** - Modern system
   - Stored di `roles` table dan `model_has_roles` pivot table
   - Support custom roles (dinamis)
   - Full permission management

---

## ⚠️ Masalah yang Bisa Terjadi

Jika `user_type` dan Spatie roles **tidak sinkron**, bisa terjadi:
- User dengan role `superadmin` tapi `user_type` = `guru`
- User dengan `user_type` = `admin` tapi tidak punya role `admin`
- Inconsistent permission checks
- Navigation menu tidak muncul/muncul salah

---

## ✅ Solusi yang Diimplementasikan

### 1. **UserObserver** (`app/Observers/UserObserver.php`)
- Auto-sync `user_type` dengan primary role (first role)
- Triggered setelah user disave
- Menggunakan `updateQuietly()` untuk avoid infinite loop

### 2. **Manual Sync di Controllers**
Setiap kali assign/remove role, juga sync `user_type`:

- **`RoleManagementController@syncUsers()`**: Sync setelah assign users ke role
- **`UserManagementController@updateUser()`**: Sync setelah update role
- **`UserManagementController@inviteUser()`**: Sync setelah assign role
- **`UserManagementController@createUser()`**: Sync setelah assign role
- **`RolePermissionController@assignRoleToUser()`**: Sync setelah assign role
- **`RolePermissionController@removeRoleFromUser()`**: Sync setelah remove role

### 3. **Sync Logic**
```php
// Primary role = first role in user's roles collection
$primaryRole = $user->roles->first();

if ($primaryRole && $user->user_type !== $primaryRole->name) {
    $user->updateQuietly(['user_type' => $primaryRole->name]);
} elseif (!$primaryRole) {
    // If user has no roles, set default
    $user->updateQuietly(['user_type' => 'siswa']); // Default fallback
}
```

---

## 🔄 When Sync Happens

### Automatic (via UserObserver):
- ✅ User saved (after role assignment via Spatie methods)
- ✅ User updated (after role changes)

### Manual (in Controllers):
- ✅ `syncUsers()` - Bulk assign users to role
- ✅ `updateUser()` - Update user role
- ✅ `inviteUser()` - Create user with role
- ✅ `createUser()` - Create user with role
- ✅ `assignRoleToUser()` - Assign single role
- ✅ `removeRoleFromUser()` - Remove single role

---

## 📝 Best Practices

### ✅ DO:
1. **Always use Spatie Permission** for role assignment (`assignRole()`, `syncRoles()`)
2. **Let sync happen automatically** - UserObserver handles it
3. **Use `hasRole()`, `hasAnyRole()`** from Spatie for permission checks
4. **Check both** if needed: `$user->hasRole('admin')` OR `$user->user_type === 'admin'`

### ❌ DON'T:
1. **Don't manually update `user_type`** without updating Spatie roles
2. **Don't use `user_type` alone** for permission checks (always check Spatie roles)
3. **Don't hardcode role names** - use `RoleHelper` functions

---

## 🔍 Migration Strategy (Future)

Jika ingin **deprecate `user_type`** di masa depan:

1. **Phase 1**: Keep both, ensure sync (CURRENT STATE)
2. **Phase 2**: Update all code to use Spatie roles only
3. **Phase 3**: Remove `user_type` column from database

**Current Status**: Phase 1 - Both systems coexist, auto-synced

---

## 🎯 Priority: Spatie Roles

**Source of Truth**: **Spatie Permission Roles**
- `user_type` is **derived** from primary role
- `user_type` is for **backward compatibility** and **quick access**
- **All new code** should use Spatie roles

---

## ⚙️ Configuration

`user_type` column:
- **Type**: ENUM
- **Values**: `'superadmin'`, `'admin'`, `'guru'`, `'siswa'`, `'sarpras'`
- **Default**: `'siswa'`
- **Purpose**: Legacy support, quick filtering, backward compatibility

Spatie Roles:
- **Flexible**: Support custom roles
- **Dynamic**: Can add/remove roles
- **Full Featured**: Permission management
- **Source of Truth**: Primary system

---

## 🐛 Troubleshooting

### Issue: `user_type` tidak update setelah assign role
**Solution**: Pastikan `UserObserver` terdaftar di `AppServiceProvider`

### Issue: Infinite loop saat update user
**Solution**: Gunakan `updateQuietly()` untuk sync (avoid firing events)

### Issue: User tidak punya role tapi punya `user_type`
**Solution**: UserObserver akan set default `'siswa'` jika tidak ada roles

### Issue: Custom role tidak sync dengan `user_type`
**Solution**: 
- Custom roles bisa punya `user_type` yang berbeda
- `user_type` hanya sync dengan primary role (first role)
- Jika custom role adalah primary, `user_type` akan diupdate

---

## 📊 Example Flow

1. **Assign Role**:
   ```php
   $user->assignRole($role); // Spatie
   // → UserObserver triggered
   // → $user->user_type = $role->name (auto-synced)
   ```

2. **Sync Roles**:
   ```php
   $user->syncRoles([$role1, $role2]); // Spatie
   // → UserObserver triggered
   // → $user->user_type = $role1->name (first role)
   ```

3. **Remove Role**:
   ```php
   $user->removeRole($role); // Spatie
   // → UserObserver triggered
   // → $user->user_type = next role atau 'siswa' default
   ```

---

## ✅ Verification

Test dengan:
```php
// 1. Assign role
$user->assignRole('admin');
// Check: $user->user_type === 'admin' ✅

// 2. Sync roles
$user->syncRoles(['guru']);
// Check: $user->user_type === 'guru' ✅

// 3. Remove all roles
$user->syncRoles([]);
// Check: $user->user_type === 'siswa' ✅ (default)
```

