<?php

namespace App\Http\Controllers\VisCenter\ImportForms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ImportForms\DZOdaily;

class DZOdailyCrudController extends Controller
{
    public function index()
    {
        $dzodaily = DZOdaily::latest()->paginate(15); 

        return view('viscenterDailyDZO.index',compact('dzodaily'))
            ->with('i', (request()->input('page', 1) - 1) * 15); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $type = TypeId::get();
        // $abdkpi = AbdKpiId::get();
        return view('viscenterDailyDZO.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DZOdaily::create($request->all());

        return redirect()->route('dzodaily.index')->with('success',__('app.created'));
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
        $row = DZOdaily::find($id);
        return view('viscenterDailyDZO.edit',compact('row'));
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
        $dzodaily=DZOdaily::find($id);

        $dzodaily->update($request->all());

        return redirect()->route('dzodaily.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = DZOdaily::find($id);
        $row->delete();

        return redirect()->route('dzodaily.index')->with('success',__('app.deleted'));
    }
}
