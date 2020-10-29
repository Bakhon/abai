<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsAnnualProdVolume;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;

class EcoRefsAnnualProdVolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsannualprodvolume = EcoRefsAnnualProdVolume::latest()->with('scfa')->paginate(5);

        return view('ecorefsannualprodvolume.index',compact('ecorefsannualprodvolume'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        return view('ecorefsannualprodvolume.create',compact('sc_fa'));
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
            'annual_prod_volume_beg' => 'required',
            'annual_prod_volume_end' => 'required',
            'ndpi' => 'required',
        ]);

        EcoRefsAnnualProdVolume::create($request->all());

        return redirect()->route('ecorefsannualprodvolume.index')->with('success',__('app.created'));
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
        $row = EcoRefsAnnualProdVolume::find($id);
        $sc_fa = EcoRefsScFa::get();
        return view('ecorefsannualprodvolume.edit',compact('row', 'sc_fa'));
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
        $EcoRefsAnnualProdVolume=EcoRefsAnnualProdVolume::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'annual_prod_volume_beg' => 'required',
            'annual_prod_volume_end' => 'required',
            'ndpi' => 'required',
        ]);

        $EcoRefsAnnualProdVolume->update($request->all());

        return redirect()->route('ecorefsannualprodvolume.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsAnnualProdVolume::find($id);
        $row->delete();

        return redirect()->route('ecorefsannualprodvolume.index')->with('success',__('app.deleted'));
    }
}
