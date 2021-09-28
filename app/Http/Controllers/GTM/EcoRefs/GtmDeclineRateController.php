<?php

namespace App\Http\Controllers\GTM\EcoRefs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GtmDeclineRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $declineRates = [];
        return view('gtm.EcoRefs.GtmDeclineRate.index',compact('declineRates'));
    }

    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $branch = EcoRefsBranchId::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();
        $routetn = EcoRefsRouteTnId::get();
        $exc = EcoRefsExc::get();
        return view('economy_kenzhe/ecorefstarifytn.create',compact('sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
    }

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
        ]);

        EcoRefsTarifyTn::create($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.created'));
    }

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

        return view('economy_kenzhe/ecorefstarifytn.edit',compact('row', 'sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
    }

    public function update(UpdateEcoRefsTarifyTnRequest $request, $id)

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
        ]);

        $EcoRefsTarifyTn->update($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.updated'));
    }

    public function destroy($id)
    {
        $row = EcoRefsTarifyTn::find($id);
        $row->delete();

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.deleted'));
    }
}
