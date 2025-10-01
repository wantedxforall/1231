<?php

namespace App\Helpers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\front\stores;
use App\Models\front\invoices;
use App\Models\front\transactions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Whatsapp
{
    public const MainUrl = 'https://wabot.blast-media.net/api/send/';

    public static $Data = [
        "type" => "text",
        "message" => "",
        "instance_id" => "",
        "access_token" => ""
    ];

    public static function Welcome($user)
    {
        $instance_id = \App\Models\Option::where('key', 'instance_id')->first();
        $access_token = \App\Models\Option::where('key', 'access_token')->first();
        $message = '🌟 Welcome to ' . $user->name . ' 🌟
        🎉 Thank you for registering a new account! 🎉
        🚀 We are thrilled to have you on board. Explore and enjoy our services! 🚀';

        self::$Data['number'] = $user->phone;
        self::$Data['message'] = $message;
        self::$Data['instance_id'] = $instance_id->value;
        self::$Data['access_token'] = $access_token->value;

        $response = Http::post(self::MainUrl, self::$Data);

        return $response->successful();
    }

    public static function Invoice($user,$invoice)
    {
        $instance_id = \App\Models\Option::where('key', 'instance_id')->first();
        $access_token = \App\Models\Option::where('key', 'access_token')->first();

        $store = stores::find($invoice->store_id);
        $url = route('front.invoices.show', $invoice->hash);

        $message = '🌟 Welcome to ' . $user->name . ' 🌟' . PHP_EOL .
        '📜 Invoice ID: #' . $invoice->id . PHP_EOL .
        '📜 Invoice Link: ' . $url . PHP_EOL .
        '⏰ Invoice Time: ' . Carbon::parse($invoice->created_at)->format('Y-m-d H:i:s') . PHP_EOL .
        '📅 Next Renewal Date: ' . Carbon::parse($store->expiry)->format('Y-m-d H:i:s') . PHP_EOL .
        '💡 Note: Please ensure payment is made before the next renewal deadline.';

        self::$Data['number'] = $user->phone;
        self::$Data['message'] = $message;
        self::$Data['instance_id'] = $instance_id->value;
        self::$Data['access_token'] = $access_token->value;

        $response = Http::post(self::MainUrl, self::$Data);

        return $response->successful();

    }

    public static function CreateStore($invoice)
    {
        $instance_id = \App\Models\Option::where('key', 'instance_id')->first();
        $access_token = \App\Models\Option::where('key', 'access_token')->first();
        $user = User::find($invoice->user_id);

        $store = stores::find($invoice->store_id);
        $url = route('front.invoices.show', $invoice->hash);
        $message = '🌟 Welcome to ' . $user->name . ' 🌟' . PHP_EOL .
        '📜 Invoice ID: #' . $invoice->id . PHP_EOL .
        '📜 Invoice Link: ' . $url . PHP_EOL .
        '⏰ Invoice Time: ' . Carbon::parse($invoice->created_at)->format('Y-m-d H:i:s') . PHP_EOL .
        '📅 Next Renewal Date: ' . Carbon::parse($store->expiry)->addDays(30)->format('Y-m-d H:i:s') . PHP_EOL .
        '💡 Note: Please pay the invoice to activate your store.';

        self::$Data['number'] = $user->phone;
        self::$Data['message'] = $message;
        self::$Data['instance_id'] = $instance_id->value;
        self::$Data['access_token'] = $access_token->value;

        $response = Http::post(self::MainUrl, self::$Data);

        return $response->successful();
    }


}
