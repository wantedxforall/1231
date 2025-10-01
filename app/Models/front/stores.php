<?php

namespace App\Models\front;

use App\Models\User;
use App\Models\StoreProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class stores extends Model
{
    use HasFactory;
// protected $table ='stores';
    protected $guarded = [];
    protected $appends = ['full_logo_url'];

    public function getFullLogoUrlAttribute()
    {
        return ($this->logo && !filter_var($this->logo, FILTER_VALIDATE_URL)) ? url('storage/'.$this->logo) : $this->logo;
    }

    public function plans()
    {
        return $this->belongsTo(plans::class, 'plan_id');
    }

    public function transactions()
    {
        return $this->hasMany(transactions::class, 'store_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCreator()
    {
        return auth()->user()->id === $this->user_id;
    }

    public function invoices()
    {
        return $this->hasMany(invoices::class);
    }

    public function providers()
    {
        return $this->hasMany(StoreProvider::class, 'store_id');
    }

    public const STATUSES = [
        0 => 'Pending',
        1 => 'Active',
        2 => 'Canceld',
        3 => 'Terminated',
    ];

    public const STATUSES_CLASSES = [
        'warning',
        'success',
        'danger',
        'dark',
    ];

}
