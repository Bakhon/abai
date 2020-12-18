<?php

namespace App\Http\Controllers\VizCenter;

use Illuminate\Http\Request;
use App\Models\VizCenter\TypeId;
use App\Http\Controllers\Controller;

class TypeIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeid = TypeId::latest()->paginate(5);

        return view('viscenterKPI.typeid.index',compact('typeid'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('viscenterKPI.typeid.create');
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

        TypeId::create($request->all());

        return redirect()->route('typeid.index')->with('success',__('app.created'));
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
        $typeid= TypeId::find($id);
        return view('viscenterKPI.typeid.edit',compact('typeid'));
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
        $typeid=TypeId::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $typeid->update($request->all());

        return redirect()->route('typeid.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $typeid = TypeId::find($id);
        $typeid->delete();

        return redirect()->route('typeid.index')->with('success',__('app.deleted'));
    }
}
