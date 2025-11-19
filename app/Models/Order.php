<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'order_summary',
        'note',
        'status',
        'wa_sent_at',
        'total_price',  // <— penting untuk chart omzet!
    ];

    protected $casts = [
        'wa_sent_at' => 'datetime',
        'total_price' => 'integer',
    ];

    // Relasi ke User (pembuat order / seller)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Relasi ke Store (toko pemilik order)
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }
}
