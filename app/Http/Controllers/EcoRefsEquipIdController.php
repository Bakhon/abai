<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsEquipId;
use Illuminate\Http\Request;

class EcoRefsEquipIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsequipid = EcoRefsEquipId::latest()->paginate(5);

        return view('economy_kenzhe/ecorefsequipid.index',compact('ecorefsequipid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('economy_kenzhe/ecorefsequipid.create');
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
        ]);

        EcoRefsEquipId::create($request->all());

        return redirect()->route('ecorefsequipid.index')->with('success',__('app.created'));
         //
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
        $EcoRefsEquipId = EcoRefsEquipId::find($id);
        return view('economy_kenzhe/ecorefsequipid.edit',compact('EcoRefsEquipId'));
 
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
        $EcoRefsEquipId=EcoRefsEquipId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsEquipId->update($request->all());

        return redirect()->route('ecorefsequipid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsEquipId = EcoRefsEquipId::find($id);
        $EcoRefsEquipId->delete();

        return redirect()->route('ecorefsequipid.index')->with('success',__('app.deleted'));
 
    }
}
