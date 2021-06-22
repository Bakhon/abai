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
                'gu' => $this->gu->name,
                'background_corrosion_velocity' => $this->background_corrosion_velocity,
                'date_for_corrosion' => $this->date_for_corrosion,
                'carbon_dioxide' => $this->carbon_dioxide,
                'date_for_carbon_dioxide' => $this->date_for_carbon_dioxide,
                'volume_fractions_for_carbon_dioxide' => $this->volume_fractions_for_carbon_dioxide,
                'surge_tank_pressure' => $this->surge_tank_pressure,
                'carbon_dioxide_pressure' => $this->carbon_dioxide_pressure,
                'hydrogen_sulfide_in_gas' => $this->hydrogen_sulfide_in_gas,
                'date_for_hydrogen_sulfide' => $this->date_for_hydrogen_sulfide,
                'volume_fractions_for_hydrogen_sulfide' => $this->volume_fractions_for_hydrogen_sulfide,
                'hydrogen_sulfide_in_gas' =>  $this->hydrogen_sulfide_in_gas,
                'calculated_corrosion_speed' => $this->calculated_corrosion_speed,

                ]
            
            
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
