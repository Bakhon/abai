<?php

namespace App\Http\Resources;

class HydroCalcListResource extends CrudListResource
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
                'start_point' => $this->name,
                'out_dia' => $this->map_pipe->pipeType->outside_diameter,
                'wall_thick' => $this->map_pipe->pipeType->thickness,
                'length' => $this->map_pipe->lastCoords->m_distance,
                'name' => $this->map_pipe->name,
                'height_drop' => round($this->map_pipe->lastCoords->elevation - $this->map_pipe->firstCoords->elevation,2),
                'end_point' => $this->trunkline_end_point ? $this->trunkline_end_point->name : '',
                'qliq' => $this->lastOmgngdu ? $this->lastOmgngdu->daily_fluid_production : '',
                'wc' => $this->lastOmgngdu ? $this->lastOmgngdu->bsw : '',
                'gazf' => $this->gu ? 0 : '',
                'press_start' => $this->lastOmgngdu ? $this->lastOmgngdu->pump_discharge_pressure : '',
                'temp_start' => $this->lastOmgngdu ? $this->lastOmgngdu->heater_output_temperature : '',
            ],
        ];

        $result['links'] = [];

        return $result;
    }
}
