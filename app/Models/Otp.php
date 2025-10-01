<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otp extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'code',
        'expire_at',
    ];

    protected $casts = [
        'expire_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'phone', 'phone');
    }
}
