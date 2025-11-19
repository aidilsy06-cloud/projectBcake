<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Kolom yang boleh di-mass assign
    protected $fillable = [
        'user_id',
        'store_id',
        'category_slug',
        'name',
        'slug',
        'price',
        'stock',
        'image_url',
        'description',
    ];

    /**
     * Relasi ke model Store (setiap produk dimiliki oleh satu toko)
     */
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }

    /**
     * Relasi ke User (seller pemilik produk)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
