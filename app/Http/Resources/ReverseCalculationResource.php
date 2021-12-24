<?php

namespace App\Http\Resources;

class ReverseCalculationResource extends CrudListResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $gas_factor = $this->omgngdu ? ($this->omgngdu->gas_factor ? $this->omgngdu->gas_factor : ($this->omgngdu->lastWellData ? $this->omgngdu->lastWellData->gas_factor : '')) : '';
        $bsw = $this->omgngdu ? ($this->omgngdu->bsw ? $this->omgngdu->bsw : ($this->omgngdu->lastWellData ? $this->omgngdu->lastWellData->bsw : '')) : '';
        //кгс/см переводятся в бар
        $pressure_end = $this->omgngdu_gu ? $this->omgngdu_gu->surge_tank_pressure  * 98000/100000 : '';

        $result = [
            'id' => $this->id,
            'fields' => [
                'id' => $this->id,
                'gu_name' => $this->gu ? $this->gu->name : '',
                'date' => $this->omgngdu ? $this->omgngdu->date : '',
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'out_dia' => $this->pipeType->outside_diameter,
                'wall_thick' => $this->pipeType->thickness,
                'length' => $this->lastCoords->m_distance,
                'name' => $this->name,
                'height_drop' => round($this->height_drop, 2),
                'daily_fluid_production' => $this->omgngdu ? $this->omgngdu->daily_fluid_production : '',
                'bsw' => $bsw,
                'gas_factor' => $gas_factor,
                'pressure_start' => '',
                'pressure_end' => $pressure_end,
                'temp_start' => '',
                'temp_end' => $this->omgngdu ? $this->omgngdu->temperature_zu : '',
                'mix_speed_avg' => $this->mix_speed_avg,
                'fluid_speed' => $this->fluid_speed,
                'gaz_speed' => $this->gaz_speed,
                'flow_type' => $this->flow_type,
                'press_change' => round($this->press_change, 4),
                'break_qty' => $this->break_qty
            ],
        ];

        $result['links'] = [];

        return $result;
    }
}
