<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\front\plans;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = plans::orderBy('id', 'desc')->paginate(10);
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(plans $plan)
    {
        $plan = null;
        return view('admin.plans.create' , compact('plan'));
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
            'min' => 'required',
            'max' => 'required',
            'cost' => 'required',
        ]);
        $data = $request->only([
            'name',
            'min',
            'max',
            'cost',
        ]);
        $data['status'] = $request->status ? 1 : 0;
        plans::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
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
    public function edit(plans $plan)
    {
        return view('admin.plans.edit' , compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, plans $plan)
    {
        $request->validate([
            'name' => 'required',
            'min' => 'required',
            'max' => 'required',
            'cost' => 'required',
        ]);
        $data = $request->only([
            'name',
            'min',
            'max',
            'cost',
        ]);
        $data['status'] = $request->status ? 1 : 0;
        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(plans $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', __('Plan deleted successfully.'));
    }
}
