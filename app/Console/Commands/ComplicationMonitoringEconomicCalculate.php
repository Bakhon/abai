<?php

namespace App\Console\Commands;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\POSTCaller;
use App\Models\ComplicationMonitoring\LostProfits;
use App\Models\ComplicationMonitoring\OmgUHE;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class ComplicationMonitoringEconomicCalculate extends Command
{
    protected $signature = 'monitoring-economic-calc:cron';

    protected $inhibitorPrice = 690;

    protected $description = 'Complication monitoring economic calculation';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        LostProfits::truncate();

        $currentDosage = OmgUHE::whereNotNull('current_dosage')->get();

        foreach($currentDosage as $item){
            $guData = $this->getGuData($item->gu_id);
            $guDataByDay = $this->getGuDataByDay($item->date, $item->gu_id);

            if ($guDataByDay->oilGas &&
                $guData->pipe &&
                $guDataByDay->ngdu &&
                $guDataByDay->ngdu->surge_tank_pressure &&
                $guDataByDay->ngdu->pump_discharge_pressure)
            {
                $corrosion = $this->calculateCorrosion($item, $guData, $guDataByDay);
                $this->insertIntoLostProfitsTable($guDataByDay, $corrosion, $item);
            }
        }

        $this->calculateLostProfitsTotal();
    }

    public function getGuData(string $guId): object
    {
        $post = new POSTCaller(
            WaterMeasurementController::class,
            'getGuData',
            Request::class,
            [
                'gu_id' => $guId
            ]
        );
        
        $guData = $post->call()->getData();

        return $guData;
    }

    public function getGuDataByDay(string $date, string $guId): object
    {
        $post = new POSTCaller(
            OmgNGDUController::class,
            'getGuDataByDay',
            Request::class,
            [
                'dt' => $date,
                'gu_id' => $guId
            ]
        );

        $guDataByDay = $post->call()->getData();

        return $guDataByDay;
    }

    public function calculateCorrosion(object $item, object $guData, object $guDataByDay): object 
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
            "q_o" => $guDataByDay->ngdu->daily_oil_production,
            "current_dosage" => $item->current_dosage
        ];

        $post = new POSTCaller(
            DruidController::class,
            'corrosion',
            Request::class,
            $data
        );
        $corrosion = $post->call()->getData();

        return $corrosion;
    }

    public function insertIntoLostProfitsTable(object $guDataByDay, object $corrosion, object $item) 
    {
        $ecomonicalEffect = new LostProfits();
        $ecomonicalEffect->gu_id = $item->gu_id;
        $ecomonicalEffect->date = $item->date;
        $ecomonicalEffect->сorrosion = $corrosion->corrosion_rate_mm_per_y_point_A;
        $ecomonicalEffect->actual_inhibitor_injection = $item->current_dosage;
        $ecomonicalEffect->recommended_inhibitor_injection = $corrosion->dose_mg_per_l_point_A;
        $ecomonicalEffect->difference = $item->current_dosage - $corrosion->dose_mg_per_l_point_A;
        $ecomonicalEffect->inhibitor_price = $this->inhibitorPrice;
        $ecomonicalEffect->lost_profits = ($item->current_dosage/1000 - $corrosion->dose_mg_per_l_point_A/1000) * $this->inhibitorPrice * $guDataByDay->ngdu->daily_water_production / 1000;
        $ecomonicalEffect->save();
    }

    public function calculateLostProfitsTotal()
    {
        $economicalEffect = LostProfits::orderBy('date')->get()->groupBy('gu_id');
        $total = [];
        foreach($economicalEffect as $key=>$row){
            foreach($row as $item){
                if(!empty($total[$key][Carbon::parse($item->date)->year])){
                    $total[$key][Carbon::parse($item->date)->year] += $item->lost_profits; 
                }else{
                    $total[$key][Carbon::parse($item->date)->year] = $item->lost_profits; 
                }
                LostProfits::where('id',$item->id)->update(['lost_profits_sum'=>$total[$key][Carbon::parse($item->date)->year]]);
            }
        }
    }
}
