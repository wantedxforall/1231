<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payments::orderBy('id', 'desc')->paginate(paginate());
        return view('admin.payments.index', compact('payments'));
    }
}
