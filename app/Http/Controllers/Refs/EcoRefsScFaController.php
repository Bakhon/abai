<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;

class EcoRefsScFaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsscfa = EcoRefsScFa::latest()->paginate(5);

        return view('ecorefsscfa.index',compact('ecorefsscfa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsscfa.create');
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

        EcoRefsScFa::create($request->all());

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $EcoRefsScFa = EcoRefsScFa::find($id);
        return view('ecorefsscfa.edit',compact('EcoRefsScFa'));
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
        $EcoRefsScFa=EcoRefsScFa::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsScFa->update($request->all());

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsScFa = EcoRefsScFa::find($id);
        $EcoRefsScFa->delete();

        return redirect()->route('ecorefsscfa.index')->with('success',__('app.deleted'));
        //
    }
    public function refsList(){
        return view('ecorefsscfa.list');
    }
}
