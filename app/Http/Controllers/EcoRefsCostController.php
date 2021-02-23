<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use App\Models\Refs\EcoRefsCost;
use Illuminate\Http\Request;

class EcoRefsCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ecorefscost = EcoRefsCost::latest()->with('scfa')->with('company')->paginate(5);

        return view('ecorefscost.index',compact('ecorefscost'))
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
        return view('ecorefscost.create',compact('sc_fa', 'company',));
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
            'date' => 'required',
            'variable' => 'required',
            'fix_noWRpayroll' => 'required',
            'fix_nopayroll' => 'required',
            'fix' => 'required',
            'gaoverheads' => 'required',
            'wr_nopayroll' => 'required',
            'wr_payroll' => 'required',
            'wo' => 'required',
        ]);

        EcoRefsCost::create($request->all());

        return redirect()->route('ecorefscost.index')->with('success',__('app.created'));
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
        $row = EcoRefsDiscontCoefBar::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();

        return view('ecorefscost.edit',
            compact('sc_fa', 'row', 'company'));

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
        $EcoRefsCost=EcoRefsCost::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'date' => 'required',
            'variable' => 'required',
            'fix_noWRpayroll' => 'required',
            'fix_nopayroll' => 'required',
            'fix' => 'required',
            'gaoverheads' => 'required',
            'wr_nopayroll' => 'required',
            'wr_payroll' => 'required',
            'wo' => 'required',
        ]);

        $EcoRefsCost->update($request->all());

        return redirect()->route('ecorefscost.index')->with('success',__('app.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsCost::find($id);
        $row->delete();

        return redirect()->route('ecorefscost.index')->with('success',__('app.deleted'));
    }
}
