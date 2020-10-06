<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsBranchId;
use Illuminate\Http\Request;

class EcoRefsBrachIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsbranchid = EcoRefsBranchId::latest()->paginate(5);

        return view('ecorefsbranchid.index',compact('ecorefsbranchid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsbranchid.create');
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

        EcoRefsBranchId::create($request->all());

        return redirect()->route('ecorefsbranchid.index')->with('success',__('app.created'));
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
        $EcoRefsBranchId = EcoRefsBranchId::find($id);
        return view('ecorefsbranchid.edit',compact('EcoRefsBranchId'));

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
        $EcoRefsBranchId=EcoRefsBranchId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsBranchId->update($request->all());

        return redirect()->route('ecorefsbranchid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsBranchId = EcoRefsBranchId::find($id);
        $EcoRefsBranchId->delete();

        return redirect()->route('ecorefsbranchid.index')->with('success',__('app.deleted'));
        //
    }
}
