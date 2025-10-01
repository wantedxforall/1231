<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Helpers\Tiny;
use App\Helpers\Whatsapp;
use App\Models\Providers;
use App\Models\front\plans;
use App\Models\front\stores;
use Illuminate\Http\Request;
use App\Models\StoreProvider;
use App\Models\front\invoices;
use App\Models\front\transactions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\front\StoresReuest;
use Illuminate\Support\Facades\Validator;

class StoresController extends Controller
{
    public function index()
    {
        $stores = stores::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->paginate(paginate());
        return view('front.stores.index', compact('stores'));
    }

    public function create()
    {
        $providers = Providers::where('status', 1)->orderBy('id', 'desc')->get();
        return view('front.stores.create_store', compact('providers'));
    }

    public function save_store(StoresReuest $request)
    {
        // dd($request->all());
        try {
            $data = $request->all();
            $options = options();

            if (!$request->logo) {
                $data['logo'] = asset('assets/media/logos/default.png');
            } else {
                $data['logo'] = Storage::put('stores', $request->file('logo'));
            }
            if (auth()->user()->isAdmin()) {
                $data['user_id'] = Auth::id();
            } else {
                $data['user_id'] = Auth::id();
            }
            $data['status'] = 0;
            $data['plan_id'] = $options['default_plan'];
            $data['actions'] = 1;

            $data['username'] = $request->input('username');
            $amount = plans::find($options['default_plan']);


            // if (!$request->has('afc')) {
            //     $data['afc'] == 0;
            // } else {
            //     $data['afc'] = $request->input('afc');
            // }

            if (!$request->has('bonus')) {
                $data['bonus'] == 0;
            } else {
                $data['bonus'] = $request->input('bonus');
            }

            if ($request->integration == 2) {
                $data['key'] = $request->input('key-perfect');
                $data['afc'] = $request->input('afc-perfect');
            }
            if ($request->integration == 3) {
                $data['key'] = $request->input('key-soc');
                $data['bonus'] = $request->input('bonus-soc');
                $data['bonus_amount'] = $request->input('bonus_amount-soc');
                $data['bonus_from'] = $request->input('bonus_from-soc');
            }
            if ($request->integration == 4) {
                $data['key'] = $request->input('key-amazing');
                $data['afc'] = $request->input('afc-amazing');
                $data['bonus'] = $request->input('bonus-amazing');
                $data['bonus_amount'] = $request->input('bonus_amount-amazing');
                $data['bonus_from'] = $request->input('bonus_from-amazing');
            }
            if ($request->integration == 5) {
                $data['username_chaild'] = $request->input('username_chaild');
                $data['password_chaild'] = $request->input('password_chaild');
                $data['key'] = $request->input('key-child');
                $data['afc'] = $request->input('afc-child');
                $data['bonus'] = $request->input('bonus-child');
                $data['bonus_amount'] = $request->input('bonus_amount-child');
                $data['bonus_from'] = $request->input('bonus_from-child');
            }

            if ($request->integration == 6) {
                $data['afc'] = 0;
                $data['key'] = $request->input('key-custom');
                $data['bonus'] = $request->input('bonus-custom');
                $data['bonus_amount'] = $request->input('bonus_amount-custom');
                $data['bonus_from'] = $request->input('bonus_from-custom');
            }

            // dd($data['key']);

            $newstore = stores::create([
                'store_key' => bin2hex(random_bytes(8)),
                'user_id' => $data['user_id'],
                'plan_id' => $data['plan_id'],
                'integration' => $data['integration'],
                'key' => $data['key'],
                'name' => $data['name'],
                'username' => $data['username'],
                'username_chaild' => $data['username_chaild'],
                'password_chaild' => $data['password_chaild'],
                'domain' => $data['domain'],
                'logo' => $data['logo'],
                'currency' => $data['currency'],
                'ratesync' => $data['ratesync'],
                'sim1' => $data['sim1'],
                'sim2' => $data['sim2'],
                'synctype' => $data['synctype'],
                'mobile_wallet' => $data['mobile_wallet'],
                'whatsapp' => $data['whatsapp'],
                'actions' => $data['actions'],
                'afc' => $data['afc'],
                'bonus' => $data['bonus'],
                'bonus_amount' => $data['bonus_amount'],
                'bonus_from' => $data['bonus_from'],
                'status' => $data['status'],
            ]);

            foreach ($request->providers as $key => $value) {
                StoreProvider::create([
                    'store_id' => $newstore->id,
                    'provider_id' => $key,
                    'status' => $value,
                ]);
            }

            $newinvoice = invoices::create([
                'hash' => bin2hex(random_bytes(16)),
                'user_id' => $data['user_id'],
                'store_id' => $newstore->id,
                'amount' => $amount->cost,
                'status' => 0,
            ]);

            session()->flash('success', "Done Save " . $data['name']);
            try {
                Whatsapp::CreateStore($newinvoice);
            } catch (\Exception $e) {
                Log::alert('message Create Store failed');
            };

            return redirect()->route('front.invoices.show', $newinvoice->hash);
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', $th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $providers = Providers::where('status', 1)->orderBy('id', 'desc')->get();
        $store = stores::findOrFail($id);
        if (!auth()->user()->isAdmin() && Auth::id() != $store->user_id) {
            return redirect()->route('front.home');
        }
        return view('front.stores.create_store', compact('store', 'providers'));
    }
    public function integration(stores $store)
    {
        return view('front.stores.integration', compact('store'));
    }
    public function qrcode(stores $store)
    {
        if (!auth()->user()->isAdmin() && Auth::id() != $store->user_id) {
            return redirect()->route('front.home');
        }
        $cacheKey = 'qrcode_' . $store->store_key;
        // Check if the QR code exists in the cache
        if (Cache::has($cacheKey)) {
            $qrcode = Cache::get($cacheKey);
        } else {
            $response = Http::get('https://smslab.blast-media.net/api/v1/qr_code_image_src', [
                'store_key' => $store->store_key,
                'domain' => route('front.home'),
            ]);
            $result_body = $response->json();
            $qrcode = $result_body['data']['image'];
            // Cache the QR code for future use (for example, cache it for 24 hours)
            Cache::put($cacheKey, $qrcode);
        }

        return view('front.stores.qrcode', compact('qrcode'));
    }

    public function transactions(stores $store)
    {
        $transactions = $store->transactions();
        if (!auth()->user()->isAdmin() && Auth::id() != $store->user_id) {
            return redirect()->route('front.home');
        }
        $transactions = $store->transactions()->latest();
        $providers = Providers::where('status', 1)->get();
        // $stores = stores::where('status', 1)->where('user_id', Auth::id())->get();
        $stores = auth()->user()->stores()->where('status', 1)->get();
        $startDate = null;
        $endDate = null;
        $fromSlider = 0;
        $toSlider = 0;

        if (request()->has('search')) {
            $transactions = $transactions->where('transaction_id', 'like', '%' . request('search') . '%')->orWhere('from', 'like', '%' . request('search') . '%')->orWhere('username', 'like', '%' . request('search') . '%');
        }
        // dd(request()->has('providers') && request()->get('providers') != 'all');
        if (request()->has('providers') && request()->get('providers') != 'all') {
            $prov = (int) request()->get('providers');
            $transactions = $transactions->whereHas('providers', function ($q) use ($prov) {
                $q->where('id', $prov);
            });
        }
        if (request()->has('status') && (in_array(request('status'), array_keys(transactions::STATUSES)) && request('status') != 'all')) {
            $transactions = $transactions->where('status', request('status'));
        }

        if (request()->has('date') & request()->get('date') != '') {
            $dates = explode(' ', request()->get('date'));
            $startDate = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dates[0]) ? $dates[0] : null;
            if (isset($dates[2])) {
                $endDate = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dates[2]) ? $dates[2] : null;
            }
            $transactions = $transactions->where(function ($transaction) use ($startDate, $endDate) {
                $transaction->whereDate('created_at', '>=', Carbon::parse($startDate));
                if ($endDate) {
                    $transaction->whereDate('created_at', '<=', Carbon::parse($endDate));
                }
            });
        }

