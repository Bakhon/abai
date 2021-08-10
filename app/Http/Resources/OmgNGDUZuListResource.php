<?php

namespace App\Http\Resources;

class OmgNGDUZuListResource extends CrudListResource
{

    protected $modelName = 'omgngdu_zu';
    protected $routeParentName = 'omgngdu-zu';

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
                'zu' => $this->zu ? $this->zu->name : $this->manual_zu->name,
                'date' => $this->date,
                'bsw' => $this->bsw,
                'daily_fluid_production' => $this->daily_fluid_production,
                'daily_water_production' => $this->daily_water_production,
                'daily_oil_production' => $this->daily_oil_production,
                'gas_factor' => $this->gas_factor,
                'pressure' => $this->pressure,
                'temperature' => $this->temperature,
                'sg_oil' => $this->sg_oil,
                'sg_gas' => $this->sg_gas,
                'sg_water' => $this->sg_water,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;

    }
}
