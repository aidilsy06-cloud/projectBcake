<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // table yg dipakai
    protected $table = 'categories';

    // kolom yang boleh diisi massal
    protected $fillable = [
        'store_id',
        'name',
        'slug',
    ];

    /* ===========================
     | 🔗 RELASI
     |=========================== */

    // 1 kategori dimiliki oleh 1 toko
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // 1 kategori bisa punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
