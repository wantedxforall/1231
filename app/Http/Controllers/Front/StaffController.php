<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function index()
    {
        return view('front.staff');
    }
}
