<?php

namespace App\Http\Controllers;

use App\Models\Refs\EcoRefsScFa;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsBranchId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRouteTnId;
use App\Models\EcoRefsTarifyTn;
use App\Models\EcoRefsExc;
use App\Models\EcoRefsRoutesId;
use Illuminate\Http\Request;

class EcoRefsTarifyTnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $ecorefstarifytn = EcoRefsTarifyTn::latest()->with('scfa')->with('branch')->with('company')->with('direction')->with('route')->with('routetn')->with('exc')->paginate(5);

            return view('ecorefstarifytn.index',compact('ecorefstarifytn'))
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
        $branch = EcoRefsBranchId::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();
        $routetn = EcoRefsRouteTnId::get();
        $exc = EcoRefsExc::get();
        return view('ecorefstarifytn.create',compact('sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
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
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'route_tn_id' => 'required',
            'exc_id' => 'required',
            'date' => 'required',
            'tn_rate' => 'required',
            'extent' => 'required',
        ]);

        EcoRefsTarifyTn::create($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.created'));
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
            $row = EcoRefsTarifyTn::find($id);
            $sc_fa = EcoRefsScFa::get();
            $branch = EcoRefsBranchId::get();
            $company = EcoRefsCompaniesId::get();
            $direction = EcoRefsDirectionId::get();
            $route = EcoRefsRoutesId::get();
            $routetn = EcoRefsRouteTnId::get();
            $exc = EcoRefsExc::get();

            return view('ecorefstarifytn.edit',compact('row', 'sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
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
        $EcoRefsTarifyTn=EcoRefsTarifyTn::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'route_tn_id' => 'required',
            'exc_id' => 'required',
            'date' => 'required',
            'tn_rate' => 'required',
            'extent' => 'required',
        ]);

        $EcoRefsTarifyTn->update($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsTarifyTn::find($id);
        $row->delete();

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.deleted'));
    }
}
