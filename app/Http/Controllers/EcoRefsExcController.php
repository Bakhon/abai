<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsExc;
use Illuminate\Http\Request;

class EcoRefsExcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsexc = EcoRefsExc::latest()->paginate(5);

        return view('ecorefsexc.index',compact('ecorefsexc'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsexc.create');
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

        EcoRefsExc::create($request->all());

        return redirect()->route('ecorefsexc.index')->with('success',__('app.created'));
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
        $EcoRefsExc = EcoRefsExc::find($id);
        return view('ecorefsexc.edit',compact('EcoRefsExc'));

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
        $EcoRefsExc=EcoRefsExc::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsExc->update($request->all());

        return redirect()->route('ecorefsexc.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsExc = EcoRefsExc::find($id);
        $EcoRefsExc->delete();

        return redirect()->route('ecorefsexc.index')->with('success',__('app.deleted'));

    }
}
