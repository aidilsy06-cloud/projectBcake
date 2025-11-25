<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Kolom yang boleh di-mass assign
    protected $fillable = [
        'user_id',
        'store_id',
        'category_id',
        'name',
        'slug',
        'price',
        'stock',
        'image_url',
        'description',
        'status',       // ⬅️ tambahkan ini
    ];

    /**
     * Produk hanya yang sudah disetujui admin
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
