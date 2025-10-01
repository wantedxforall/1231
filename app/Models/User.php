<?php

namespace App\Models;

use App\Models\Payments;
use App\Models\front\stores;
use Laravel\Sanctum\HasApiTokens;
use App\Models\front\transactions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'company',
        'phone',
        'site',
        'country',
        'time_zone',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stores()
    {
        return $this->hasMany(stores::class);
    }

    public function transactions()
    {
        return $this->hasMany(transactions::class);
    }

    public function invoices()
    {
        return $this->hasMany(invoices::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }



}
