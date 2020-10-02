<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsDirectionId;
use Illuminate\Http\Request;

class EcoRefsDirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsdirection = EcoRefsDirectionId::latest()->paginate(5);

        return view('ecorefsdirection.index',compact('ecorefsdirection'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecorefsdirection.create');
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

        EcoRefsDirectionId::create($request->all());

        return redirect()->route('ecorefsdirection.index')->with('success',__('app.created'));

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
        $EcoRefsDirection = EcoRefsDirectionId::find($id);
        return view('ecorefsdirection.edit',compact('EcoRefsDirection'));
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
        $EcoRefsDirectionId=EcoRefsDirectionId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $EcoRefsDirectionId->update($request->all());

        return redirect()->route('ecorefsdirection.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsDirectionId = EcoRefsDirectionId::find($id);
        $EcoRefsDirectionId->delete();

        return redirect()->route('ecorefsdirection.index')->with('success',__('app.deleted'));
         //
    }
}
