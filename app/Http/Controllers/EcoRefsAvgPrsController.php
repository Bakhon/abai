<?php

namespace App\Http\Controllers;

use App\Models\Refs\EcoRefsScFa;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsAvgPrs;
use Illuminate\Http\Request;

class EcoRefsAvgPrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $ecorefsavgprs = EcoRefsAvgPrs::latest()->with('scfa')->with('company')->paginate(5);

            return view('ecorefsavgprs.index',compact('ecorefsavgprs'))
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
        return view('ecorefsavgprs.create',compact('sc_fa', 'company'));
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
            'avg_prs' => 'required',
        ]);

        EcoRefsAvgPrs::create($request->all());

        return redirect()->route('ecorefsavgprs.index')->with('success',__('app.created'));
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
        $sc_fa = EcoRefsScFa::get();
        $row = EcoRefsAvgPrs::find($id);
        $company = EcoRefsCompaniesId::get();

        return view('ecorefsavgprs.edit',compact('sc_fa', 'row', 'company'));
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
        $EcoRefsAvgPrs=EcoRefsAvgPrs::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'date' => 'required',
            'avg_prs' => 'required',
        ]);

        $EcoRefsAvgPrs->update($request->all());

        return redirect()->route('ecorefsavgprs.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsAvgPrs::find($id);
        $row->delete();

        return redirect()->route('ecorefsavgprs.index')->with('success',__('app.deleted'));
    }
}
