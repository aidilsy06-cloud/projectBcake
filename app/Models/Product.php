<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'stock',
        'image_url',
        'description',
        'store_id', // tambahkan jika produk terhubung ke toko
    ];

    /**
     * Relasi ke model Store (setiap produk dimiliki oleh satu toko)
     */
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }
}
