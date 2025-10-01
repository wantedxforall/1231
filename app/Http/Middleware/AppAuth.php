<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\front\stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AppAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     $token = $request->header('authorization');
    //     $token = str_replace('Bearer ', '', $token);
    //     $store = stores::where('store_key', $token)->first();

    //     if (!$store || $token !== $store->store_key) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid token. Please check your token and try again.',
    //         ], 401);
    //     }
    //     $request->attributes->add(['store' => $store]);
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->store_key;
        if (empty($token)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token. Please check your token and try again.',
            ], 401);
        }

        $store = Redis::get('store_data:' . $token);

        if (!$store) {
            $store = stores::where('store_key', $token)->first();

            if (!$store) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid token. Please check your token and try again.',
                ], 401);
            }

            $storeData = $store->toArray();

            Redis::setex('store_data:' . $token, 600, json_encode($storeData));
        } else {
            $storeData = json_decode($store, true);
        }

        $storeData = (object) $storeData;

        $request->attributes->add(['store' => $storeData]);

        return $next($request);
    }
}
