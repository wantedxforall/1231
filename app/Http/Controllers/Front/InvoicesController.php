<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Tiny;
use App\Models\Payments;
use App\Models\front\stores;
use Illuminate\Http\Request;
use App\Models\front\invoices;
use App\Jobs\RenewSubscriptionJob;
use App\Models\front\transactions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Nafezly\Payments\Classes\OpayPayment;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = invoices::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->paginate(paginate());
        return view('front.invoices.index', compact('invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($hash)
    {
        $invoice = invoices::where('hash', $hash)->first();
        if (!$invoice) {
            return redirect()->back()->with('fail');
        }

        return view('front.invoices.show', compact('invoice'));
    }

    public function payment(invoices $invoice)
    {
        try {
            $user = User::find($invoice->user_id);
            $payment = new OpayPayment();
            //pay function
            $response = $payment->pay(
                $invoice->amount,
                $invoice->user_id,
                $user->name,
                $user->last_name,
                $user->email,
                $user->phone,
                null
            );
            if (isset($response['payment_id'])) {
                $payments = Payments::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->amount,
                    'reference' => $response['payment_id'],
                    'method' => 'Opay',
                ]);
                return redirect($response['redirect_url']);
            } else {
                return redirect()->back()->with('fail');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', $e->getMessage());
        }
    }

    public function invoices_check(Request $request)
    {
        $hash = $request->input('hash');
        $phone = $request->input('phone');

        if (empty($hash) || empty($phone)) {
            return response()->json(['message' => '<div class="alert alert-danger">Invalid request!</div>']);
        }

        $invoice = invoices::where('hash', $hash)->first();

        if (!$invoice) {
            return response()->json(['message' => '<div class="alert alert-danger">Invoice not found!</div>']);
        }

        $options = options();

        $transaction = transactions::where('from', $phone)
            ->where('amount', $invoice->amount)
            ->where('status', 0)
            ->where('store_id', $options['default_store'])
            ->first();

        if (!$transaction) {
            return response()->json(['message' => '<div class="alert alert-danger">Mismatched information!</div>']);
        }

        $transaction->update(['status' => 3]);

        $invoice->update(['status' => 1]);
        $expiryDate = Carbon::parse($invoice->store->expiry)->addDays(30);
        $invoice->store->update([
            'next_month_invoice_id' => null,
            'expiry' => $expiryDate,
            'status' => 1,
        ]);

        return response()->json(['message' => '<div class="alert alert-primary">Success Transaction</div>']);
    }



    public function payment_verify(Request $request)
    {
        $payment = new OpayPayment();
        $response = $payment->verify($request);
        $payments = Payments::where('reference', $response['payment_id'])->first();
        $invoice = invoices::find($payments->invoice_id);
        if ($response['success'] == true) {
            if ($response['process_data']['data']['status'] == 'SUCCESS') {
                if ($payments->status == 'pending') {
                    $store = stores::findOrFail($invoice->store_id);
                    $payments->update([
                        'orderNo' => $response['process_data']['data']['orderNo'],
                        'paymentStatus' => $response['process_data']['data']['status'],
                        'code' => $response['process_data']['code'],
                        'message' => $response['process_data']['message'],
                        'status' => 'completed',
                    ]);
                    $invoice->update([
                        'status' => 1,
                    ]);
                    if ($store->next_month_invoice_id == null) {
                        $store->update([
                            'expiry' => Carbon::now()->addDays(30),
                            'status' => 1,
                            'next_month_invoice_id' => null,
                        ]);
                    } else {
                        $renewJob = new RenewSubscriptionJob($store);
                        $expiryDate = Carbon::parse($store->expiry)->toDateTimeString();
                        $expiryDateCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $expiryDate);
                        dispatch($renewJob)->delay($expiryDateCarbon);
                    }
                    return redirect()->route('front.invoices.show', $invoice->hash);
                } else {
                    return redirect()->route('front.invoices.show', $invoice->hash);
                }
            } else {
                $payments->update([
                    'orderNo' => $response['process_data']['data']['orderNo'],
                    'paymentStatus' => $response['process_data']['data']['status'],
                    'code' => $response['process_data']['data']['failureCode'],
                    'message' => $response['process_data']['data']['failureReason'],
                    'status' => 'canceled',
                ]);
                return redirect()->route('front.invoices.show', $invoice->hash);
            }
        } else {
            return redirect()->back()->with('fail');
        }
    }

    public function approve(invoices $invoice)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('front.home');
        }
        $invoice->update(['status' => 1]);
        $expiryDate = Carbon::parse($invoice->store->expiry)->addDays(30);
        $invoice->store->update([
            'next_month_invoice_id' => null,
            'expiry' => $expiryDate,
            'status' => 1,
        ]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice has been Approved');
    }

    public function cancel(invoices $invoice)
    {
        $invoice->update(['status' => 2]);
        $invoice->store->update(['status' => 2]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice has been Cancelled');
    }
}
