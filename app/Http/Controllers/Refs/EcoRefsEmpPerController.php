<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\EcoRefsScFa;
use App\Http\Controllers\Controller;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRoutesId;

use Illuminate\Http\Request;

class EcoRefsEmpPerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsempper = EcoRefsEmpPer::latest()->with('scfa')->with('company')->with('direction')->with('route')->paginate(5);

        return view('ecorefsempper.index',compact('ecorefsempper'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();
        return view('ecorefsempper.create',compact('sc_fa', 'company', 'direction', 'route'));
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
            'sc_fa' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'emp_per' => 'required',
        ]);

        EcoRefsEmpPer::create($request->all());

        return redirect()->route('ecorefsempper.index')->with('success',__('app.created'));
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
        $row = EcoRefsEmpPer::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();

        return view('ecorefsempper.edit',compact('row', 'sc_fa', 'company', 'direction', 'route'));

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
        $EcoRefsEmpPer=EcoRefsEmpPer::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'emp_per' => 'required',
        ]);

        $EcoRefsEmpPer->update($request->all());

        return redirect()->route('ecorefsempper.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsEmpPer::find($id);
        $row->delete();

        return redirect()->route('ecorefsempper.index')->with('success',__('app.deleted'));
    }
}
