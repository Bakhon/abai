<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsEquipId;
use App\Models\EcoRefsServiceTime;
use Illuminate\Http\Request;

class EcoRefsServiceTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $ecorefsservicetime = EcoRefsServiceTime::latest()->with('company')->with('equip')->paginate(5);

            return view('ecorefsservicetime.index',compact('ecorefsservicetime'))
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
        $equip = EcoRefsEquipId::get();
        return view('ecorefsservicetime.create',compact('company', 'equip'));
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
            'equip_id' => 'required',
            'avg_serv_life' => 'required',
        ]);

        EcoRefsServiceTime::create($request->all());

        return redirect()->route('ecorefsservicetime.index')->with('success',__('app.created'));
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
        $row = EcoRefsServiceTime::find($id);
        $company = EcoRefsCompaniesId::get();
        $equip = EcoRefsEquipId::get();

        return view('ecorefsservicetime.edit',compact('row', 'company', 'equip'));

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
        $EcoRefsServiceTime=EcoRefsServiceTime::find($id);
        $request->validate([
            'company_id' => 'required',
            'equip_id' => 'required',
            'avg_serv_life' => 'required',
        ]);

        $EcoRefsServiceTime->update($request->all());

        return redirect()->route('ecorefsservicetime.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsServiceTime::find($id);
        $row->delete();

        return redirect()->route('ecorefsservicetime.index')->with('success',__('app.deleted'));
    }
}
