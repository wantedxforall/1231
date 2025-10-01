<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\front\invoices;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('status') == "all" || !$request->has('status')) {
            $invoices = invoices::orderBy('id', 'desc')->paginate(paginate());
        } else {
            $invoices = invoices::where('status', $request->input('status'))
                ->orderBy('id', 'desc')
                ->paginate(paginate());
        }
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
