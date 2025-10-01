<?php

namespace App\Http\Requests\front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoresReuest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return Auth::user()->role == 'admin';
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'domain'=>'required|regex:/^(?:(?!www\.)[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/',
            'logo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'integration'=>'required',
            'currency'=>'required',
            // 'key'=>'required',
            // 'actions'=>'required',
            // 'afc'=>'required',
        ];
    }
}
