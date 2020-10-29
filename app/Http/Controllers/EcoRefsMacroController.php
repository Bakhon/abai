<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsMacro;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;

class EcoRefsMacroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsmacro = EcoRefsMacro::latest()->with('scfa')->paginate(5);

        return view('ecorefsmacro.index',compact('ecorefsmacro'))
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
        return view('ecorefsmacro.create',compact('sc_fa'));
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
            'date' => 'required',
            'ex_rate_dol' => 'required',
            'ex_rate_rub' => 'required',
            'inf_end' => 'required',
            ]);

        EcoRefsMacro::create($request->all());

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.created'));
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
        $row = EcoRefsMacro::find($id);
        return view('ecorefsmacro.edit',compact('row', 'sc_fa'));
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
        $EcoRefsMacro=EcoRefsMacro::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'date' => 'required',
            'ex_rate_dol' => 'required',
            'ex_rate_rub' => 'required',
            'inf_end' => 'required',
        ]);

        $EcoRefsMacro->update($request->all());

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsMacro = EcoRefsMacro::find($id);
        $EcoRefsMacro->delete();

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.deleted'));
    }
}
