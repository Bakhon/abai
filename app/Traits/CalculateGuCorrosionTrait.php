<?php

namespace App\Traits;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\POSTCaller;
use App\Models\ComplicationMonitoring\CalculatedCorrosion;
use App\Models\ComplicationMonitoring\Gu;
use Illuminate\Http\Request;

trait CalculateGuCorrosionTrait
{
    public $date;

    public function calculateCorrosion(Gu $gu)
    {
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
                'dt' => $this->date,
                'gu_id' => $gu->id
            ]
        );

        $guDataByDay = $post->call()->getData();

        if (!$this->isValidParams($guDataByDay, $guData)) {
            return 'Not enough data for ' . $gu->name . ' on ' . $this->date;
        }

        $data = $this->setParams($gu, $guDataByDay, $guData);

        $post = new POSTCaller(
            DruidController::class,
            'corrosion',
            Request::class,
            $data
        );
        $corrosion = $post->call()->getData();

        $calcCorrosion = CalculatedCorrosion::firstOrNew(
            [
                'date' => $this->date,
                'gu_id' => $gu->id
            ]
        );

        $calcCorrosion->corrosion = $corrosion->corrosion_rate_mm_per_y_point_A;
        $calcCorrosion->save();

        return 'GU ' . $gu->name . ' corrosion ' . $corrosion->corrosion_rate_mm_per_y_point_A;
    }

    public function isValidParams($guDataByDay, $guData)
    {
        return ($guDataByDay->oilGas &&
            $guData->pipe &&
            $guDataByDay->ngdu &&
            $guDataByDay->ngdu->surge_tank_pressure &&
            $guDataByDay->ngdu->pump_discharge_pressure);
    }

    public function setParams($gu, $guDataByDay, $guData)
    {
        return [
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
    }
}