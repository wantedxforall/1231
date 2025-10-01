<?php

namespace App\Http\Controllers\Admin;

use App\Models\Providers;
use App\Models\front\stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Providers::orderBy('id', 'desc')->paginate(10);
        return view('admin.providers.index', compact('providers'));
    }

    public function get_providers(stores $store)
    {
        $ids = $store->providers()->where('status', 1)->pluck('provider_id')->toArray();
        $providers = Providers::select(['id', 'name', 'start_body', 'icon'])->whereIn('id', $ids)->get();
        // foreach ($providers as $provider) {
        //     $data[] = [
        //         'name' => $provider->name,
        //         'full_icon_url' => $provider->full_icon_url,
        //         'status' => $provider->status,
        //     ];

        // }
        return response()->json($providers);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Providers $provider)
    {
        // $extracted_data = Tiny::extractData($provider->msg_body); // extract the data from the text
        return view('admin.providers.create', compact('provider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->only([
            'name',
            'msg_body',
            'start_body',
            'amount',
            'phone',
        ]);

        if ($request->has('notransaction') || $request->has('nophone')) {
            $data['transaction_no'] = null;
            $data['phone'] = null;
        } else {
            $data['transaction_no'] = $request->transaction_no;
            $data['phone'] = $request->phone;
        }
        $data['icon'] = Storage::put('providers', $request->file('icon'));
        $data['status'] = $request->status ? 1 : 0;

        // dd($data);

        Providers::create($data);

        return redirect()->route('admin.providers.index')->with('success', 'Provider created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Providers $provider)
    {
        // $extracted_data = Tiny::extractData($provider->msg_body); // extract the data from the text

        return view('admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Providers $provider)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);
        $data = $request->only([
            'name',
            'msg_body',
            'start_body',
            'amount',
            'phone',
        ]);
        // dd($request->all());
        if ($request->has('notransaction')) {
            $data['transaction_no'] = null;
        } else {
            $data['transaction_no'] = $request->transaction_no;
        }
        if ($request->has('nophone')) {
            $data['phone'] = null;
        } else {
            $data['phone'] = $request->phone;
        }
        if ($request->hasFile('icon')) {
            if ($provider->icon && !filter_var($provider->icon, FILTER_VALIDATE_URL)) {
                Storage::delete($provider->icon);
            }
            $data['icon'] = Storage::put('providers', $request->file('icon'));
        }
        $data['status'] = $request->status ? 1 : 0;
        $provider->update($data);

        return redirect()->route('admin.providers.index')->with('success', 'Provider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Providers $provider)
    {
        $provider->delete();
        return redirect()->route('admin.providers.index')->with('success', __('Provider deleted successfully.'));
    }

}
