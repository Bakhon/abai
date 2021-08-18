<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsRouteTnId;
use Illuminate\Http\Request;

class EcoRefsRouteTnIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsroutetnid = EcoRefsRouteTnId::latest()->paginate(5);

        return view('economy_kenzhe/ecorefsroutetnid.index',compact('ecorefsroutetnid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('economy_kenzhe/ecorefsroutetnid.create');
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

        EcoRefsRouteTnId::create($request->all());

        return redirect()->route('ecorefsroutetnid.index')->with('success',__('app.created'));
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
        $EcoRefsRouteTnId = EcoRefsRouteTnId::find($id);
        return view('economy_kenzhe/ecorefsroutetnid.edit',compact('EcoRefsRouteTnId'));
 
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
        $EcoRefsRouteTnId=EcoRefsRouteTnId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsRouteTnId->update($request->all());

        return redirect()->route('ecorefsroutetnid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsRouteTnId = EcoRefsRouteTnId::find($id);
        $EcoRefsRouteTnId->delete();

        return redirect()->route('ecorefsroutetnid.index')->with('success',__('app.deleted'));
 
    }
}
