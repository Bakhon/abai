<?php

namespace App\Http\Resources;

class CorrosionListResource extends CrudListResource
{

    protected $modelName = 'corrosion';
    protected $routeParentName = 'corrosioncrud';

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
                'sample_number' => $this->sample_number,
                'weight_before' => $this->weight_before,
                'days' => $this->days,
                'weight_after' => $this->weight_after,
                'avg_speed' => $this->avg_speed,
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
