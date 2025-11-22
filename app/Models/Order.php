<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'store_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_amount',
        'status',
        'payment_method',
        'note',
        'admin_note',
    ];

    /* RELATIONSHIPS */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* HELPER STATUS LABEL */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'    => 'Menunggu Konfirmasi',
            'diproses'   => 'Sedang Diproses',
            'dikirim'    => 'Sedang Dikirim',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }
}
