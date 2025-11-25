<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Kolom yang boleh di-mass assign lewat Order::create()
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
        'total_price',
    ];

    // Cast kolom tanggal
    protected $casts = [
        'wa_sent_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relasi ke item pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
