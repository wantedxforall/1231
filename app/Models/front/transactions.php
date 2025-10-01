<?php

namespace App\Models\front;

use App\Models\Providers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class transactions extends Model
{
    use HasFactory;
    protected $table = "transaction";
    protected $guarded = [];

    public function stores()
    {
        return $this->belongsTo(stores::class,'store_id');
    }

    public function providers()
    {
        return $this->belongsTo(Providers::class , 'provider_id');
    }

    public const STATUSES = [
        'Pending',
        'Approved',
        'Canceld',
        'Completed',
        'Fail',

    ];

    public const STATUSES_CLASSES = [
        'warning',
        'success',
        'danger',
        'success',
        'danger',
    ];

}
