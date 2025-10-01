<?php
namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Helpers\Tiny;
use App\Helpers\Whatsapp;
use App\Models\Providers;
use App\Models\front\invoices;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $transactions = auth()->user()->transactions()->with(['providers'])->orderBy('id', 'desc')->paginate(5);
        return view('front.index' , compact('transactions'));
    }

    public function not_found()
    {
        return view('front.layouts.404');
    }
}
