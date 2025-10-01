<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUSES = [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'canceled' => 'Canceled',
    ];

    public const STATUSES_CLASSES = [
        'pending' => 'warning',
        'completed' => 'success',
        'canceled' => 'danger',
    ];

    public const TYPES = [
        'opay' => 'Opay',
    ];


}
