<?php

use App\Models\Option;
use App\Models\front\stores;
use App\Models\front\invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


function options()
{
    $options = Cache::get('all_options');
    if (!$options) {
        $options = Option::all();

        $optionsArray = [];
        foreach ($options as $option) {
            $optionsArray[$option->key] = $option->value;
        }
        Cache::set('all_options', json_encode($optionsArray));
        $options = $optionsArray;
    } else {
        $options = json_decode($options, true);
    }

    return $options;
}

function paginate($id = '10')
{
    return $id;
}

function store_count()
{
    $cacheKey = 'store_count_user_' . Auth::id();

    $storeCount = Cache::get($cacheKey);

    if (!$storeCount) {
        $storeCount = stores::where('user_id', Auth::id())->count();
        Cache::put($cacheKey, $storeCount, now()->addMinutes(10));
    }

    return $storeCount;
}

function invoice_count()
{
    $cacheKey = 'invoice_count_user_' . Auth::id();
    $invoiceCount = Cache::get($cacheKey);

    if (!$invoiceCount) {
        $invoiceCount = invoices::where('user_id', Auth::id())->where('status', 0)->count();
        Cache::put($cacheKey, $invoiceCount, now()->addMinutes(10));
    }

    return $invoiceCount;
}
