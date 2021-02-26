<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\VisCenter\KPI\AbdKpiId;
use App\Http\Controllers\Controller;

class AbdKpiIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abdkpiid = AbdKpiId::latest()->paginate(5);

        return view('viscenterKPI.abdkpiid.index',compact('abdkpiid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('viscenterKPI.abdkpiid.create');
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

        AbdKpiId::create($request->all());

        return redirect()->route('abdkpiid.index')->with('success',__('app.created'));
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
        $abdkpiid = AbdKpiId::find($id);
        return view('viscenterKPI.abdkpiid.edit',compact('abdkpiid'));
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
        $abdkpiid=AbdKpiId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $abdkpiid->update($request->all());

        return redirect()->route('abdkpiid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $abdkpiid = AbdKpiId::find($id);
        $abdkpiid->delete();

        return redirect()->route('abdkpiid.index')->with('success',__('app.deleted'));
    }
}
