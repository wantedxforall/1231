<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Tiny;
use App\Models\Option;
use App\Models\front\plans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\front\stores;

class OptionController extends Controller
{
    public function index()
    {
        $group = request('group', 0);
        $alloptions = Option::orderby('sort')->where('group', $group)->get();
        $plans = plans::latest()->where('status', 1)->get();
        $stores = stores::where('status', 1)->get();
        return view('admin.options.index', compact('alloptions' , 'plans', 'stores'));
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            Tiny::option($key, $value);
        }
        return redirect()->back()->with('success', 'Option updated successfully');
    }
}
