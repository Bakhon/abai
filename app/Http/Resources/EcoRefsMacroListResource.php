<?php

namespace App\Http\Resources;

use Carbon\Carbon;

class EcoRefsMacroListResource extends CrudListResource
{

    protected $modelName = 'ecorefsmacro';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'scfa' => $this-> scfa -> name,
            'date' => Carbon::parse($this->date)->format('Y-m'),
            'ex_rate_dol' => $this-> ex_rate_dol,
            'ex_rate_rub' => $this-> ex_rate_rub,
            'inf_end' => $this-> inf_end,
            'barrel_world_price' => $this-> barrel_world_price,
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
