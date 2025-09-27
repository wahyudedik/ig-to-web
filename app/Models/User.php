<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Get the module access for the user.
     */
    public function moduleAccess(): HasMany
    {
        return $this->hasMany(ModuleAccess::class);
    }

    /**
     * Get the audit logs for the user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Check if user has specific permission using Spatie.
     */
    public function hasPermission(string $permission): bool
    {
        // Superadmin bypass all permissions
        if ($this->user_type === 'superadmin') {
            return true;
        }

        return $this->hasPermissionTo($permission);
    }

    /**
     * Check if user has module access.
     */
    public function hasModuleAccess(string $module): bool
    {
        // Superadmin bypass all module access
        if ($this->user_type === 'superadmin') {
            return true;
        }

        return $this->moduleAccess()
            ->where('module_name', $module)
            ->where('can_access', true)
            ->exists();
    }

    /**
     * Check if user can perform specific action on module.
     */
    public function canPerform(string $action, string $module): bool
    {
        // Superadmin bypass all actions
        if ($this->user_type === 'superadmin') {
            return true;
        }

        // Check Spatie permission first
        $permission = "{$module}.{$action}";
        if ($this->hasPermissionTo($permission)) {
            return true;
        }

        // Fallback to module access system
        return $this->moduleAccess()
            ->where('module_name', $module)
            ->where('can_access', true)
            ->where("can_{$action}", true)
            ->exists();
    }

    /**
     * Check if user is superadmin.
     */
    public function isSuperadmin(): bool
    {
        return $this->user_type === 'superadmin';
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is guru.
     */
    public function isGuru(): bool
    {
        return $this->user_type === 'guru';
    }

    /**
     * Check if user is siswa.
     */
    public function isSiswa(): bool
    {
        return $this->user_type === 'siswa';
    }

    /**
     * Check if user is sarpras.
     */
    public function isSarpras(): bool
    {
        return $this->user_type === 'sarpras';
    }

    /**
     * Get user's accessible modules.
     */
    public function getAccessibleModules(): array
    {
        if ($this->isSuperadmin()) {
            return ['instagram', 'pages', 'guru', 'siswa', 'osis', 'lulus', 'sarpras', 'users'];
        }

        return $this->moduleAccess()
            ->where('can_access', true)
            ->pluck('module_name')
            ->toArray();
    }
}
