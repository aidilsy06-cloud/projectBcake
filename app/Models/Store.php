<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'tagline',
        'description',
        'logo',
        'banner',
    ];

    // otomatis ikut saat toArray()/toJson(); di Blade bisa akses langsung $store->logo_url dst.
    protected $appends = ['logo_url', 'banner_url'];

    /**
     * Relasi: toko dimiliki oleh satu user (penjual)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: satu toko punya banyak produk (foreign key: products.store_id)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    /**
     * Route model binding pakai kolom 'slug'
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Accessor: URL lengkap untuk logo
     */
    public function getLogoUrlAttribute(): string
    {
        if (!empty($this->logo)) {
            return asset('storage/'.$this->logo);
        }
        // siapkan file public/images/default-store.png
        return asset('images/default-store.png');
    }

    /**
     * Accessor: URL lengkap untuk banner
     */
    public function getBannerUrlAttribute(): string
    {
        if (!empty($this->banner)) {
            return asset('storage/'.$this->banner);
        }
        // siapkan file public/images/placeholder/banner.jpg
        return asset('images/placeholder/banner.jpg');
    }

    /**
     * Mutator: slug disimpan dalam format rapi (kecil, strip)
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Scope: pencarian sederhana (name, slug, tagline)
     */
    public function scopeSearch($q, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') return $q;

        return $q->where(function ($s) use ($term) {
            $s->where('name', 'like', "%{$term}%")
              ->orWhere('slug', 'like', "%{$term}%")
              ->orWhere('tagline', 'like', "%{$term}%");
        });
    }
}
