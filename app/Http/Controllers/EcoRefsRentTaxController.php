<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsRentTax;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;

class EcoRefsRentTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsrenttax = EcoRefsRentTax::latest()->with('scfa')->paginate(5);

        return view('ecorefsrenttax.index',compact('ecorefsrenttax'))
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
        return view('ecorefsrenttax.create',compact('sc_fa'));
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
            'world_price_beg' => 'required',
            'world_price_end' => 'required',
            'rate' => 'required',
        ]);

        EcoRefsRentTax::create($request->all());

        return redirect()->route('ecorefsrenttax.index')->with('success',__('app.created'));
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
        $row = EcoRefsRentTax::find($id);
        $sc_fa = EcoRefsScFa::get();
        return view('ecorefsrenttax.edit',compact('row', 'sc_fa'));
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
        $EcoRefsRentTax=EcoRefsRentTax::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'world_price_beg' => 'required',
            'world_price_end' => 'required',
            'rate' => 'required',
        ]);

        $EcoRefsRentTax->update($request->all());

        return redirect()->route('ecorefsrenttax.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsRentTax = EcoRefsRentTax::find($id);
        $EcoRefsRentTax->delete();

        return redirect()->route('ecorefsrenttax.index')->with('success',__('app.deleted'));
    }
}
