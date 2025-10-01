<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Helpers\Tiny;
use App\Models\Providers;
use App\Models\front\stores;
use Illuminate\Http\Request;
use App\Models\front\message;
use App\Exports\TransactionExport;
use App\Models\front\transactions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redis;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions()->with(['providers','stores'])->orderBy('id', 'desc');
        $providerss = Providers::where('status', 1)->pluck('name');
        $storess = auth()->user()->stores()->where('status', 1)->get();
        $startDate = null;
        $endDate = null;
        $fromSlider = 0;
        $toSlider = 0;

        if (request()->has('search')) {
            $searchTerm = '%' . request('search') . '%';
            $transactions = $transactions->where(function ($query) use ($searchTerm) {
                $query->where('transaction_id', 'like', $searchTerm)->orWhere('from', 'like', $searchTerm)->orWhere('username', 'like', $searchTerm)->where('user_id', auth()->id());
            });
        }
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

        $transactions = $transactions->paginate(10);
        $maxAmount = auth()->user()->transactions()->max('amount');

        return view('front.transactions', compact('transactions', 'providerss','storess','startDate', 'endDate', 'maxAmount', 'fromSlider', 'toSlider'));
    }

    public function create()
    {
        return view('front.transactions.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'msg_body' => 'required',
            'provider' => 'required',
            'store' => 'required',
        ]);


        try {
            $extracted_data = Tiny::extractDataByArrayToken($request->msg_body, $request->provider);
            if (!$extracted_data) {
                return redirect()->route('front.transactions')->with('faill', 'An error occurred while processing the message');
            }

            $transactionNumberKey = 'transaction_number:' . $extracted_data['transaction_number'];
            if (Redis::exists($transactionNumberKey)) {
                return redirect()->route('front.transactions')->with('success', 'Transaction Already Exists');
            }

            Redis::set($transactionNumberKey, $extracted_data['transaction_number']);
            Log::info(['text' => $request->msg_body, 'type' => 'Api', 'extracted_data' => $extracted_data]);
        } catch (\Exception $e) {
            return redirect()->route('front.transactions')->with('faill', 'An error occurred while processing the message');
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
                'user_id' => Auth::id(),
                'store_id' => $request->store,
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
                return redirect()->route('front.transactions')->with('faill', 'Transaction Already Exists');
            }
        }

        Log::info([
            'message' => 'transaction created',
        ]);
        return redirect()->route('front.transactions')->with('success', 'Transaction added successfully');
    }

    public function approve(Transactions $transaction)
    {
        try {
            if ($transaction->stores->integration == '2') {
                $amount = $transaction->amount / $transaction->stores->currency;
                $Post_api = Http::post('https://' . $transaction->stores->domain . '/adminapi/v1', [
                    'key' => $transaction->stores->key,
                    'action' => 'addPayment',
                    'username' => $transaction->username,
                    'amount' => round($amount, 2),
                    'details' => $transaction->transaction_id,
                    'affiliate_commission' => $transaction->stores->afc,
                ]);
                $result_body = $Post_api->json();
                if ($result_body['status'] == "fail") {
                    if ($result_body['error'] == 'bad_username') {
                        $transaction->update([
                            'status' => 0,
                            'response' => $result_body,
                        ]);
                    } else {
                        $transaction->update([
                            'status' => 4,
                            'response' => $result_body,
                        ]);
                    }
                } else {
                    $transaction->update([
                        'status' => 3,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            $transaction->update([
                'status' => 4,
            ]);
            return redirect()->back()->with('error', $th->getMessage());
        }

        $transaction->refresh();
        return redirect()->back()->with('success', 'Transaction has been approved');
    }

    public function reject(Transactions $transaction)
    {
        $transaction->update([
            'status' => 2,
        ]);
        $transaction->refresh();

        return redirect()->back()->with('success', 'Transaction has been rejected');
    }

    public function resend(Transactions $transaction)
    {
        try {
            if ($transaction->stores->integration == '2') {
                $amount = $transaction->amount / $transaction->stores->currency;
                $Post_api = Http::post('https://' . $transaction->stores->domain . '/adminapi/v1', [
                    'key' => $transaction->stores->key,
                    'action' => 'addPayment',
                    'username' => $transaction->username,
                    'amount' => round($amount, 2),
                    'details' => $transaction->transaction_id,
                    'affiliate_commission' => $transaction->stores->afc,
                ]);
                $result_body = $Post_api->json();
                if ($result_body['status'] == "fail") {
                    if ($result_body['error'] == 'bad_username') {
                        $transaction->update([
                            'status' => 1,
                            'response' => $result_body,
                        ]);
                    } else {
                        $transaction->update([
                            'status' => 4,
                            'response' => $result_body,
                        ]);
                    }
                } else {
                    $transaction->update([
                        'status' => 3,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        $transaction->refresh();

        return redirect()->back()->with('success', 'Transaction has been resend');
    }

    public function destroy(Transactions $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction has been delete');
    }
    public function export(Request $request, $storeId = null)
    {
        // dd($request->all());
        if ($request->has('mode') && $request->get('mode') == 'all') {
            $transactions = auth()->user()->transactions;
        } else {
            $data = $request->only([
                'status', 'providers', 'date', 'fromslider', 'toslider', 'username', 'from', 'transaction',
            ]);
            $transactions = Tiny::transactionsFilter($data, $storeId);
        }
        if ($request->has('format')) {
            if ($request->format == 'excel') {
                $filename = time() . '-Transactions.xlsx';
                $format = \Maatwebsite\Excel\Excel::XLSX;
            } elseif ($request->format == 'csv') {
                $filename = time() . '-Transactions.csv';
                $format = \Maatwebsite\Excel\Excel::CSV;
            } elseif ($request->format == 'pdf') {
                $filename = time() . '-Transactions.pdf';
                $format = \Maatwebsite\Excel\Excel::DOMPDF;
            } else {
                $filename = null;
                $format = null;
            }
        }
        if ($transactions && !is_null($filename) && !is_null($format)) {
            return Excel::download(new TransactionExport($transactions), $filename, $format);
        }
        return redirect()->back()->with('success', 'Transaction has been resend');
    }
}
