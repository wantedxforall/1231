<?php

namespace App\Helpers;

use Exception;
use Carbon\Carbon;
use App\Models\Option;
use App\Models\front\stores;
use App\Models\front\invoices;
use App\Models\front\transactions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class Tiny
{
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

    public static function option($key, $value = null)
    {

        $option = \App\Models\Option::where('key', $key)->first();

        if (is_null($option)) {
            return null;
        }
        if (is_null($value)) {
            return $option->is_image ? url('storage/' . $option->value) : $option->value;
        }

        if ($option->is_image) {
            if (Storage::disk('public')->exists($option->value)) {
                Storage::disk('public')->delete($option->value);
            }
            $valueN = Storage::disk('public')->put('options', $value);
        } elseif ($option->is_boolean) {
            $valueN = $value ? 1 : 0;
        } else {
            $valueN = $value;
        }

        $option->update([
            'value' => $valueN,
        ]);

        // Update the cache
        $options = Option::all();
        $optionsArray = [];
        foreach ($options as $opt) {
            $optionsArray[$opt->key] = $opt->value;
        }
        Cache::set('all_options', json_encode($optionsArray));

        return $option->value;
    }


    public static function isCurrentLanguage($language)
    {
        return App::isLocale($language);
    }

    public static function extractNumbers($text, $provider)
    {
        if ($provider->name == 'VF-Cash-Instapay') {
            $text = str_replace(',', '.', $text);
        }
        preg_match_all('/\d+(\.\d+)?/', $text, $matches);
        $numbers = $matches[0];

        return $numbers;
    }

    public static function extractNumbersToken($text, $provider)
    {
        if ($provider == 'VF-Cash-Instapay') {
            $text = str_replace(',', '.', $text);
        }
        preg_match_all('/\d+(\.\d+)?/', $text, $matches);
        $numbers = $matches[0];

        return $numbers;
    }

    // public static function extractDataByArrayToken($text, $provider)
    // {
    //     if (strpos($text, 'Available Balance:') !== false && $provider == 'VF-Cash') {
    //         $provider = 'VF-Cash-Instapay';
    //     }
    //     if (strpos($text, 'تم إيداع مبلغ') !== false && $provider == 'ET Cash') {
    //         $provider = 'ET Cash-Instapay';
    //     }
    //     $numbers = self::extractNumbersToken($text, $provider);

    //     if ($provider == "ALEXBANK") {
    //         $text = str_replace(',', '', $text);
    //         preg_match('/مبلغ (\d+\.?\d*) جم/', $text, $amountMatches);
    //         $amount = $amountMatches[1] ?? '';

    //         preg_match('/من\s+(.*?)\s+يوم/', $text, $nameMatches);
    //         $name = $nameMatches[1] ?? '';

    //         preg_match('/رقم المعاملة\s+(\w+)/', $text, $transactionIdMatches);
    //         $transactionId = $transactionIdMatches[1] ?? '';
    //         return [
    //             'phone_number' => null,
    //             'transaction_number' => $transactionId,
    //             'amount' => $amount,
    //             'balance' => null,
    //             'name' => $name,
    //         ];
    //     }
    //     if ($provider == "VF-Cash") {
    //         return [
    //             'phone_number' => $numbers[1],
    //             'transaction_number' => $numbers[8],
    //             'amount' => $numbers[0],
    //             'balance' => $numbers[2],
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "VF-Cash-Instapay") {
    //         $amount = str_replace('.', '', $numbers[5]);
    //         $phone_number = preg_replace('/^002/', '', $numbers[6]);
    //         return [
    //             'phone_number' => $phone_number,
    //             'transaction_number' => $numbers[8],
    //             'amount' => $amount,
    //             'balance' => $numbers[9],
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "Libyana" && strpos($text, 'تم تحويل') === 0) {
    //         return [
    //             'phone_number' => $numbers[1],
    //             'transaction_number' => uniqid(),
    //             'amount' => $numbers[0],
    //             'balance' => null,
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "Almadar" && strpos($text, 'المشترك الكريم,لقد تم تحويل') === 0) {
    //         return [
    //             'phone_number' => $numbers[1],
    //             'transaction_number' => uniqid(),
    //             'amount' => $numbers[0],
    //             'balance' => $numbers[2],
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "ET Cash") {
    //         return [
    //             'phone_number' => $numbers[1],
    //             'transaction_number' => uniqid(),
    //             'amount' => $numbers[0],
    //             'balance' => $numbers[2],
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "ET Cash-Instapay") {
    //         $phone_number = str_replace('002', '', $numbers[1]);
    //         return [
    //             'phone_number' => $phone_number,
    //             'transaction_number' => uniqid(),
    //             'amount' => $numbers[0],
    //             'balance' => null,
    //             'name' => null,
    //         ];
    //     }
    //     if ($provider == "Asiacell") {
    //         return [
    //             'phone_number' => $numbers[1],
    //             'transaction_number' => null,
    //             'amount' => $numbers[0],
    //             'balance' => $numbers[5],
    //             'name' => null,
    //         ];
    //     }
    // }

    public static function extractDataByArrayToken($text, $provider)
    {
        Log::info([
            'text' => $text,
            'provider' => $provider,
        ]);
        // Check for specific provider conditions and adjust the provider accordingly
        if (strpos($text, 'Available Balance:') !== false && $provider == 'VF-Cash') {
            $provider = 'VF-Cash-Instapay';
        }
        if (strpos($text, 'تم إيداع مبلغ') !== false && $provider == 'ET Cash') {
            $provider = 'ET Cash-Instapay';
        }

        // Extract numbers based on the provider
        $numbers = self::extractNumbersToken($text, $provider);
        // dd($numbers);
        switch ($provider) {
            case 'CliQ':
                $text = str_replace(',', '', $text);

                preg_match('/من\s+•(.*?)\s+الرصيد المتوفر/', $text, $nameMatches);
                $name = $nameMatches[1] ?? '';

                return [
                    'phone_number' => null,
                    'transaction_number' => null,
                    'amount' => $numbers[0],
                    'balance' => null,
                    'name' => $name,
                ];
            case "CIB":
                $text = str_replace(',', '', $text);

                preg_match('/مبلغ (\d+\.?\d*) جم/', $text, $amountMatches);
                $amount = $amountMatches[1] ?? '';

                preg_match('/من\s+(.*?)\s+برقم مرجعي/', $text, $nameMatches);
                $name = $nameMatches[1] ?? '';

                preg_match('/برقم مرجعي\s+(\w+)/', $text, $transactionIdMatches);
                $transactionId = $transactionIdMatches[1] ?? '';

                return [
                    'phone_number' => null,
                    'transaction_number' => $transactionId,
                    'amount' => $amount,
                    'balance' => null,
                    'name' => $name,
                ];
            case "ALEXBANK":
                $text = str_replace(',', '', $text);
                preg_match('/مبلغ (\d+\.?\d*) جم/', $text, $amountMatches);
                $amount = $amountMatches[1] ?? '';

                preg_match('/من\s+(.*?)\s+يوم/', $text, $nameMatches);
                $name = $nameMatches[1] ?? '';

                preg_match('/رقم المعاملة\s+(\w+)/', $text, $transactionIdMatches);
                $transactionId = $transactionIdMatches[1] ?? '';

                return [
                    'phone_number' => null,
                    'transaction_number' => $transactionId,
                    'amount' => $amount,
                    'balance' => null,
                    'name' => $name,
                ];
            case "VF-Cash":
                if (isset($numbers[8])) {
                    return [
                        'phone_number' => $numbers[1],
                        'transaction_number' => $numbers[8],
                        'amount' => $numbers[0],
                        'balance' => $numbers[2],
                        'name' => null,
                    ];
                } else {
                    return [
                        'phone_number' => $numbers[1],
                        'transaction_number' => $numbers[7],
                        'amount' => $numbers[0],
                        'balance' => null,
                        'name' => null,
                    ];
                }
            case "VF-Cash-Instapay":
                $amount = str_replace('.', '', $numbers[5]);
                $phone_number = preg_replace('/^002/', '', $numbers[6]);

                return [
                    'phone_number' => $phone_number,
                    'transaction_number' => $numbers[8],
                    'amount' => $amount,
                    'balance' => $numbers[9],
                    'name' => null,
                ];
            case "Libyana":
                if (strpos($text, 'تم تحويل') === 0) {
                    return [
                        'phone_number' => $numbers[1],
                        'transaction_number' => uniqid(),
                        'amount' => $numbers[0],
                        'balance' => null,
                        'name' => null,
                    ];
                }
                break;
            case "Almadar":
                if (strpos($text, 'المشترك الكريم,لقد تم تحويل') === 0) {
                    return [
                        'phone_number' => $numbers[1],
                        'transaction_number' => uniqid(),
                        'amount' => $numbers[0],
                        'balance' => $numbers[2],
                        'name' => null,
                    ];
                }
                break;
            case "ET Cash":
                return [
                    'phone_number' => $numbers[1],
                    'transaction_number' => uniqid(),
                    'amount' => $numbers[0],
                    'balance' => $numbers[2],
                    'name' => null,
                ];
            case "ET Cash-Instapay":
                $phone_number = str_replace('002', '', $numbers[1]);

                return [
                    'phone_number' => $phone_number,
                    'transaction_number' => uniqid(),
                    'amount' => $numbers[0],
                    'balance' => null,
                    'name' => null,
                ];
            case "Asiacell":
                return [
                    'phone_number' => $numbers[1],
                    'transaction_number' => null,
                    'amount' => $numbers[0],
                    'balance' => $numbers[5],
                    'name' => null,
                ];
            default:
                return [];
        }
    }


    public static function currencyRate($store)
    {
        $options = options();
        if ($store->ratesync == true) {
            if ($store->synctype == 1) {
                $rate = Redis::get('usdt_rate');
                if ($rate === null) {
                    $rate = $options['usdt_rate'];
                    Redis::setex('usdt_rate', 600, $rate);
                }
            } else {
                $rate = Redis::get('usd_rate');
                if ($rate === null) {
                    $rate = $options['usd_rate'];
                    Redis::setex('usd_rate', 600, $rate);
                }
            }
        } else {
            $rate = $store->currency;
        }
        return $rate;
    }

    // Calculate bonus amount based on the specified percentage
    public static function BounsAmount($store, $data)
    {
        $amount = $data['amount'] * ($store->bonus_amount / 100);
        return $amount;
    }


    public static function extractData($text, $text_phone, $text_transaction, $text_amount)
    {
        // Initialize variables
        $phone_number = null;
        $transaction_number = null;
        $amount = null;

        if ($text_phone !== null) {
            try {
                // Extract the phone number
                preg_match('/' . $text_phone . '\s*(\d+)/u', $text, $phone_number_match);
                $phone_number = $phone_number_match[1] ?? null;
            } catch (\Exception $e) {
                // Handle the exception, log or report it
            }
        }

        if ($text_transaction !== null) {
            try {
                // Extract the transaction number
                // preg_match('/' . $text_transaction . '\s*(\d+)/u', $text, $transaction_number_match);
                preg_match('/\s*' . $text_transaction . '\s*(\d+)/u', $text, $transaction_number_match);
                $transaction_number = $transaction_number_match[1] ?? null;
            } catch (\Exception $e) {
                // Handle the exception, log or report it
            }
        }

        try {
            // Extract the amount
            preg_match('/' . $text_amount . '\s*(\d+(\.\d+)?)/u', $text, $amount_match);
            $amount = $amount_match[1] ?? null;
        } catch (\Exception $e) {
            // Handle the exception, log or report it
        }

        // Return the extracted data
        return [
            'phone_number' => $phone_number,
            'transaction_number' => $transaction_number,
            'amount' => $amount,
        ];
    }

    public static function addPayment($from, $name, $domain, $key, $username, $amount, $transaction_id, $afc, $rate)
    {
        $response = Http::get('https://' . $domain . '/adminapi/v1', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'details' => ($from ?? $name) . '.' . $transaction_id . '/' . $rate,
            'affiliate_commission' => $afc,
        ]);
        return $response;
    }

    public static function addBonus($provider, $domain, $key, $username, $amount, $transaction_id)
    {
        $response = Http::get('https://' . $domain . '/adminapi/v1', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'details' => $provider . ' Transaction Bonus #' . $transaction_id,
        ]);
        return $response;
    }

    public static function addPaymentCookies($from, $domain, $key, $username, $amount, $transaction_id, $afc, $rate)
    {
        $response = Http::withHeaders([
            'Cookie' => 'admin_hash=' . $key,
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
        ])->post('https://' . $domain . '/admin/api/payments/add', [
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'memo' => $from . '.' . $transaction_id . '/' . $rate,
            'include_referral_payment' => $afc ? true : false,
            "method" => 77,
        ]);
        return $response;
    }

    public static function addBonusCookies($provider, $domain, $key, $username, $amount, $transaction_id)
    {
        $response = Http::withHeaders([
            'Cookie' => 'admin_hash=' . $key,
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
        ])->post('https://' . $domain . '/admin/api/payments/add', [
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'memo' => $provider . ' Transaction Bonus #' . $transaction_id,
            'include_referral_payment' => false,
            "method" => 102,
        ]);
        return $response;
    }

    public static function addPaymentCookiesC($from, $domain, $key, $username, $amount, $transaction_id, $afc, $rate)
    {
        $response = Http::withHeaders([
            'Cookie' => $key,
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
        ])->post('https://' . $domain . '/admin/payments/new-online', [
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'add-remove' => 'add',
            'note' => $from . '.' . $transaction_id . '/' . $rate,
            "method" => 1,
        ]);
        return $response;
    }

    public static function addBonusCookiesC($provider, $domain, $key, $username, $amount, $transaction_id)
    {
        $response = Http::withHeaders([
            'Cookie' => $key,
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
        ])->post('https://' . $domain . '/admin/payments/new-online', [
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'add-remove' => 'add',
            'note' => $provider . ' Transaction Bonus #' . $transaction_id,
            "method" => 1,
        ]);
        return $response;
    }

    public static function addPaymentCustom($from, $domain, $key, $username, $amount, $transaction_id, $afc, $rate)
    {
        $response = Http::get('https://' . $domain . '/smspaymentapi', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'note' => $from . '.' . $transaction_id . '/' . $rate,
            'affiliate_commission' => $afc,
        ]);
        return $response;
    }

    public static function addBonusCustom($provider, $domain, $key, $username, $amount, $transaction_id)
    {
        $response = Http::get('https://' . $domain . '/smspaymentapi', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'note' => $provider . ' Transaction Bonus #' . $transaction_id,
        ]);
        return $response;
    }

    public static function addPaymentAmazing($from, $domain, $key, $username, $amount, $transaction_id, $afc, $rate)
    {
        $response = Http::get('https://' . $domain . '/smspaymentapi.php', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'from' => $from,
            'trans_id' => $transaction_id . '/' . $rate,
            'affiliate_commission' => $afc,
        ]);
        return $response;
    }

    public static function addBonusAmazing($provider, $from, $domain, $key, $username, $amount, $transaction_id)
    {
        $response = Http::get('https://' . $domain . '/smspaymentapi.php', [
            'key' => $key,
            'action' => 'addPayment',
            'username' => $username,
            'amount' => number_format($amount, 2, '.', ''),
            'from' => $from,
            'trans_id' => $provider . ' Transaction Bonus #' . $transaction_id,
            'affiliate_commission' => 0,
        ]);
        return $response;
    }


    public static function addPaymentSoc($key, $username, $amount)
    {
        $response = Http::get('https://socpanel.com/privateApi/incrementUserBalance', [
            'token' => $key,
            'login' => $username,
            'amount' => number_format($amount, 2, '.', ''),
        ]);
        return $response;
    }

    public static function addBonusSoc($key, $username, $amount)
    {
        $response = Http::get('https://socpanel.com/privateApi/incrementUserBalance', [
            'token' => $key,
            'login' => $username,
            'amount' => number_format($amount, 2, '.', ''),
        ]);
        return $response;
    }


    public static function transactionsFilter($data, $storeId = null)
    {
        $transactions = auth()->user()->transactions();
        if ($storeId) {
            $transactions = $transactions->where('store_id', $storeId);
        }
        if (isset($data['search'])) {
            if (!is_null($data['search'])) {
                $transactions = $transactions->where('transaction_id', 'like', '%' . $data['search'] . '%')->orWhere('from', 'like', '%' . $data['search'] . '%')->orWhere('username', 'like', '%' . $data['search'] . '%');
            }
        }
        // dd(request()->has('providers') && request()->get('providers') != 'all');
        if (isset($data['providers'])) {
            if (!is_null($data['providers']) && $data['providers'] != 'all') {
                $prov = (int) $data['providers'];
                $transactions = $transactions->whereHas('providers', function ($q) use ($prov) {
                    $q->where('id', $prov);
                });
            }
        }
        if (isset($data['status'])) {
            if (!is_null($data['status']) && (in_array($data['status'], array_keys(transactions::STATUSES)) && $data['status'] != 'all')) {
                $transactions = $transactions->where('status', $data['status']);
            }
        }

        if (isset($data['date'])) {
            if (!is_null($data['date']) && $data['date'] != '') {
                $dates = explode(' ', $data['date']);
                $startDate = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dates[0]) ? $dates[0] : null;
                if (!is_null($dates[2])) {
                    $endDate = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dates[2]) ? $dates[2] : null;
                }
                $transactions = $transactions->where(function ($transaction) use ($startDate, $endDate) {
                    $transaction->whereDate('created_at', '>=', Carbon::parse($startDate));
                    if ($endDate) {
                        $transaction->whereDate('created_at', '<=', Carbon::parse($endDate));
                    }
                });
            }
        }

        if (isset($data['fromslider']) && isset($data['toslider'])) {
            if ((!is_null($data['fromslider']) && !is_null($data['toslider'])) && $data['toslider'] != "0.00") {
                $fromSlider = (int) $data['fromslider'];
                $toSlider = (int) $data['toslider'];
                $transactions = $transactions->where(function ($transaction) use ($fromSlider, $toSlider) {
                    $transaction->where('amount', '>=', $fromSlider)->where('amount', '<=', $toSlider);
                });
            }
        }

        if (isset($data['username'])) {
            if (!is_null($data['username']) && $data['username'] != '') {
                $username = (string) $data['username'];
                $transactions = $transactions->where('username', $username);
            }
        }

        if (isset($data['from'])) {
            if (!is_null($data['from']) && $data['from'] != '') {
                $phone = (string) $data['from'];
                $transactions = $transactions->where('from', $phone);
            }
        }

        if (isset($data['transaction'])) {
            if (!is_null($data['transaction']) && $data['transaction'] != '') {
                $transaction = (string) $data['transaction'];
                $transactions = $transactions->where('transaction_id', $transaction);
            }
        }

        $transactions = $transactions->latest()->get();
        return $transactions;
    }

    public static function isPaid($invoice)
    {
        $invoice = invoices::find($invoice);
        if ($invoice->status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function TotalPaidAmount()
    {
        $totalAmount = invoices::where('status', 1)->sum('amount');

        return $totalAmount;
    }

    public static function TotalPaidCount()
    {
        $totalCount = invoices::where('status', 1)->count();

        return $totalCount;
    }

    public static function TotalPendingAmount()
    {
        $totalAmount = invoices::where('status', 0)->sum('amount');

        return $totalAmount;
    }

    public static function TotalPendingCount()
    {
        $totalCount = invoices::where('status', 0)->count();

        return $totalCount;
    }

    public static function TotalCanceldCount()
    {
        $totalCount = invoices::where('status', 2)->count();

        return $totalCount;
    }


    public static function TotaltransactionsCount()
    {
        $totalCount = transactions::count();

        return $totalCount;
    }



    public static function transactionsCountForStore($storeId)
    {
        $cacheKey = 'transactions_count_for_store_' . $storeId;
        $transactionCount = Cache::get($cacheKey);
        if ($transactionCount === null) {
            $endDate = stores::where('id', $storeId)->value('expiry');
            $startDate = Carbon::parse($endDate)->subDays(30)->toDateTimeString();
            $transactionCount = transactions::where('store_id', $storeId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            Cache::put($cacheKey, $transactionCount, now()->addMinutes(60));
        }

        return $transactionCount;
    }

    public static function AmountCountForStore($storeId)
    {
        $cacheKey = 'amount_count_for_store_' . $storeId;
        $transactionAmount = Cache::get($cacheKey);
        if ($transactionAmount === null) {
            $endDate = stores::where('id', $storeId)->value('expiry');
            $startDate = Carbon::parse($endDate)->subDays(30)->toDateTimeString();
            $transactionAmount = transactions::where('store_id', $storeId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            Cache::put($cacheKey, $transactionAmount, now()->addMinutes(60));
        }

        return $transactionAmount;
    }

    public static function estimatedMessagesCountForStore($storeId)
    {
        $cacheKey = 'estimated_messages_count_for_store_' . $storeId;
        $estimatedMessagesCount = Cache::get($cacheKey);
        if ($estimatedMessagesCount === null) {
            $store = stores::find($storeId);
            if ($store) {
                $endDate = Carbon::parse($store->expiry);
                $startDate = $endDate->copy()->subDays(30);
                $transactionsCount = transactions::where('store_id', $storeId)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $daysRemaining = $endDate->diffInDays(now(), false);
                if ($daysRemaining > 0) {
                    $averageMessagesPerDay = $transactionsCount / $daysRemaining;
                    $estimatedMessagesCount = round($averageMessagesPerDay * $daysRemaining);
                } else {
                    $estimatedMessagesCount = 0;
                }

                Cache::put($cacheKey, $estimatedMessagesCount, now()->addMinutes(60));
            } else {
                $estimatedMessagesCount = 0;
            }
        }

        return $estimatedMessagesCount;
    }
}
