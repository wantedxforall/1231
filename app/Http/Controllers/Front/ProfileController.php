<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $countries = config('countries.en');
        return view('front.profile.profile', compact('user','countries'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'company' => 'nullable',
            'phone' => 'nullable',
            'site' => 'nullable',
            'country' => 'nullable',
            'time_zone' => 'nullable',
        ]);

        $user = auth()->user();
        $user->update($request->only(['name', 'last_name', 'email' , 'company', 'phone', 'site', 'country','time_zone']));
        return redirect()->route('front.profile')->with('success', 'تم التعديل بنجاح');
    }

    public function changePasswordPost(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // dd($request->all());

        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            Session::flush();
            Session::regenerate();
            return redirect()->route('front.profile')->with('success', 'تم تغيير كلمة السر بنجاح');
        }
        return redirect()->back()->with('error', 'كلمة السر القديمة غير متطابقة مع بيناتنا برجاء اعادة المحاولة');
    }



}
