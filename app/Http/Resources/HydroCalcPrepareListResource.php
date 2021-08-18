<?php

namespace App\Http\Resources;

class HydroCalcPrepareListResource extends CrudListResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'fields' => [
                'id' => $this->id,
                'date' => $this->omgngdu ? $this->omgngdu->date : '',
                'start_point' => $this->name,
                'out_dia' => $this->oilPipe->pipeType->outside_diameter,
                'wall_thick' => $this->oilPipe->pipeType->thickness,
                'length' => $this->oilPipe->lastCoords->m_distance,
                'name' => $this->oilPipe->name,
                'height_drop' => round($this->oilPipe->lastCoords->elevation - $this->oilPipe->firstCoords->elevation,2),
                'end_point' => $this->trunkline_end_point ? $this->trunkline_end_point->name : '',
                'qliq' => $this->omgngdu ? $this->omgngdu->daily_fluid_production : '',
                'wc' => $this->omgngdu ? $this->omgngdu->bsw : '',
                'gazf' => $this->gu ? 0 : '',
                'press_start' => $this->omgngdu ? $this->omgngdu->pump_discharge_pressure + 1 : '',
                'temp_start' => $this->omgngdu ? $this->omgngdu->heater_output_temperature : '',
            ],
        ];

        $result['links'] = $this->omgngdu ? ['edit' => route('omgngdu.edit', $this->omgngdu->id)] : [];

        return $result;
    }
}
