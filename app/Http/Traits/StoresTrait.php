<?php
namespace App\Http\Traits;
use App\Models\front\stores;
trait StoresTrait {
    public function index() {
        $stores = stores::orderBy('id','desc')->paginate(4);
        return view('front.stores.index')->with(compact('stores'));
    }
}
