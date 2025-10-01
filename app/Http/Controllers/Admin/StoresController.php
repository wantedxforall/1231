<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;
use App\Models\front\stores;
use Illuminate\Http\Request;
use App\Models\front\invoices;
use App\Http\Controllers\Controller;

class StoresController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('status') && $request->input('status') !== 'all') {
            $stores = stores::where('status', $request->input('status'))
                ->orderBy('id', 'desc')
                ->paginate(paginate());
        } else {
            $stores = stores::orderBy('id', 'desc')->paginate(paginate());
        }
        return view('admin.stores.index', compact('stores'));
    }

    public function destroy($id){
        $store = stores::findOrFail($id);
        $invoices = invoices::where('store_id', $store->id)->get();
        foreach ($invoices as $invoice) {
            $payments = payments::where('invoice_id', $invoice->id)->get();
            $invoice->delete();
            foreach ($payments as $payment) {
                $payment->delete();
            }
        }
        $store->delete();
        return redirect()->route('admin.stores')->with('success', __('Store deleted successfully.'));
    }
}
