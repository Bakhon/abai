<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OmgNGDUListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fields' => [
                'field' => $this->field->name,
                'ngdu' => $this->ngdu->name,
                'cdng' => $this->cdng->name,
                'gu' => $this->gu->name,
                'zu' => $this->zu->name,
                'well' => $this->well->name,
                'date' => $this->date,
                'bsw' => $this->bsw,
                'daily_fluid_production' => $this->daily_fluid_production,
                'daily_water_production' => $this->daily_water_production,
                'daily_oil_production' => $this->daily_oil_production,
                'daily_gas_production_in_sib' => $this->daily_gas_production_in_sib,
                'surge_tank_pressure' => $this->surge_tank_pressure,
                'pump_discharge_pressure' => $this->pump_discharge_pressure,
                'heater_inlet_pressure' => $this->heater_inlet_pressure,
                'heater_output_pressure' => $this->heater_output_pressure,
            ],
            'links' => [
                'show' => route('omgngdu.show',$this->id),
                'edit' => route('omgngdu.edit',$this->id),
                'history' => route('omgngdu.history',$this->id),
                'delete' => route('omgngdu.destroy',$this->id),
            ]
        ];

    }
}
