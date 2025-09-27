<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemilih extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'kelas',
        'status',
        'waktu_memilih',
        'ip_address',
        'user_agent',
        'is_active',
    ];

    protected $casts = [
        'waktu_memilih' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the votings for the pemilih.
     */
    public function votings(): HasMany
    {
        return $this->hasMany(Voting::class);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by class.
     */
    public function scopeKelas($query, string $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Scope to filter active pemilih.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter who haven't voted.
     */
    public function scopeBelumMemilih($query)
    {
        return $query->where('status', 'belum_memilih');
    }

    /**
     * Scope to filter who have voted.
     */
    public function scopeSudahMemilih($query)
    {
        return $query->where('status', 'sudah_memilih');
    }

    /**
     * Check if pemilih has voted.
     */
    public function hasVoted(): bool
    {
        return $this->status === 'sudah_memilih';
    }

    /**
     * Mark as voted.
     */
    public function markAsVoted(?string $ipAddress = null, ?string $userAgent = null): void
    {
        $this->update([
            'status' => 'sudah_memilih',
            'waktu_memilih' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'sudah_memilih' => 'green',
            'belum_memilih' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status display.
     */
    public function getStatusDisplayAttribute(): string
    {
        return match ($this->status) {
            'sudah_memilih' => 'Sudah Memilih',
            'belum_memilih' => 'Belum Memilih',
            default => 'Unknown'
        };
    }

    /**
     * Get voting time formatted.
     */
    public function getVotingTimeFormattedAttribute(): ?string
    {
        return $this->waktu_memilih ? $this->waktu_memilih->format('d/m/Y H:i') : null;
    }
}
