<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsRoutesId;
use Illuminate\Http\Request;

class EcoRefsRouteIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsrouteid = EcoRefsRoutesId::latest()->paginate(5);

        return view('ecorefsrouteid.index',compact('ecorefsrouteid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsrouteid.create');
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

        EcoRefsRoutesId::create($request->all());

        return redirect()->route('ecorefsrouteid.index')->with('success',__('app.created'));
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
        $EcoRefsRoutesId = EcoRefsRoutesId::find($id);
        return view('ecorefsrouteid.edit',compact('EcoRefsRoutesId'));
 
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
        $EcoRefsRoutesId=EcoRefsRoutesId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsRoutesId->update($request->all());

        return redirect()->route('ecorefsrouteid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsRoutesId = EcoRefsRoutesId::find($id);
        $EcoRefsRoutesId->delete();

        return redirect()->route('ecorefsrouteid.index')->with('success',__('app.deleted'));
 
    }
}
