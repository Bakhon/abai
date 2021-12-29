<?php

namespace App\Http\Resources;

class ReverseCalculationResource extends CrudListResource
{
    public function toArray($request)
    {
        $result = isset($this->fluid_speed) ? $this->calculated() : $this->prepaired();

        $result['links'] = $this->omgngdu ? ['edit' => route('omgngdu-well.edit', $this->omgngdu->id)] : [];

        return $result;
    }

    public function prepaired()
    {
        $gas_factor = $this->omgngdu ? ($this->omgngdu->gas_factor ? $this->omgngdu->gas_factor : ($this->omgngdu->lastWellData ? $this->omgngdu->lastWellData->gas_factor : '')) : '';
        $bsw = $this->omgngdu ? ($this->omgngdu->bsw ? $this->omgngdu->bsw : ($this->omgngdu->lastWellData ? $this->omgngdu->lastWellData->bsw : '')) : '';
        //кгс/см переводятся в бар
        $pressure_end = $this->omgngdu_gu ? round($this->omgngdu_gu->surge_tank_pressure * 98000 / 100000, 2) : '';

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
                'bsw' => round($bsw, 2),
                'gas_factor' => round($gas_factor, 2),
                'pressure_start' => '',
                'pressure_end' => $pressure_end,
                'temp_start' => '',
                'temp_end' => $this->omgngdu ? round($this->omgngdu->temperature_zu, 2) : '',
                'mix_speed_avg' => $this->mix_speed_avg,
                'fluid_speed' => $this->fluid_speed,
                'gaz_speed' => $this->gaz_speed,
                'flow_type' => $this->flow_type,
                'press_change' => $this->press_change,
                'break_qty' => $this->break_qty
            ],
        ];

        $result['links'] = [];

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
                'daily_fluid_production' => round($this->qliq, 2),
                'bsw' => round($this->bsw, 2),
                'gas_factor' => round($this->gazf, 2),
                // атмосферы абс. в бар изб.
                'pressure_start' => round(($this->press_start - 1) * 101325 / 100000, 2),
                'pressure_end' => round(($this->press_end - 1) * 101325 / 100000, 2),
                'temp_start' => round($this->temperature_start, 2),
                'temp_end' => round($this->temperature_end, 2),
                'mix_speed_avg' => round($this->mix_speed_avg, 2),
                'fluid_speed' => round($this->fluid_speed, 2),
                'gaz_speed' => round($this->gaz_speed, 2),
                'flow_type' => round($this->flow_type, 2),
                'press_change' => round($this->press_change, 4),
                'break_qty' => $this->break_qty
            ],
        ];
    }
}
