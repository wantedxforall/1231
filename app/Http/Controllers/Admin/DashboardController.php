<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Tiny;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
