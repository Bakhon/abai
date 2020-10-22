<?php

namespace App\Http\Controllers\AntiCrisis;

use App\Http\Controllers\Controller;
use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use App\Models\AntiRefs\AntiEcoTwo;
use Illuminate\Http\Request;

class AntiEcoTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antiecotwo = AntiEcoTwo::latest()->with('scfa')->with('company')->paginate(5);

        return view('antiecotwo.index',compact('antiecotwo'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        return view('antiecotwo.create',compact('sc_fa', 'company'));
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
            'sc_fa' => 'required',
            'company_id' => 'required',
            'oil_cost' => 'required',
            'oil_cost_exp_one' => 'required',
            'oil_cost_exp_two' => 'required',
            'oil_cost_exp_three' => 'required',
            'oil_cost_ins_one' => 'required',
            'oil_cost_ins_two' => 'required',
        ]);

        AntiEcoTwo::create($request->all());

        return redirect()->route('antiecotwo.index')->with('success',__('app.created'));
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
    public function edit($id)
    {
        $row = AntiEcoTwo::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        return view('antiecotwo.edit',compact('row', 'sc_fa', 'company'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $AntiEcoTwo=AntiEcoTwo::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'oil_cost' => 'required',
            'oil_cost_exp_one' => 'required',
            'oil_cost_exp_two' => 'required',
            'oil_cost_exp_three' => 'required',
            'oil_cost_ins_one' => 'required',
            'oil_cost_ins_two' => 'required',
        ]);

        $AntiEcoTwo->update($request->all());

        return redirect()->route('antiecotwo.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = AntiEcoTwo::find($id);
        $row->delete();

        return redirect()->route('antiecotwo.index')->with('success',__('app.deleted'));
    }
}
