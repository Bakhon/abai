<?php

namespace App\Http\Controllers\VizCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VizCenter\CorpAll;
use App\Models\VizCenter\TypeId;
use App\Models\EcoRefsCompaniesId;
use App\Models\VizCenter\CorpKpiId;

class CorpAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corpall = CorpAll::latest()->with('company')->paginate(5); 
        $corpall = CorpAll::latest()->with('corpkpi')->paginate(5);
        $corpall = CorpAll::latest()->with('type')->paginate(5);

        return view('corpall.index',compact('corpall'))
            ->with('i', (request()->input('page', 1) - 1) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = EcoRefsCompaniesId::get();
        $type = TypeId::get();
        $corpkpi = CorpKpiId::get();
        return view('corpall.create',compact('company','corpkpi','type'));
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
            'company_id' => 'required',
            'type_id' => 'required',
            'corpkpi_id' => 'required',
            'date' => 'required',
            // 'aim_dates'=> 'required',
            // 'remained_days' => 'required',
            // 'completion_probability' => 'required',
            ]);

        CorpAll::create($request->all());

        return redirect()->route('corpall.index')->with('success',__('app.created'));
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
        $row = CorpAll::find($id);
        $company = EcoRefsCompaniesId::get();
        $corpkpi = CorpKpiId::get();
        $type = TypeId::get();
        return view('corpall.edit',compact('row', 'company', 'corpkpi', 'type'));
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
        $corpall=CorpAll::find($id);
        $request->validate([
            'company_id' => 'required',
            'type_id' => 'required',
            'corpkpi_id' => 'required',
            'date' => 'required',
            // 'aim_dates'=> 'required',
            // 'remained_days' => 'required',
            // 'completion_probability' => 'required',
        ]);

        $corpall->update($request->all());

        return redirect()->route('corpall.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = CorpAll::find($id);
        $row->delete();

        return redirect()->route('corpall.index')->with('success',__('app.deleted'));
    }
}
