<?php

namespace App\Http\Resources;

class ManualHydroCalcPrepareListResource extends CrudListResource
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
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'out_dia' => $this->pipeType->outside_diameter,
                'wall_thick' => $this->pipeType->thickness,
                'length' => $this->lastCoords->m_distance,
                'name' => $this->name,
                'height_drop' => round($this->lastCoords->elevation - $this->firstCoords->elevation,2),
                'daily_fluid_production' => $this->omgngdu ? $this->omgngdu->daily_fluid_production : '',
                'wc' => $this->omgngdu ? $this->omgngdu->bsw : '',
                'gas_factor' => $this->omgngdu ? $this->omgngdu->gas_factor : '',
                'pressure_start' => $this->omgngdu ? $this->omgngdu->pressure : '',
                'temp_well' => $this->omgngdu ? $this->omgngdu->temperature_well : '',
                'temp_zu' => $this->omgngdu ? $this->omgngdu->temperature_zu : '',
            ],
        ];

        $result['links'] = $this->omgngdu ? ['edit' => route('omgngdu-well.edit', $this->omgngdu->id)] : [];

        return $result;
    }
}
