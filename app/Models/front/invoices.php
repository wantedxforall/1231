<?php

namespace App\Models\front;

use App\Models\User;
use App\Models\front\stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(stores::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public const STATUSES = [
        0 => 'Unpaid',
        1 => 'Paid',
        2 => 'Canceld',
    ];

    public const STATUSES_CLASSES = [
        'warning',
        'success',
        'danger',
    ];

}