        if ((request()->has('fromslider') && request()->has('toslider')) && request()->get('toslider') != "0.00") {
            $fromSlider = (int) request()->get('fromslider');
            $toSlider = (int) request()->get('toslider');
            $transactions = $transactions->where(function ($transaction) use ($fromSlider, $toSlider) {
                $transaction->where('amount', '>=', $fromSlider)->where('amount', '<=', $toSlider);
            });
        }

        if (request()->has('username') && request()->get('username') != '') {
            $username = (string) request()->get('username');
            $transactions = $transactions->where('username', $username);
        }

        if (request()->has('from') && request()->get('from') != '') {
            $phone = (string) request()->get('from');
            $transactions = $transactions->where('from', $phone);
        }

        if (request()->has('transaction') && request()->get('transaction') != '') {
            $transaction = (string) request()->get('transaction');
            $transactions = $transactions->where('transaction_id', $transaction);
        }

        $transactions = $transactions->orderby('id', 'desc')->paginate(10);
        // dd($transactions);
        $maxAmount = auth()->user()->transactions()->max('amount');

        // $transactions = transactions::where('store_id','=',Auth::id())->orderBy('id','desc')->paginate(paginate());
        return view('front.stores.transactions', compact('transactions', 'providers', 'stores', 'startDate', 'endDate', 'maxAmount', 'fromSlider', 'toSlider', 'store'));
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $stores = stores::find($id);
        $panl = plans::first()->get();

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $data['logo'] = Storage::putFile('stores', $logo);
            $stores->logo = $data['logo'];
        }

        $stores->username = $request->input('username');
        // $stores->name = $request->input('name');
        // $stores->domain = $request->input('domain');
        $stores->integration = $request->input('integration');
        // $stores->key = $request->input('key');
        // $stores->afc = $request->input('afc');
        $stores->currency = $request->input('currency');
        $stores->mobile_wallet = $request->input('mobile_wallet');
        $stores->whatsapp = $request->input('whatsapp');
        $stores->ratesync = $request->input('ratesync');
        $stores->synctype = $request->input('synctype');
        $stores->sim1 = $request->input('sim1');
        $stores->sim2 = $request->input('sim2');
        $stores->bonus = $request->input('bonus');
        $stores->bonus_from = $request->input('bonus_from');
        $stores->bonus_amount = $request->input('bonus_amount');

        if ($request->integration == 2) {
            $stores->key = $request->input('key-perfect');
            $stores->afc = $request->input('afc-perfect');
        }
        if ($request->integration == 3) {
            $stores->key = $request->input('key-soc');
            $stores->bonus = $request->input('bonus-soc');
            $stores->bonus_amount = $request->input('bonus_amount-soc');
            $stores->bonus_from = $request->input('bonus_from-soc');
        }
        if ($request->integration == 4) {
            $stores->key = $request->input('key-amazing');
            $stores->afc = $request->input('afc-amazing');
            $stores->bonus = $request->input('bonus-amazing');
            $stores->bonus_amount = $request->input('bonus_amount-amazing');
            $stores->bonus_from = $request->input('bonus_from-amazing');
        }
        if ($request->integration == 5) {
            $stores->username_chaild = $request->input('username_chaild');
            $stores->password_chaild = $request->input('password_chaild');
            $stores->key = $request->input('key-child');
            $stores->afc = $request->input('afc-child');
            $stores->bonus = $request->input('bonus-child');
            $stores->bonus_amount = $request->input('bonus_amount-child');
            $stores->bonus_from = $request->input('bonus_from-child');
        }
        if ($request->integration == 6) {
            $stores->key = $request->input('key-custom');
            $stores->bonus = $request->input('bonus-custom');
            $stores->bonus_amount = $request->input('bonus_amount-custom');
            $stores->bonus_from = $request->input('bonus_from-custom');
        }


        $stores->save();

        $storeData = $stores->toArray();

        Redis::setex('store_data:' . $stores->store_key, 600, json_encode($storeData));


        // foreach ($request->providers as $key => $value) {

        //     StoreProvider::updateOrCreate(
        //         [
        //             'provider_id' => $key,
        //             'store_id' => $stores->id
        //         ],
        //         ['status' => $value]
        //     );
        // }
        return redirect()->route('front.stores');
    }

    public function payment_link(Stores $store, $username)
    {
        $cacheKey = 'store_' . $username;
        $store = Cache::get($cacheKey);
        if (!$store) {
            $store = stores::query()
                ->where('username', $username)
                ->where('status', 1)
                ->first();

            Cache::put($cacheKey, $store, now()->addHours(24));
        }

        // $store = stores::query()
        // ->where('username', $username)
        // ->where('status', 1)
        // ->first();

        if ($store == null) {
            return redirect()->route('front.layouts.404');
        }
        if ($store->status != 1) {
            return redirect()->route('front.layouts.404');
        }
        return view('front.stores.payment_link', compact('store'));
    }


    public function payment_info($store_id)
    {
        try {
            // Check if data exists in cache
            $cacheKey = 'payment_info:' . $store_id;
            if (Redis::exists($cacheKey)) {
                $cachedData = Redis::get($cacheKey);
                return response()->json(json_decode($cachedData, true));
            }

            $store = stores::find($store_id);
            $options = options();

            if (!$store) {
                return response()->json([
                    'error' => 'Store ID Not Found',
                ], 404);
            }

            $mobileNumbers = explode(',', $store->mobile_wallet);
            $number = array_rand($mobileNumbers);
            $number = $mobileNumbers[$number];

            $number = explode(',', $number);
            if ($store->ratesync == true) {
                if ($store->synctype == 1) {
                    $rate = $options['usdt_rate'];
                } else {
                    $rate = $options['usd_rate'];
                }
            } else {
                $rate = number_format($store->currency, 2, '.', '');
            }
            $extotal = $rate * 5;
            $data = [
                'number' => $number,
                'rate' => $rate,
                'extotal' => number_format($extotal, 2, '.', ''),
                'storecurrency' => [
                    "code" => "USD",
                    "name_en" => "Dollar",
                    "name_ar" => "دولار",
                    "symbol" => "$",
                    "symbol_ar" => "$"
                ],
                'yourcurrency' => [
                    "code" => "EGP",
                    "name_en" => "Egyptian Pound",
                    "name_ar" => "جنيه مصري",
                    "symbol" => "EGP",
                    "symbol_ar" => "ج.م"
                ],
            ];

            // Store data in Redis
            Redis::setex($cacheKey, 600, json_encode($data));

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error retrieving payment info: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getPaymentInfo(Request $request)
    {
        // dd($request->all());
        try {
            // Check if data exists in cache
            // $cacheKey = 'payment_info:' . $request->store_id;
            // if (Redis::exists($cacheKey)) {
            //     $cachedData = Redis::get($cacheKey);
            //     return response()->json(json_decode($cachedData, true));
            // }

            $store = stores::find($request->store_id);
            $options = options();

            if (!$store) {
                return response()->json([
                    'error' => 'Store not found',
                ], 404);
            }

            // $mobileNumbers = explode(',', $store->mobile_wallet);
            // $number = array_rand($mobileNumbers);
            // $number = $mobileNumbers[$number];

            // $number = explode(',', $store->mobile_wallet);

            if ($store->ratesync == true) {
                if ($store->synctype == 1) {
                    $rate = $options['usdt_rate'];
                } else {
                    $rate = $options['usd_rate'];
                }
            } else {
                $rate = number_format($store->currency, 2, '.', '');
            }
            $extotal = $rate * 5;
            $percentage = $options['usdt_rate'] - $options['usd_rate'];
            $data = [
                'number' => $store->mobile_wallet,
                'whatsapp' => $store->whatsapp,
                'rate' => $rate,
                'percentage' => $percentage,
                'extotal' => number_format($extotal, 2, '.', ''),
                'storecurrency' => [
                    "code" => "USD",
                    "name_en" => "Dollar",
                    "name_ar" => "دولار",
                    "symbol" => "$",
                    "symbol_ar" => "$"
                ],
                'yourcurrency' => [
                    "code" => "EGP",
                    "name_en" => "Egyptian Pound",
                    "name_ar" => "جنيه مصري",
                    "symbol" => "EGP",
                    "symbol_ar" => "ج.م"
                ],
            ];

            // Store data in Redis
            // Redis::setex($cacheKey, 600, json_encode($data));

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error retrieving payment info: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function validateRequest($phone, $name, $amount, $user_name, $store_id, $lang)
    {
        if (empty($phone) && empty($name)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب إدخال إما رقم الهاتف أو الاسم!</div>' : '<div class="alert alert-danger">Either phone number or name must be provided!</div>']);
        }

        if (empty($amount)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">المبلغ غير موجود! الرجاء إدخال المبلغ.</div>' : '<div class="alert alert-danger">Amount is missing! Please enter the amount.</div>']);
        }

        if (empty($user_name)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">اسم المستخدم غير موجود! الرجاء إدخال اسم المستخدم.</div>' : '<div class="alert alert-danger">User name is missing! Please enter the user name.</div>']);
        }

        if (empty($store_id)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">رقم المتجر غير موجود! الرجاء إدخال رقم المتجر.</div>' : '<div class="alert alert-danger">Store ID is missing! Please enter the store ID.</div>']);
        }

        if (!is_numeric($phone) && !empty($phone)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب أن يكون رقم الهاتف رقمًا!</div>' : '<div class="alert alert-danger">Phone must be numeric!</div>']);
        }

        if (!is_numeric($amount)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب أن يكون المبلغ رقمًا!</div>' : '<div class="alert alert-danger">Amount must be numeric!</div>']);
        }

        if (!is_string($user_name)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب أن يكون اسم المستخدم سلسلة نصية!</div>' : '<div class="alert alert-danger">User name must be a string!</div>']);
        }

        if (!is_numeric($store_id)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب أن يكون رقم المتجر عددًا صحيحًا!</div>' : '<div class="alert alert-danger">Store ID must be an integer!</div>']);
        }

        if (!empty($lang) && !is_string($lang)) {
            return response()->json(['message' => $lang === 'ar' ? '<div class="alert alert-danger">يجب أن تكون اللغة سلسلة نصية!</div>' : '<div class="alert alert-danger">Language must be a string!</div>']);
        }

        return null;
    }

    public function payment_link_check(Request $request)
    {
        $data = $request->all();
        $phone = $request->input('phone');
        $name = $request->input('name');
        $amount = $request->input('amount');
        $user_name = $request->input('user_name');
        $store_id = $request->input('store_id');
        $lang = $request->input('lang');
        $response = $this->validateRequest($phone, $name, $amount, $user_name, $store_id, $lang);
        if ($response) {
            return $response;
        }

        $statuses = [0, 1, 4];

        if ($phone) {
            $transaction = transactions::where('store_id', $store_id)
            ->where('from', $phone)
            ->where('amount', $amount)
            ->whereIn('status', $statuses)
            ->first();
        } else {
            $transaction = transactions::where('store_id', $store_id)
            ->where('name', $name)
            ->where('amount', $amount)
            ->whereIn('status', $statuses)
            ->first();
        }

        // if (!$transaction) {
        //     // Handle transaction not found
        //     Log::info(['transactions' => $transaction, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'mismatched_information']);
        //     $errorMessage = isset($data['lang']) && $data['lang'] == 'ar' ? 'معلومات غير متطابقة. حاول مرة أخرى!' : 'Mismatched information. Try again!';
        //     return response()->json(['message' => '<div class="alert alert-danger">' . $errorMessage . '</div>']);
        // }

        if (!$transaction) {
            // Handle transaction not found
            // Log::info(['transactions' => $transaction, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'mismatched_information']);
            $errorMessage = isset($data['lang']) && $data['lang'] == 'ar' ? 'معلومات غير متطابقة. حاول مرة أخرى!' : 'Mismatched information. Try again!';
            return response()->json([
                'message' => "<div class='alert alert-danger'>$errorMessage</div>",
                'status' => 'fail',
                'code' => 400
            ]);
        }


        // if (Cache::has('transaction_check:' . $transaction->id)) {
        //     // Handle transaction already in progress
        //     $errorMessage = isset($data['lang']) && $data['lang'] == 'ar' ? 'المعاملة جارية بالفعل. انتظر من فضلك.' : 'Transaction already in progress. Please wait.';
        //     return response()->json(['message' => '<div class="alert alert-danger">' . $errorMessage . '</div>']);
        // }

        if (Cache::has('transaction_check:' . $transaction->id)) {
            // Handle transaction already in progress
            $errorMessage = isset($data['lang']) && $data['lang'] == 'ar' ? 'المعاملة جارية بالفعل. انتظر من فضلك.' : 'Transaction already in progress. Please wait.';
            return response()->json([
                'message' => "<div class='alert alert-danger'>$errorMessage</div>",
                'status' => 'fail',
                'code' => 400
            ]);
        }

        // Set cache for transaction check
        Cache::put('transaction_check:' . $transaction->id, true, now()->addSeconds(60));

        // $transaction->update([
        //     'username' => $data['user_name'],
        // ]);

        try {
            return $this->handleIntegration($transaction, $data);
        } catch (\Throwable $th) {
            // Handle exceptions
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    // public function payment_link_check(Request $request)
    // {
    //     $request->validate([
    //         'phone' => 'required|numeric',
    //         'amount' => 'required|numeric',
    //         'user_name' => 'required|string',
    //         'store_id' => 'required|numeric',
    //         'lang' => 'string',
    //     ]);

    //     $data = $request->all();
    //     $phone = $data['phone'];
    //     $store_id = $data['store_id'];
    //     $amount = $data['amount'];
    //     $statuses = [0, 1, 4];

    //     $transaction = transactions::where('from', $phone)
    //         ->where('store_id', $store_id)
    //         ->whereIn('status', $statuses)
    //         ->where('amount', $amount)
    //         ->first();

    //     if (!$transaction) {
    //         Log::info(['transactions' => $transaction, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'mismatched_information']);
    //         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //             return response()->json(['message' => '<div class="alert alert-danger">معلومات غير متطابقة. حاول مرة أخرى!</div>']);
    //         } else {
    //             return response()->json(['message' => '<div class="alert alert-danger">Mismatched information. Try again!</div>']);
    //         }
    //     } else {
    //         if (Cache::has('transaction_check:' . $transaction->id)) {
    //             if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                 return response()->json(['message' => '<div class="alert alert-danger">المعاملة جارية بالفعل. انتظر من فضلك.</div>']);
    //             } else {
    //                 return response()->json(['message' => '<div class="alert alert-danger">Transaction already in progress. Please wait.</div>']);
    //             }
    //         }

    //         Cache::put('transaction_check:' . $transaction->id, true, now()->addSeconds(60));

    //         $transaction->update([
    //             'username' => $data['user_name'],
    //         ]);
    //         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name']]);
    //         try {
    //             if ($transaction->stores->actions == 1) {
    //                 if ($transaction->stores->integration == '2') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;
    //                     $response = Tiny::addPayment(
    //                         $transaction->from,
    //                         $transaction->stores->domain,
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                         $transaction->transaction_id,
    //                         $transaction->stores->afc,
    //                         $rate
    //                     );
    //                     $result_body = $response->json();
    //                     if ($result_body['status'] == "fail") {
    //                         if ($result_body['error'] == 'bad_username') {
    //                             $transaction->update([
    //                                 'status' => 0,
    //                             ]);
    //                             Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         } else {
    //                             $transaction->update([
    //                                 'status' => 4,
    //                                 'response' => $result_body,
    //                             ]);
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonus(
    //                                 $transaction->providers->name,
    //                                 $transaction->stores->domain,
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                                 $transaction->id,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     }
    //                 }
    //                 if ($transaction->stores->integration == '3') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;
    //                     $response = Tiny::addPaymentSoc(
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                     );
    //                     $result_body = $response->json();
    //                     if ($result_body['ok'] == "true") {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonusSoc(
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 4,
    //                         ]);
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
    //                     }
    //                 }
    //                 if ($transaction->stores->integration == '4') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;
    //                     $response = Tiny::addPaymentAmazing(
    //                         $transaction->from,
    //                         $transaction->stores->domain,
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                         $transaction->transaction_id,
    //                         $transaction->stores->afc,
    //                         $rate
    //                     );
    //                     $result_body = $response->json();
    //                     if ($result_body['status'] == "fail") {
    //                         if ($result_body['error'] == 'bad_username') {
    //                             $transaction->update([
    //                                 'status' => 0,
    //                             ]);
    //                             Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         } else {
    //                             $transaction->update([
    //                                 'status' => 4,
    //                                 'response' => $result_body,
    //                             ]);
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonusAmazing(
    //                                 $transaction->providers->name,
    //                                 $transaction->from,
    //                                 $transaction->stores->domain,
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                                 $transaction->id,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     }
    //                 }
    //                 if ($transaction->stores->integration == '5') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;
    //                     $response = Tiny::addPaymentCookies(
    //                         $transaction->from,
    //                         $transaction->stores->domain,
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                         $transaction->transaction_id,
    //                         $transaction->stores->afc,
    //                         $rate
    //                     );
    //                     $result_body = $response->json();
    //                     if ($result_body['success'] == false) {
    //                         if ($result_body['error_message'] == 'Your request was made with invalid credentials.') {
    //                             $store = stores::where('id', $transaction->stores->id)->first();
    //                             $store->update([
    //                                 'key' => 'invalid_credentials',
    //                             ]);
    //                             return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error_message'] . '</div>']);
    //                         }
    //                         if ($result_body['error_message'] == 'User ' . $data['user_name'] . ' not found') {
    //                             $transaction->update([
    //                                 'status' => 0,
    //                             ]);
    //                             Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
    //                         } else {
    //                             $transaction->update([
    //                                 'status' => 4,
    //                                 'response' => $result_body,
    //                             ]);
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error_message'] . '</div>']);
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonusCookies(
    //                                 $transaction->providers->name,
    //                                 $transaction->stores->domain,
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                                 $transaction->id,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     }
    //                 }
    //                 if ($transaction->stores->integration == '6') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;

    //                     $response = Tiny::addPaymentCustom(
    //                         $transaction->from,
    //                         $transaction->stores->domain,
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                         $transaction->transaction_id,
    //                         $transaction->stores->afc,
    //                         $rate
    //                     );

    //                     $result_body = $response->json();
    //                     if ($result_body['status'] == 'fail') {
    //                         if ($result_body['error'] == 'User not found') {
    //                             $transaction->update([
    //                                 'status' => 0,
    //                             ]);
    //                             Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         } else {
    //                             $transaction->update([
    //                                 'status' => 4,
    //                                 'response' => $result_body,
    //                             ]);
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonusCustom(
    //                                 $transaction->providers->name,
    //                                 $transaction->stores->domain,
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                                 $transaction->id,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     }
    //                 }
    //                 if ($transaction->stores->integration == '7') {
    //                     $rate = Tiny::currencyRate($transaction->stores);
    //                     $amount = $data['amount'] / $rate;

    //                     $response = Tiny::addPaymentCookiesC(
    //                         $transaction->from,
    //                         $transaction->stores->domain,
    //                         $transaction->stores->key,
    //                         $data['user_name'],
    //                         $amount,
    //                         $transaction->transaction_id,
    //                         $transaction->stores->afc,
    //                         $rate
    //                     );

    //                     $result_body = $response->json();

    //                     // dd($result_body['success']);
    //                     if ($result_body['s'] == 'success') {
    //                         if ($result_body['m'] == 'User not found') {
    //                             $transaction->update([
    //                                 'status' => 0,
    //                             ]);
    //                             Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
    //                         } else {
    //                             $transaction->update([
    //                                 'status' => 4,
    //                                 'response' => $result_body,
    //                             ]);
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
    //                         return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error_message'] . '</div>']);
    //                     } else {
    //                         $transaction->update([
    //                             'status' => 3,
    //                         ]);
    //                         // Check if bonus is enabled
    //                         if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
    //                             // Calculate bonus amount based on the specified percentage
    //                             $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

    //                             // Send a bonus request
    //                             $response = Tiny::addBonusCookiesC(
    //                                 $transaction->providers->name,
    //                                 $transaction->stores->domain,
    //                                 $transaction->stores->key,
    //                                 $data['user_name'],
    //                                 $bonus_amount / $transaction->stores->currency,
    //                                 $transaction->id,
    //                             );
    //                         }
    //                         Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
    //                         if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                             return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
    //                         } else {
    //                             return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 if ($transaction) {
    //                     $transaction->update([
    //                         'status' => 0,
    //                     ]);
    //                     return response()->json(['message' => '<div class="alert alert-warning">Success transaction , is pending approval.</div>']);
    //                     if (isset($data['lang']) && $data['lang'] == 'ar') {
    //                         return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح , في انتظار الموافقة</div>']);
    //                     } else {
    //                         return response()->json(['message' => '<div class="alert alert-primary">Success transaction , is pending approval.</div>']);
    //                     }
    //                 }
    //             }
    //         } catch (\Throwable $th) {
    //             return redirect()->back()->with('error', $th->getMessage());
    //         }
    //     }
    // }

    // BEGIN :: Functions handle Api
    public function check_token(Request $request)
    {
        $store = $request->attributes->get('store');
        if ($store->expiry == null || $store->expiry < Carbon::now()) {
            $store = stores::where('store_key', $store->store_key)->first();
            $store->update(['status' => 3]);
            return response()->json([
                'status' => false,
                'message' => 'Store is inactive. Please activate your store to start using it.',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'token' => $store->store_key,
            'name' => $store->name,
        ]);
    }

    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sim_number' => 'required|in:1,2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $store = $request->attributes->get('store');
        if ($store->expiry == null || $store->expiry < Carbon::now()) {
            $store = stores::where('store_key', $store->store_key)->first();
            $store->update(['status' => 3]);
            return response()->json([
                'status' => false,
                'error' => 'Store is inactive. Please activate your store to start using it.',
            ], 401);
        }


        if ($store->sim1 == false && $request->sim_number == 1) {
            return response()->json([
                'status' => false,
                'error' => 'SIM1 is inactive. Please activate it.',
            ], 401);
        }

        if ($store->sim2 == false && $request->sim_number == 2) {
            return response()->json([
                'status' => false,
                'error' => 'SIM2 is inactive. Please activate it.',
            ], 401);
        }

        Log::info(['msg_body' => $request->msg_body, 'provider' => $request->provider, 'sim_number' => $request->sim_number]);
        try {
            $extracted_data = Tiny::extractDataByArrayToken($request->msg_body, $request->provider);
            // dd($extracted_data);
            if (!$extracted_data) {
                return response()->json([
                    'status' => false,
                    'error' => 'An error occurred while processing the message',
                ]);
            }

            $transactionNumberKey = 'transaction_number:' . $extracted_data['transaction_number'];
            if (Redis::exists($transactionNumberKey)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaction already exists.',
                ]);
            }
            Redis::set($transactionNumberKey, $extracted_data['transaction_number']);
            Log::info(['text' => $request->msg_body, 'type' => 'Api', 'extracted_data' => $extracted_data]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'An error occurred while processing the message',
            ]);
        }

        $provider_id = Redis::get('provider:' . $request->provider);
        if (!$provider_id) {
            $provider = Providers::firstOrCreate(
                ['name' => $request->provider],
                ['status' => 1]
            );
            Redis::set('provider:' . $request->provider, $provider->id);
            $provider_id = $provider->id;
        }

        try {
            Transactions::create([
                'user_id' => $store->user_id,
                'store_id' => $store->id,
                'transaction_id' => $extracted_data['transaction_number'],
                'from' => $extracted_data['phone_number'],
                'name' => $extracted_data['name'],
                'amount' => $extracted_data['amount'],
                'balance' => $extracted_data['balance'],
                'provider_id' => $provider_id,
                'sim_number' => $request->sim_number,
            ]);
            Log::info([
                'message' => 'Transaction created',
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return response()->json([
                    'status' => false,
                    'error' => 'Transaction already exists',
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'transaction created',
        ]);
    }

    public function device_update(Request $request)
    {
        $store = $request->attributes->get('store');
        $storea = stores::where('store_key', $store->store_key)->first();
        $storea->update(['device' => $request->status]);
        return response()->json([
            'status' => $request->status ? true : false,
        ]);
    }
    // END :: Functions handle Api


    private function CheckBounsStatus($transaction, $data)
    {
        if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
            return true;
        }
    }

    private function handleIntegration($transaction, $data)
    {
        // Implementation for integration
        $result_body = $this->processPayment($transaction, $data);

        // Check if bonus is enabled
        if ($this->CheckBounsStatus($transaction, $data)) {
            $result_body = $this->processBouns($transaction, $data);
        }
        // dd($result_body);
        switch ($transaction->stores->integration) {
            case '2':
                // Handle integration type 2
                return $this->handleResponseType2($transaction, $data, $result_body);
            case '3':
                // Handle integration type 3
                return $this->handleResponseType3($transaction, $data, $result_body);
            case '4':
                // Handle integration type 4
                return $this->handleResponseType4($transaction, $data, $result_body);
            case '5':
                // Handle integration type 5
                return $this->handleResponseType5($transaction, $data, $result_body);
            case '6':
                // Handle integration type 6
                return $this->handleResponseType6($transaction, $data, $result_body);
            default:
                // Handle default case
                return response()->json(['message' => 'Unsupported integration type'], 400);
        }
    }

    // Common method to process payment
    private function processPayment($transaction, $data)
    {
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;
        switch ($transaction->stores->integration) {
            case '2':
                // Handle integration type 2
                return $this->handlePaymentType2($transaction, $data, $rate, $amount);
            case '3':
                // Handle integration type 3
                return $this->handlePaymentType3($transaction, $data, $rate, $amount);
            case '4':
                // Handle integration type 4
                return $this->handlePaymentType4($transaction, $data, $rate, $amount);
            case '5':
                // Handle integration type 5
                return $this->handlePaymentType5($transaction, $data, $rate, $amount);
            case '6':
                // Handle integration type 6
                return $this->handlePaymentType6($transaction, $data, $rate, $amount);
            case '7':
                // Handle integration type 7
                return $this->handlePaymentType7($transaction, $data, $rate, $amount);
            default:
                // Handle default case
                return response()->json(['message' => 'Unsupported integration type'], 400);
        }
    }

    // Common method to process bouns
    private function processBouns($transaction, $data)
    {
        $rate = Tiny::currencyRate($transaction->stores);
        $bonus_amount = Tiny::BounsAmount($transaction->stores, $data);
        $amount = $bonus_amount / $rate;

        switch ($transaction->stores->integration) {
            case '2':
                // Handle integration type 2
                return $this->handleBounsType2($transaction, $data, $amount);
            case '3':
                // Handle integration type 3
                return $this->handleBounsType3($transaction, $data, $amount);
            case '4':
                // Handle integration type 4
                return $this->handleBounsType4($transaction, $data, $amount);
            case '5':
                // Handle integration type 5
                return $this->handleBounsType5($transaction, $data, $amount);
            case '6':
                // Handle integration type 6
                return $this->handleBounsType6($transaction, $data, $amount);
            default:
                // Handle default case
                return response()->json(['message' => 'Unsupported integration type'], 400);
        }
    }

    // Common method to handle integration failure
    private function handleFailedPayment($transaction, $data, $result_body)
    {
        // Handle failure case
        // Update transaction status
        // Log error
        // Format response using responseFormatter function
        return $this->jsonResponseFormatter('fail', $result_body['error'], $data['lang'] ?? 'en');
    }

    // Common method to handle integration success
    private function handleSuccessfulPayment($transaction, $data, $result_body)
    {
        // Handle success case
        // Update transaction status
        $transaction->update([
            'username' => $data['user_name'] ?? null,
            'status' => 3,
        ]);
        // Log success
        // Format response using responseFormatter function
        return $this->jsonResponseFormatter('success', $result_body, $data['lang'] ?? 'en');
    }

    // Response formatter for JSON response
    private function jsonResponseFormatter($status, $body, $lang)
    {
        if ($lang == 'en') {
            return $this->englishResponseFormatter($status, $body);
        } else {
            return $this->arabicResponseFormatter($status, $body);
        }
    }


    // Response formatter for English response
    private function englishResponseFormatter($status, $body)
    {
        if ($status == 'fail') {
            return response()->json([
                'message' => '<div class="alert alert-danger">Error: ' . $body . '</div>',
                'status' => 'fail',
                'code' => 400
            ]);
        } else {
            return response()->json([
                'message' => '<div class="alert alert-primary">Success Transaction</div>',
                'status' => 'success',
                'code' => 200
            ]);
        }
    }

    // Response formatter for Arabic response
    private function arabicResponseFormatter($status, $body)
    {
        if ($status == 'fail') {
            return response()->json([
                'message' => '<div class="alert alert-danger">خطأ: ' . $body . '</div>',
                'status' => 'fail',
                'code' => 400
            ]);
        } else {
            return response()->json([
                'message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>',
                'status' => 'success',
                'code' => 200
            ]);
        }
    }

    // BEGIN :: Functions handle Payment Type

    private function handlePaymentType2($transaction, $data, $rate, $amount)
    {
        $response = Tiny::addPayment(
            $transaction->from,
            $transaction->name,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );
        return $response->json();
    }

    private function handlePaymentType3($transaction, $data, $rate, $amount)
    {
        $response = Tiny::addPaymentSoc(
            $transaction->stores->key,
            $data['user_name'],
            $amount,
        );

        return $response->json();
    }

    private function handlePaymentType4($transaction, $data, $rate, $amount)
    {
        $response = Tiny::addPaymentAmazing(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );

        return $response->json();
    }

    private function handlePaymentType5($transaction, $data, $rate, $amount)
    {
        $response = Tiny::addPaymentCookies(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );
        return $response->json();
    }

    private function handlePaymentType6($transaction, $data, $rate, $amount)
    {
        $response = Tiny::addPaymentCustom(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );

        return $response->json();
    }

    private function handlePaymentType7($transaction, $data, $rate, $amount)
    {
        return true;
    }



    // END :: Functions handle Payment Type


    // BEGIN :: Functions handle Bouns Type

    private function handleBounsType2($transaction, $data, $amount)
    {
        $response = Tiny::addBonus(
            $transaction->providers->name,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->id,
        );
        return $response->json();
    }

    private function handleBounsType3($transaction, $data, $amount)
    {
        $response = Tiny::addBonusSoc(
            $transaction->stores->key,
            $data['user_name'],
            $amount,
        );
        return $response->json();
    }

    private function handleBounsType4($transaction, $data, $amount)
    {
        $response = Tiny::addBonusAmazing(
            $transaction->providers->name,
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->id,
        );
        return $response->json();
    }

    private function handleBounsType5($transaction, $data, $amount)
    {
        $response = Tiny::addBonusCookies(
            $transaction->providers->name,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->id,
        );
        return $response->json();
    }

    private function handleBounsType6($transaction, $data, $amount)
    {
        $response = Tiny::addBonusCustom(
            $transaction->providers->name,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->id,
        );
        return $response->json();
    }

    // END :: Functions handle Bouns Type

    // BEGIN :: Functions handle Response Type

    private function handleResponseType2($transaction, $data, $result_body)
    {
        if ($result_body['status'] == "fail") {
            return $this->handleFailedPayment($transaction, $data, $result_body);
        } else {
            return $this->handleSuccessfulPayment($transaction, $data, $result_body);
        }
    }
    private function handleResponseType3($transaction, $data, $result_body)
    {
        if (isset($result_body['ok']) && $result_body['ok'] == true) {
            return $this->handleSuccessfulPayment($transaction, $data, $result_body);
        } else {
            return $this->handleFailedPayment($transaction, $data, $result_body);
        }
    }

    private function handleResponseType4($transaction, $data, $result_body)
    {
        if ($result_body['status'] == "fail") {
            return $this->handleFailedPayment($transaction, $data, $result_body);
        } else {
            return $this->handleSuccessfulPayment($transaction, $data, $result_body);
        }
    }

    private function handleResponseType5($transaction, $data, $result_body)
    {
        if ($result_body['success'] == false) {
            return $this->jsonResponseFormatter('fail', $result_body['error_message'], $data['lang'] ?? 'en');
        } else {
            return $this->handleSuccessfulPayment($transaction, $data, $result_body);
        }
    }

    private function handleResponseType6($transaction, $data, $result_body)
    {
        if ($result_body['status'] == "fail") {
            return $this->handleFailedPayment($transaction, $data, $result_body);
        } else {
            return $this->handleSuccessfulPayment($transaction, $data, $result_body);
        }
    }



    // END :: Functions handle Response Type



    // BEGIN :: Functions handle Integration Type

    private function handleIntegrationType2($transaction, $data)
    {
        // Implementation for integration type 2
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;
        $response = Tiny::addPayment(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );
        $result_body = $response->json();
        if ($result_body['status'] == "fail") {
            if ($result_body['error'] == 'bad_username') {
                $transaction->update([
                    'status' => 0,
                ]);
                Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            } else {
                $transaction->update([
                    'status' => 4,
                    'response' => $result_body,
                ]);
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
        } else {
            $transaction->update([
                'status' => 3,
            ]);
            // Check if bonus is enabled
            if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
                // Calculate bonus amount based on the specified percentage
                $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

                // Send a bonus request
                $response = Tiny::addBonus(
                    $transaction->providers->name,
                    $transaction->stores->domain,
                    $transaction->stores->key,
                    $data['user_name'],
                    $bonus_amount / $transaction->stores->currency,
                    $transaction->id,
                );
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
            if (isset($data['lang']) && $data['lang'] == 'ar') {
                return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
            } else {
                return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
            }
        }
    }

    private function handleIntegrationType3($transaction, $data)
    {
        // Implementation for integration type 3
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;
        $response = Tiny::addPaymentSoc(
            $transaction->stores->key,
            $data['user_name'],
            $amount,
        );
        $result_body = $response->json();
        if ($result_body['ok'] == "true") {
            $transaction->update([
                'status' => 3,
            ]);
            // Check if bonus is enabled
            if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
                // Calculate bonus amount based on the specified percentage
                $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

                // Send a bonus request
                $response = Tiny::addBonusSoc(
                    $transaction->stores->key,
                    $data['user_name'],
                    $bonus_amount / $transaction->stores->currency,
                );
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
            if (isset($data['lang']) && $data['lang'] == 'ar') {
                return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
            } else {
                return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
            }
        } else {
            $transaction->update([
                'status' => 4,
            ]);
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
        }
    }

    private function handleIntegrationType4($transaction, $data)
    {
        // Implementation for integration type 4
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;
        $response = Tiny::addPaymentAmazing(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );
        $result_body = $response->json();
        if ($result_body['status'] == "fail") {
            if ($result_body['error'] == 'bad_username') {
                $transaction->update([
                    'status' => 0,
                ]);
                Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            } else {
                $transaction->update([
                    'status' => 4,
                    'response' => $result_body,
                ]);
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
        } else {
            $transaction->update([
                'status' => 3,
            ]);
            // Check if bonus is enabled
            if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
                // Calculate bonus amount based on the specified percentage
                $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

                // Send a bonus request
                $response = Tiny::addBonusAmazing(
                    $transaction->providers->name,
                    $transaction->from,
                    $transaction->stores->domain,
                    $transaction->stores->key,
                    $data['user_name'],
                    $bonus_amount / $transaction->stores->currency,
                    $transaction->id,
                );
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
            if (isset($data['lang']) && $data['lang'] == 'ar') {
                return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
            } else {
                return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
            }
        }
    }

    private function handleIntegrationType5($transaction, $data)
    {
        // Implementation for integration type 5
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;
        $response = Tiny::addPaymentCookies(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );
        $result_body = $response->json();
        if ($result_body['success'] == false) {
            if ($result_body['error_message'] == 'Your request was made with invalid credentials.') {
                $store = stores::where('id', $transaction->stores->id)->first();
                $store->update([
                    'key' => 'invalid_credentials',
                ]);
                return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error_message'] . '</div>']);
            }
            if ($result_body['error_message'] == 'User ' . $data['user_name'] . ' not found') {
                $transaction->update([
                    'status' => 0,
                ]);
                Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
            } else {
                $transaction->update([
                    'status' => 4,
                    'response' => $result_body,
                ]);
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error_message']]);
            return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error_message'] . '</div>']);
        } else {
            $transaction->update([
                'status' => 3,
            ]);
            // Check if bonus is enabled
            if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
                // Calculate bonus amount based on the specified percentage
                $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

                // Send a bonus request
                $response = Tiny::addBonusCookies(
                    $transaction->providers->name,
                    $transaction->stores->domain,
                    $transaction->stores->key,
                    $data['user_name'],
                    $bonus_amount / $transaction->stores->currency,
                    $transaction->id,
                );
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
            if (isset($data['lang']) && $data['lang'] == 'ar') {
                return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
            } else {
                return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
            }
        }
    }

    private function handleIntegrationType6($transaction, $data)
    {
        // Implementation for integration type 6
        $rate = Tiny::currencyRate($transaction->stores);
        $amount = $data['amount'] / $rate;

        $response = Tiny::addPaymentCustom(
            $transaction->from,
            $transaction->stores->domain,
            $transaction->stores->key,
            $data['user_name'],
            $amount,
            $transaction->transaction_id,
            $transaction->stores->afc,
            $rate
        );

        $result_body = $response->json();
        if ($result_body['status'] == 'fail') {
            if ($result_body['error'] == 'User not found') {
                $transaction->update([
                    'status' => 0,
                ]);
                Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            } else {
                $transaction->update([
                    'status' => 4,
                    'response' => $result_body,
                ]);
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'error' => $result_body['error']]);
            return response()->json(['message' => '<div class="alert alert-danger">Error : ' . $result_body['error'] . '</div>']);
        } else {
            $transaction->update([
                'status' => 3,
            ]);
            // Check if bonus is enabled
            if ($transaction->stores->bonus == True && $data['amount'] >= $transaction->stores->bonus_from) {
                // Calculate bonus amount based on the specified percentage
                $bonus_amount = $data['amount'] * ($transaction->stores->bonus_amount / 100);

                // Send a bonus request
                $response = Tiny::addBonusCustom(
                    $transaction->providers->name,
                    $transaction->stores->domain,
                    $transaction->stores->key,
                    $data['user_name'],
                    $bonus_amount / $transaction->stores->currency,
                    $transaction->id,
                );
            }
            Log::info(['transactions' => $transaction->id, 'amount' => $data['amount'], 'phone' => $data['phone'], 'store_id' => $data['store_id'], 'username' => $data['user_name'], 'status' => 'success']);
            if (isset($data['lang']) && $data['lang'] == 'ar') {
                return response()->json(['message' => '<div class="alert alert-primary">تمت العملية بنجاح</div>']);
            } else {
                return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
            }
        }
    }

    private function handleDefaultCase($transaction, $data)
    {
        // Implementation for default case
        if ($transaction) {
            $transaction->update([
                'status' => 0,
            ]);
            $message = isset($data['lang']) && $data['lang'] == 'ar' ? 'تمت العملية بنجاح , في انتظار الموافقة' : 'Success transaction , is pending approval.';
            return response()->json(['message' => '<div class="alert alert-warning">' . $message . '</div>']);
        }
    }

    // END :: Functions handle Integration Type


}
