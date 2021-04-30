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
        $result = [
            'id' => $this->id,
            'fields' => [
                'id' => $this->id,
                'date' => $this->date,
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'out_dia' => $this->oilPipe->pipeType->outside_diameter,
                'wall_thick' => $this->oilPipe->pipeType->thickness,
                'length' => $this->length,
                'name' => $this->oilPipe->name,
                'height_drop' => round($this->height_drop, 2),
                'qliq' => $this->qliq,
                'wc' => $this->bsw,
                'gazf' => $this->gazf,
                'press_start' => $this->press_start,
                'press_end' => $this->press_end,
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

        $result['links'] = [];

        return $result;
    }
}
