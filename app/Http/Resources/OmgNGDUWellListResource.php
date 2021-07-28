<?php

namespace App\Http\Resources;

class OmgNGDUWellListResource extends CrudListResource
{

    protected $modelName = 'omgngdu_well';

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
                'zu' => $this->zu->name,
                'well' => $this->well->name,
                'date' => $this->date,
                'bsw' => $this->bsw,
                'daily_fluid_production' => $this->daily_fluid_production,
                'daily_water_production' => $this->daily_water_production,
                'daily_oil_production' => $this->daily_oil_production,
                'gas_factor' => $this->gas_factor,
                'pressure' => $this->pressure,
                'temperature' => $this->temperature,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;

    }
}
