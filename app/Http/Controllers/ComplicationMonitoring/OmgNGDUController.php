<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\GuKormass as ComplicationMonitoringGuKormass;
use App\Models\ComplicationMonitoring\Kormass as ComplicationMonitoringKormass;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA as ComplicationMonitoringOmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU as ComplicationMonitoringOmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OmgNGDUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $omgngdu = ComplicationMonitoringOmgNGDU::orderByDesc('date')
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well')
                                ->paginate(10);



        return view('omgngdu.index',compact('omgngdu'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omgngdu.create');
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

        $omgngdu = new ComplicationMonitoringOmgNGDU;
        $omgngdu->field = ($request->field) ? $request->field : NULL;
        $omgngdu->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgngdu->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgngdu->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgngdu->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgngdu->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgngdu->date = date("Y-m-d H:i", strtotime($request->date));
        $omgngdu->daily_fluid_production = ($request->daily_fluid_production) ? $request->daily_fluid_production : NULL;
        $omgngdu->daily_water_production = ($request->daily_water_production) ? $request->daily_water_production : NULL;
        $omgngdu->daily_oil_production = ($request->daily_oil_production) ? $request->daily_oil_production : NULL;
        $omgngdu->daily_gas_production_in_sib = ($request->daily_gas_production_in_sib) ? $request->daily_gas_production_in_sib : NULL;
        $omgngdu->bsw = ($request->bsw) ? $request->bsw : NULL;
        $omgngdu->surge_tank_pressure = ($request->surge_tank_pressure) ? $request->surge_tank_pressure : NULL;
        $omgngdu->pump_discharge_pressure = ($request->pump_discharge_pressure) ? $request->pump_discharge_pressure : NULL;
        $omgngdu->heater_inlet_pressure = ($request->heater_inlet_pressure) ? $request->heater_inlet_pressure : NULL;
        $omgngdu->heater_output_pressure = ($request->heater_output_pressure) ? $request->heater_output_pressure : NULL;
        $omgngdu->kormass_number = ($request->kormass_number) ? $request->kormass_number : NULL;
        $omgngdu->pressure = ($request->pressure) ? $request->pressure : NULL;
        $omgngdu->temperature = ($request->temperature) ? $request->temperature : NULL;
        $omgngdu->daily_fluid_production_kormass = ($request->daily_fluid_production_kormass) ? $request->daily_fluid_production_kormass : NULL;
        $omgngdu->cruser_id = Auth::user()->id;
        $omgngdu->save();

        return redirect()->route('omgngdu.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omgngdu = ComplicationMonitoringOmgNGDU::where('id', '=', $id)
                            ->with('ngdu')
                            ->with('cdng')
                            ->with('gu')
                            ->with('zu')
                            ->with('well')
                            ->first();

        return view('omgngdu.show', compact('omgngdu'));
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
        $omgngdu = ComplicationMonitoringOmgNGDU::find($id);
        $omgngdu->delete();

        return redirect()->route('omgngdu.index')->with('success',__('app.deleted'));
    }

    public function getKormass(Request $request){
        $guKormass = ComplicationMonitoringGuKormass::where('gu_id', '=', $request->gu_id)->get();
        $guKormassArray = [];
        foreach($guKormass as $row){
            array_push($guKormassArray, $row->kormass_id);
        }
        $kormass = ComplicationMonitoringKormass::wherein('id', $guKormassArray)->get();


        return response()->json([
            'code'=>200,
            'message' => 'success',
            'data' => $kormass
        ]);
    }

    public function getGuDataByDay(Request $request){
        $ngdu = ComplicationMonitoringOmgNGDU::where('date', '=', $request->dt)->where('gu_id', '=', $request->gu_id)->first();
        $uhe = ComplicationMonitoringOmgUHE::where('date', '=', $request->dt)->where('gu_id', '=', $request->gu_id)->first();
        $ca = ComplicationMonitoringOmgCA::where('date', '=', $request->dt)->where('gu_id', '=', $request->gu_id)->first();
        $wmLast = WaterMeasurement::where('gu_id','=',$request->gu_id)->latest()->first();
        $wmLastCO2 = WaterMeasurement::where('gu_id','=',$request->gu_id)->whereNotNull('carbon_dioxide')->latest()->first();
        $wmLastH2S = WaterMeasurement::where('gu_id','=',$request->gu_id)->whereNotNull('hydrogen_sulfide')->latest()->first();
        $wmLastHCO3 = WaterMeasurement::where('gu_id','=',$request->gu_id)->whereNotNull('hydrocarbonate_ion')->latest()->first();
        $wmLastCl = WaterMeasurement::where('gu_id','=',$request->gu_id)->whereNotNull('chlorum_ion')->latest()->first();
        $wmLastSO4 = WaterMeasurement::where('gu_id','=',$request->gu_id)->whereNotNull('sulphate_ion')->latest()->first();
        $oilGas = OilGas::where('date', '=', $request->dt)->where('gu_id', '=', $request->gu_id)->first();

        return response()->json([
            'code'=>200,
            'message' => 'success',
            'ngdu' => $ngdu,
            'uhe' => $uhe,
            'ca' => $ca,
            'wmLastH2S' => $wmLastH2S,
            'wmLastCO2' => $wmLastCO2,
            'wmLastHCO3' => $wmLastHCO3,
            'wmLastCl' => $wmLastCl,
            'wmLast' => $wmLast,
            'wmLastSO4' => $wmLastSO4,
            'oilGas' => $oilGas
        ]);
    }
}
