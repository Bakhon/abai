<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\OilGas;
use Illuminate\Http\Request;

class OilGasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oilgas = OilGas::orderByDesc('date')
                                ->with('other_objects')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->paginate(10);



        return view('сomplicationMonitoring.oilGas.index',compact('oilgas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('сomplicationMonitoring.oilGas.create');
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
            'date' => 'required',
        ]);

        $omgngdu = new OilGas;
        $omgngdu->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : NULL;
        $omgngdu->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgngdu->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgngdu->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgngdu->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgngdu->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgngdu->date = date("Y-m-d H:i", strtotime($request->date));
        $omgngdu->water_density_at_20 = ($request->water_density_at_20) ? $request->water_density_at_20 : NULL;
        $omgngdu->oil_viscosity_at_20 = ($request->oil_viscosity_at_20) ? $request->oil_viscosity_at_20 : NULL;
        $omgngdu->oil_viscosity_at_40 = ($request->oil_viscosity_at_40) ? $request->oil_viscosity_at_40 : NULL;
        $omgngdu->oil_viscosity_at_50 = ($request->oil_viscosity_at_50) ? $request->oil_viscosity_at_50 : NULL;
        $omgngdu->oil_viscosity_at_60 = ($request->oil_viscosity_at_60) ? $request->oil_viscosity_at_60 : NULL;
        $omgngdu->hydrogen_sulfide_in_gas = ($request->hydrogen_sulfide_in_gas) ? $request->hydrogen_sulfide_in_gas : NULL;
        $omgngdu->oxygen_in_gas = ($request->oxygen_in_gas) ? $request->oxygen_in_gas : NULL;
        $omgngdu->carbon_dioxide_in_gas = ($request->carbon_dioxide_in_gas) ? $request->carbon_dioxide_in_gas : NULL;
        $omgngdu->gas_density_at_20 = ($request->gas_density_at_20) ? $request->gas_density_at_20 : NULL;
        $omgngdu->gas_viscosity_at_20 = ($request->gas_viscosity_at_20) ? $request->gas_viscosity_at_20 : NULL;
        $omgngdu->save();

        return redirect()->route('oilgas.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oilgas = OilGas::where('id', '=', $id)
                        ->orderByDesc('date')
                        ->with('other_objects')
                        ->with('ngdu')
                        ->with('cdng')
                        ->with('gu')
                        ->with('zu')
                        ->with('well')
                        ->first();

        return view('сomplicationMonitoring.oilGas.show', compact('oilgas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = OilGas::find($id);
        $row->delete();

        return redirect()->route('oilgas.index')->with('success',__('app.deleted'));
    }
}
