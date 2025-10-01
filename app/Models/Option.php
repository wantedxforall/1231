<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const TABS = [
        0 => 'General',
        1 => 'Plan',
        3 => 'Social',
        4 => 'Email',
        5 => 'Oauth & Login',
        6 => 'Google reCaptcha',
        7 => 'Whatsapp',
        8 => 'Payment',
        9 => 'Rate Sync',
        10 => 'Others',
    ];

    public const ENCRYPTION = [
        0 => 'None',
        1 => 'TSL',
        2 => 'SSL',
    ];

}
