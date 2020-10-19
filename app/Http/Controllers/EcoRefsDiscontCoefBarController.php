<?php

namespace App\Http\Controllers;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsRoutesId;
use Illuminate\Http\Request;

class EcoRefsDiscontCoefBarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $ecorefsdiscontcoefbar = EcoRefsDiscontCoefBar::latest()->with('scfa')->with('company')->with('direction')->with('route')->paginate(5);

            return view('ecorefsdiscontcoefbar.index',compact('ecorefsdiscontcoefbar'))
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
        return view('ecorefsdiscontcoefbar.create',compact('sc_fa', 'company', 'direction', 'route'));
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
            'barr_coef' => 'required',
            'discont' => 'required',
            'oil_cost' => 'required',
            'macro' => 'required',
        ]);

        EcoRefsDiscontCoefBar::create($request->all());

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.created'));
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
        $row = EcoRefsDiscontCoefBar::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();

        return view('ecorefsdiscontcoefbar.edit',compact('sc_fa', 'row', 'company', 'direction', 'route'));

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
        $EcoRefsDiscontCoefBar=EcoRefsDiscontCoefBar::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'barr_coef' => 'required',
            'discont' => 'required',
            'oil_cost' => 'required',
            'macro' => 'required',
        ]);

        $EcoRefsDiscontCoefBar->update($request->all());

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsDiscontCoefBar::find($id);
        $row->delete();

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.deleted'));
    }
}
