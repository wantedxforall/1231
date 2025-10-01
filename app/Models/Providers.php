<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Providers extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['full_icon_url'];

    public function getFullIconUrlAttribute()
    {
        return ($this->icon && !filter_var($this->icon, FILTER_VALIDATE_URL)) ? url('storage/'.$this->icon) : $this->icon;
    }

}
