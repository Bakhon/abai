<?php

namespace App\Http\Controllers\VizCenter;

use Illuminate\Http\Request;
use App\Models\VizCenter\Marab6;
use App\Models\VizCenter\TypeId;
use App\Http\Controllers\Controller;


class Marab6Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marab6 = Marab6::latest()->with('type')->paginate(5); 

        return view('marab6.index',compact('marab6'))
            ->with('i', (request()->input('page', 1) - 1) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = TypeId::get();
        return view('marab6.create',compact('type'));
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
            'type_id' => 'required',
            // 'aim_dates'=> 'required',
            // 'remained_days' => 'required',
            // 'completion_probability' => 'required',
            ]);

        Marab6::create($request->all());

        return redirect()->route('marab6.index')->with('success',__('app.created'));
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
        $row = Marab6::find($id);
        $type = TypeId::get();
        return view('marab6.edit',compact('row', 'type'));
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
        $Marab6=Marab6::find($id);
        $request->validate([
            'type_id' => 'required',
            // 'aim_dates'=> 'required',
            // 'remained_days' => 'required',
            // 'completion_probability' => 'required',
        ]);

        $Marab6->update($request->all());

        return redirect()->route('marab6.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Marab6::find($id);
        $row->delete();

        return redirect()->route('marab6.index')->with('success',__('app.deleted'));
    }
}
