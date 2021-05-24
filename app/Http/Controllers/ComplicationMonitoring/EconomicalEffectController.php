<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\EconomicalEffectFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\POSTCaller;
use App\Http\Resources\EconomicalEffectListResource;
use App\Models\ComplicationMonitoring\EconomicalEffect;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\Refs\Gu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class EconomicalEffectController extends CrudController
{    
    protected $modelName = 'omguhe';

    public function index(): \Illuminate\View\View
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('economical_effect.list'),
            ],
            'title' => trans('monitoring.economical_effect_title'),
            'table_header' => [
                trans('monitoring.economical_effect_title') => 9,
            ],
            'fields' => [
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('economical_effect')
                            ->orderBy('name', 'asc')
                            ->get()
                            ->map(
                                function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                    ];
                                }
                            )
                            ->toArray()
                    ]
                ],
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
                ],
                'сorrosion' => [
                    'title' => trans('monitoring.calc_common_corrosion_speed'),
                    'type' => 'numeric',
                ],
                'actual_inhibitor_injection' => [
                    'title' => trans('monitoring.actual_inhibitor_level'),
                    'type' => 'numeric',
                ],
                'recommended_inhibitor_injection' => [
                    'title' => trans('monitoring.ik_recommend'),
                    'type' => 'numeric',
                ],
                'difference' => [
                    'title' => trans('monitoring.difference'),
                    'type' => 'numeric',
                ],
                'inhibitor_price' => [
                    'title' => trans('monitoring.inhibitor_price'),
                    'type' => 'numeric',
                ],
                'economical_effect' => [
                    'title' => trans('monitoring.economical_effect'),
                    'type' => 'numeric',
                ],
                'economical_effect_sum' => [
                    'title' => trans('monitoring.economical_effect_sum'),
                    'type' => 'numeric',
                ],
            ]
        ];

        return view('complicationMonitoring.economical_effect.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = EconomicalEffect::query()
            ->with('gu');

        $ecomonical_effect = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(EconomicalEffectListResource::collection($ecomonical_effect)->toJson()));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new EconomicalEffectFilter($query, $filter))->filter();
    }

    public function testCronCalc($gu = 38){
        $currentDosage = OmgUHE::whereNotNull('current_dosage')->get();
        
        EconomicalEffect::truncate();

        $result = [];
        
        foreach($currentDosage as $item){

            $post = new POSTCaller(
                WaterMeasurementController::class,
                'getGuData',
                Request::class,
                [
                    'gu_id' => $item->gu_id
                ]
            );

            $guData = $post->call()->getData();

            $post = new POSTCaller(
                OmgNGDUController::class,
                'getGuDataByDay',
                Request::class,
                [
                    'dt' => $item->date,
                    'gu_id' => $item->gu_id
                ]
            );

            $guDataByDay = $post->call()->getData();

            if ($guDataByDay->oilGas &&
                $guData->pipe &&
                $guDataByDay->ngdu &&
                $guDataByDay->ngdu->surge_tank_pressure &&
                $guDataByDay->ngdu->pump_discharge_pressure)
            {
                $data = [
                    "gu_id" => $item->gu_id,
                    "WC" => $guDataByDay->ngdu->bsw,
                    "GOR1" => $guData->constantsValues[0]->value,
                    "sigma" => $guData->constantsValues[1]->value,
                    "do" => $guData->pipe->outside_diameter,
                    "roughness" => $guData->pipe->roughness,
                    "l" => $guData->pipe->length,
                    "thickness" => $guData->pipe->thickness,
                    "P" => $guDataByDay->ngdu->pump_discharge_pressure,
                    "t_heater" => $guDataByDay->ngdu->heater_output_temperature,
                    "conH2S" => $guDataByDay->wmLastH2S->hydrogen_sulfide,
                    "conCO2" => $guDataByDay->wmLastCO2->carbon_dioxide,
                    "t_inlet_heater" => $guDataByDay->ngdu->heater_inlet_temperature,
                    "q_l" => $guDataByDay->ngdu->daily_fluid_production,
                    "H2O" => $guDataByDay->ngdu->bsw,
                    "HCO3" => $guDataByDay->wmLastHCO3->hydrocarbonate_ion,
                    "Cl" => $guDataByDay->wmLastCl->chlorum_ion,
                    "SO4" => $guDataByDay->wmLastSO4->sulphate_ion,
                    "q_g_sib" => $guDataByDay->ngdu->daily_gas_production_in_sib,
                    "P_bufer" => $guDataByDay->ngdu->surge_tank_pressure,
                    "rhol" => $guDataByDay->wmLastH2S->density,
                    "rho_o" => $guDataByDay->oilGas->water_density_at_20,
                    "rhog" => $guDataByDay->oilGas->gas_density_at_20,
                    "mul" => $guDataByDay->oilGas->oil_viscosity_at_20,
                    "mug" => $guDataByDay->oilGas->gas_viscosity_at_20,
                    "q_o" => $guDataByDay->ngdu->daily_oil_production
                ];

                $post = new POSTCaller(
                    DruidController::class,
                    'corrosion',
                    Request::class,
                    $data
                );
                $corrosion = $post->call()->getData();

                $inhibitorPrice = 690;

                $ecomonicalEffect = new EconomicalEffect();
                $ecomonicalEffect->gu_id = $item->gu_id;
                $ecomonicalEffect->date = $item->date;
                $ecomonicalEffect->сorrosion = $corrosion->corrosion_rate_mm_per_y_point_A;

                //TODO
                $ecomonicalEffect->actual_inhibitor_injection = $item->current_dosage;
                //use plan dosage

                $ecomonicalEffect->recommended_inhibitor_injection = $corrosion->dose_mg_per_l_point_A;
                $ecomonicalEffect->difference = $item->current_dosage - $corrosion->dose_mg_per_l_point_A;
                $ecomonicalEffect->inhibitor_price = $inhibitorPrice;
                $ecomonicalEffect->economical_effect = ($item->current_dosage/1000 - $corrosion->dose_mg_per_l_point_A/1000) * $inhibitorPrice * $guDataByDay->ngdu->daily_water_production / 1000;
                $ecomonicalEffect->save();
            }
        }

        $ecoonicalEffect = EconomicalEffect::orderBy('date')->get()->groupBy('gu_id');
        $total = [];
        foreach($ecoonicalEffect as $key=>$row){
            foreach($row as $item){
                if(!empty($total[$key])){
                    $total[$key][Carbon::parse($item->date)->year] += $item->economical_effect; 
                }else{
                    $total[$key][Carbon::parse($item->date)->year] = $item->economical_effect; 
                }
                EconomicalEffect::where('id',$item->id)->update(['economical_effect_sum'=>$total[$key]]);
                echo $item->gu_id." | ".$item->date." | ".$item->id." | ".$item->economical_effect." | ".$total[$key]."<br>";
            }
        }
    }
}
