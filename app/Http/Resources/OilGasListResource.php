<?php

namespace App\Http\Resources;

class OilGasListResource extends CrudListResource
{

    protected $modelName = 'oilgas';

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
                'other_objects' => $this->other_objects->name,
                'ngdu' => $this->ngdu->name,
                'cdng' => $this->cdng->name,
                'gu' => $this->gu->name,
                'zu' => $this->zu->name,
                'well' => $this->well->name,
                'date' => $this->date,
                'water_density_at_20' => $this->water_density_at_20,
                'oil_viscosity_at_20' => $this->oil_viscosity_at_20,
                'oil_viscosity_at_40' => $this->oil_viscosity_at_40,
                'oil_viscosity_at_50' => $this->oil_viscosity_at_50,
                'oil_viscosity_at_60' => $this->oil_viscosity_at_60,
                'hydrogen_sulfide_in_gas' => $this->hydrogen_sulfide_in_gas,
                'oxygen_in_gas' => $this->oxygen_in_gas,
                'carbon_dioxide_in_gas' => $this->carbon_dioxide_in_gas,
                'gas_density_at_20' => $this->gas_density_at_20,
                'gas_viscosity_at_20' => $this->gas_viscosity_at_20,

            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
