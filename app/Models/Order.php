<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh di-isi mass assignment (Order::create).
     */
    protected $fillable = [
        'user_id',          // buyer yang membuat pesanan
        'store_id',         // toko pemilik pesanan
        'customer_name',
        'customer_phone',
        'customer_address',
        'order_summary',
        'note',
        'status',
        'wa_sent_at',
        'total_price',      // dipakai untuk omzet / chart
    ];

    /**
     * Casting tipe data.
     */
    protected $casts = [
        'wa_sent_at'   => 'datetime',
        'total_price'  => 'integer',
    ];

    /**
     * Relasi ke user (pembeli).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke store (toko pemilik pesanan).
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
