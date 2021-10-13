<?php

namespace App\Http\Resources;

class ManualHydroCalcListResource extends CrudListResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = isset($this->fluid_speed) ? $this->calculated() : $this->prepaired();

        $result['links'] = $this->omgngdu ? ['edit' => route('omgngdu-well.edit', $this->omgngdu->id)] : [];

        return $result;
    }

    public function calculated()
    {
        return [
            'id' => $this->id,
            'fields' => [
                'check_calc' => $this->oilPipe->gu_id,
                'id' => $this->id,
                'gu_name' => $this->oilPipe->gu ? $this->oilPipe->gu->name : '',
                'date' => $this->date,
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'out_dia' => $this->oilPipe->pipeType->outside_diameter,
                'wall_thick' => $this->oilPipe->pipeType->thickness,
                'length' => $this->length,
                'name' => $this->oilPipe->name,
                'height_drop' => round($this->height_drop, 2),
                'daily_fluid_production' => $this->qliq,
                'wc' => $this->bsw,
                'gas_factor' => $this->gazf,
                'pressure_start' => $this->press_start,
                'pressure_end' => $this->press_end,
                'temp_start' => $this->temperature_start,
                'temp_end' => $this->temperature_end,
                'mix_speed_avg' => $this->mix_speed_avg,
                'fluid_speed' => $this->fluid_speed,
                'gaz_speed' => $this->gaz_speed,
                'flow_type' => $this->flow_type,
                'press_change' => round($this->press_change, 4),
                'break_qty' => $this->break_qty
            ],
        ];
    }

    public function prepaired()
    {
        if (!$this->pipeType) {
            dd($this);
        }
        return [
            'id' => $this->id,
            'fields' => [
                'check_calc' => $this->gu_id,
                'id' => $this->id,
                'gu_name' => $this->gu ? $this->gu->name : '',
                'date' => $this->omgngdu ? $this->omgngdu->date : '',
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'out_dia' => $this->pipeType->outside_diameter,
                'wall_thick' => $this->pipeType->thickness,
                'length' => $this->lastCoords->m_distance,
                'name' => $this->name,
                'height_drop' => round($this->lastCoords->elevation - $this->firstCoords->elevation, 2),
                'daily_fluid_production' => $this->omgngdu ? $this->omgngdu->daily_fluid_production : '',
                'wc' => $this->omgngdu ? $this->omgngdu->bsw : '',
                'gas_factor' => $this->omgngdu ? $this->omgngdu->gas_factor : '',
                'pressure_start' => $this->omgngdu ? $this->omgngdu->pressure : '',
                'temp_start' => $this->omgngdu ? $this->omgngdu->temperature_well : '',
                'temp_end' => $this->omgngdu ? (isset($this->omgngdu->heater_inlet_temperature) ? $this->omgngdu->heater_inlet_temperature : $this->omgngdu->temperature_zu) : '',
            ],
        ];
    }
}
