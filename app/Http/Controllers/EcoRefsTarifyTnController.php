<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsBranchId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRouteTnId;
use App\Models\EcoRefsTarifyTn;
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

            $ecorefstarifytn = EcoRefsTarifyTn::latest()->with('branch')->with('company')->with('direction')->with('routetn')->paginate(5);

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
        $branch = EcoRefsBranchId::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $routetn = EcoRefsRouteTnId::get();
        return view('ecorefstarifytn.create',compact('branch', 'company', 'direction', 'routetn'));
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
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_tn_id' => 'required',
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
            $branch = EcoRefsBranchId::get();
            $company = EcoRefsCompaniesId::get();
            $direction = EcoRefsDirectionId::get();
            $route = EcoRefsRouteTnId::get();

            return view('ecorefstarifytn.edit',compact('row', 'branch', 'company', 'direction', 'route'));
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
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_tn_id' => 'required',
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
