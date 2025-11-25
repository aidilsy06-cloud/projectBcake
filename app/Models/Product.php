<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh di-mass assign
    protected $fillable = [
        'user_id',
        'store_id',
        'category_id',   // <- relasi ke tabel categories
        'name',
        'slug',
        'price',
        'stock',         // <- stok produk
        'image_url',     // atau image_path kalau di DB kamu pakai itu
        'description',
    ];

    /**
     * Relasi ke model Store (setiap produk dimiliki oleh satu toko)
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relasi ke User (seller pemilik produk)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Category (setiap produk punya satu kategori)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
