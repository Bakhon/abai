<?php

namespace App\Console\Commands;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\POSTCaller;
use App\Models\ComplicationMonitoring\CalculatedCorrosion;
use App\Models\ComplicationMonitoring\Gu;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalculateGuCorrosionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate-gu-corrosion:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate corrosion on point A for each GU for yesterday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('calculate_corrosion_yesterday:cron')->info('Calculate  run');

        $gus = Gu::whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $date = Carbon::yesterday()->format('Y-m-d');
        Log::channel('calculate_corrosion_yesterday:cron')->info('Yesterday date ' . $date);

        foreach ($gus as $gu) {
            $post = new POSTCaller(
                WaterMeasurementController::class,
                'getGuData',
                Request::class,
                [
                    'gu_id' => $gu->id
                ]
            );

            $guData = $post->call()->getData();

            $post = new POSTCaller(
                OmgNGDUController::class,
                'getGuDataByDay',
                Request::class,
                [
                    'dt' => $date->format('Y-m-d'),
                    'gu_id' => $gu->id
                ]
            );

            $guDataByDay = $post->call()->getData();

            if ($guDataByDay->oilGas &&
                $guData->pipe &&
                $guDataByDay->ngdu &&
                $guDataByDay->ngdu->surge_tank_pressure &&
                $guDataByDay->ngdu->pump_discharge_pressure) {
                $data = [
                    "gu_id" => $gu->id,
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

                $message = 'GU ' . $gu->name . ' corrosion ' . $corrosion->corrosion_rate_mm_per_y_point_A;
                Log::channel('calculate_corrosion_yesterday:cron')->info($message);

                $calcCorrosion = CalculatedCorrosion::firstOrNew(
                    [
                        'date' => $date->format('Y-m-d'),
                        'gu_id' => $gu->id
                    ]
                );

                $calcCorrosion->corrosion = $corrosion->corrosion_rate_mm_per_y_point_A;
                $calcCorrosion->save();
            }
        }

        Log::channel('calculate_corrosion_yesterday:cron')->info('Сalculation completed');
    }
}
