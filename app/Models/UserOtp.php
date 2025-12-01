<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    protected $table = 'user_otps';

    // kolom yang boleh di-mass assign
    protected $fillable = [
        'user_id',
        'otp_code',
        'expired_at',
    ];

    // kita tidak pakai created_at & updated_at
    public $timestamps = false;

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
