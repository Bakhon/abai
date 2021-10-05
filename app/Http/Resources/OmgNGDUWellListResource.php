<?php

namespace App\Http\Resources;

class OmgNGDUWellListResource extends CrudListResource
{

    protected $modelName = 'omgngdu_well';
    protected $routeParentName = 'omgngdu-well';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $daily_gas_production = round($this->gas_factor * $this->daily_fluid_production * (1 - $this->bsw / 100) , 2);

        $result = [
            'id' => $this->id,
            'fields' => [
                'zu' => $this->zu ? $this->zu->name : ($this->manualZu ? $this->manualZu->name : ''),
                'well' => $this->well ? $this->well->name : ($this->manualWell ? $this->manualWell->name : ''),
                'date' => $this->date,
                'bsw' => $this->bsw,
                'daily_fluid_production' => $this->daily_fluid_production,
                'daily_water_production' => $this->daily_water_production,
                'daily_oil_production' => $this->daily_oil_production,
                'gas_factor' => $daily_gas_production ? $daily_gas_production : '',
                'pressure' => $this->pressure,
                'temperature' => $this->temperature_zu,
                'sg_oil' => $this->sg_oil,
                'sg_gas' => $this->sg_gas,
                'sg_water' => $this->sg_water,
            ],
        ];

        $result['links'] = $this->getLinks('update', 'delete');

        return $result;
    }
}
