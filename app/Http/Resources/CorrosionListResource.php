<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CorrosionListResource extends JsonResource
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
                'start_date_of_background_corrosion' => $this->start_date_of_background_corrosion,
                'final_date_of_background_corrosion' => $this->final_date_of_background_corrosion,
                'background_corrosion_velocity' => $this->background_corrosion_velocity,
                'start_date_of_corrosion_velocity_with_inhibitor_measure' => $this->start_date_of_corrosion_velocity_with_inhibitor_measure,
                'final_date_of_corrosion_velocity_with_inhibitor_measure' => $this->final_date_of_corrosion_velocity_with_inhibitor_measure,
                'corrosion_velocity_with_inhibitor' => $this->corrosion_velocity_with_inhibitor,
            ],
            'links' => [
                'show' => route('corrosioncrud.show', $this->id),
                'edit' => route('corrosioncrud.edit', $this->id),
                'history' => route('corrosioncrud.history', $this->id),
                'delete' => route('corrosioncrud.destroy', $this->id),
            ]
        ];
    }
}
