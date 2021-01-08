<?php

namespace App\Http\Controllers\VisCenter\KPI;

use Illuminate\Http\Request;
use App\Models\VisCenter\KPI\MarabKpiId;
use App\Http\Controllers\Controller;

class MarabKpiIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marabkpiid = MarabKpiId::latest()->paginate(5);

        return view('viscenterKPI.marabkpiid.index',compact('marabkpiid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('viscenterKPI.marabkpiid.create');
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

        MarabKpiId::create($request->all());

        return redirect()->route('marabkpiid.index')->with('success',__('app.created'));
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
        $marabkpiid = MarabKpiId::find($id);
        return view('viscenterKPI.marabkpiid.edit',compact('marabkpiid'));
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
        $marabkpiid=MarabKpiId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $marabkpiid->update($request->all());

        return redirect()->route('marabkpiid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marabkpiid = MarabKpiId::find($id);
        $marabkpiid->delete();

        return redirect()->route('marabkpiid.index')->with('success',__('app.deleted'));
    }
}
