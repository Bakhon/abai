<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\Refs\Ngdu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function economic(){
        $economicNextYear = OmgCA::with('gu')
            ->where('date', '=', '2021-01-01')
            ->get();

        $data = [
            [
                'ГУ',
                'Плановая дозировка (ТС-3011)',
                'План, техрежим Qв',
                'Плановый расход реагента Qп (ТС-3011), т/год',
                'Плановый расход реагента Qп (ТС-3011), кг/сут',
                'Фоновая скорост коррозии',
                'Рекомендуемая дозировка (ТС-3011)',
                'Расход реагента при рекомендуемой дозировке Qр (ТС-3011)',
                'Экономия при внедрении рекомендации'
            ]
        ];

        foreach ($economicNextYear as $item){
            $array = [];
            array_push($array, $item->gu->name);
            array_push($array, $item->plan_dosage);
            array_push($array, $item->q_v);
            $cg = $item->plan_dosage * $item->q_v / 1000;
            array_push($array, $cg);
            $ch = $cg * 2.74;
            array_push($array, $ch);
            $ck = self::getCorrosion($item->gu->id);
            array_push($array, $ck);
            if($ck > 0.1){
                $ci = 14.177*log($ck)+35.222;
                array_push($array, $ci);
            }else{
                $ci = 0;
                array_push($array, $ci);
            }
            $cj = $ci*$item->q_v/1000;
            array_push($array, $cj);
            $co = ($cg-$cj)*690000/1000000;
            array_push($array, $co);
            array_push($data,$array);
        }


        $economicCurrentYear = OmgCA::with('gu')
            ->where('date', '=', '2020-01-01')
            ->get();



        $vdata = [
            'wellsList' => $data,
        ];

        return response()->json($vdata);
    }

    static function getCorrosion($gu){
        $cor = Corrosion::where('gu_id', '=', $gu)->orderBy('created_at', 'desc')->first();
        return $cor->background_corrosion_velocity;
    }

    static function getCalcData($gu){
        return 0;
        $months = NewsItem::get()->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('m');
        });
    }

    static function getOilGasByYear($gu = 73){
        $data = OilGas::select(DB::raw('avg(water_density_at_20) as `water_density_at_20_avg`'), DB::raw('avg(gas_density_at_20) as `gas_density_at_20_avg`'), DB::raw('avg(oil_viscosity_at_20) as `oil_viscosity_at_20_avg`'), DB::raw('avg(gas_viscosity_at_20) as `gas_viscosity_at_20_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->get();

        return response()->json($data);
    }

    static function getWMByYear($gu = 73){
        $data = WaterMeasurement::select(DB::raw('avg(hydrogen_sulfide) as `hydrogen_sulfide_avg`'), DB::raw('avg(carbon_dioxide) as `carbon_dioxide_avg`'), DB::raw('avg(hydrocarbonate_ion) as `hydrocarbonate_ion_avg`'), DB::raw('avg(chlorum_ion) as `chlorum_ion_avg`'), DB::raw('avg(sulphate_ion) as `sulphate_ion_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->get();

        return response()->json($data);
    }

    static function getNgduByYear($gu = 73){
        $data = OmgNGDU::select(DB::raw('avg(bsw) as `bsw_avg`'), DB::raw('avg(pump_discharge_pressure) as `pump_discharge_pressure_avg`'), DB::raw('avg(heater_output_pressure) as `heater_output_pressure_avg`'), DB::raw('avg(daily_fluid_production) as `daily_fluid_production_avg`'), DB::raw('avg(daily_gas_production_in_sib) as `daily_gas_production_in_sib_avg`'), DB::raw('avg(surge_tank_pressure) as `surge_tank_pressure_avg`'), DB::raw("DATE_FORMAT(date, '%Y') dt"))
        ->groupby('dt')
        ->where('gu_id','=', $gu)
        ->having('dt', '=', '2020')
        ->get();

        return response()->json($data);
    }

    public function economicTable()
    {
        return view('сomplicationMonitoring.oilGas.table');
    }
}
