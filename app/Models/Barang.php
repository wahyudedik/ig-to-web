<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'kategori_id',
        'merk',
        'model',
        'serial_number',
        'harga_beli',
        'tanggal_pembelian',
        'sumber_dana',
        'kondisi',
        'lokasi',
        'ruang_id',
        'status',
        'catatan',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'harga_beli' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the kategori that owns the barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSarpras::class, 'kategori_id');
    }

    /**
     * Get the ruang that owns the barang.
     */
    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }

    /**
     * Get the maintenance records for the barang.
     */
    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'item_id')->where('jenis_item', 'barang');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($barang) {
            // Delete photo when barang is deleted
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
        });
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by condition.
     */
    public function scopeKondisi($query, string $kondisi)
    {
        return $query->where('kondisi', $kondisi);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeKategori($query, int $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * Scope to filter by room.
     */
    public function scopeRuang($query, int $ruangId)
    {
        return $query->where('ruang_id', $ruangId);
    }

    /**
     * Scope to filter active barang.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get photo URL.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        return null;
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'tersedia' => 'green',
            'dipinjam' => 'blue',
            'rusak' => 'red',
            'hilang' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get condition badge color.
     */
    public function getKondisiBadgeColorAttribute(): string
    {
        return match ($this->kondisi) {
            'baik' => 'green',
            'rusak' => 'red',
            'hilang' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->harga_beli) {
            return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
        }
        return 'Tidak ada data';
    }

    /**
     * Get age in years.
     */
    public function getAgeAttribute(): int
    {
        if ($this->tanggal_pembelian) {
            return $this->tanggal_pembelian->diffInYears(now());
        }
        return 0;
    }
}
