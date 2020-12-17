<?php

namespace App\Http\Controllers\VizCenter;

use App\Http\Controllers\Controller;
use App\Models\VizCenter\CorpKpiId;
use Illuminate\Http\Request;

class CorpKpiIdController extends Controller
{
    public function index()
    {
        $corpkpiid = CorpKpiId::latest()->paginate(5);

        return view('corpkpiid.index',compact('corpkpiid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('corpkpiid.create');
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

        CorpKpiId::create($request->all());

        return redirect()->route('corpkpiid.index')->with('success',__('app.created'));
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
        $corpkpiid = CorpKpiId::find($id);
        return view('corpkpiid.edit',compact('corpkpiid'));
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
        $corpkpiid=CorpKpiId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $corpkpiid->update($request->all());

        return redirect()->route('corpkpiid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $corpkpiid = CorpKpiId::find($id);
        $corpkpiid->delete();

        return redirect()->route('corpkpiid.index')->with('success',__('app.deleted'));
    }
}
