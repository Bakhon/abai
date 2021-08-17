<?php

namespace App\Http\Resources;

use Carbon\Carbon;

class EcoRefsTarifyTnListResource extends CrudListResource
{

    protected $modelName = 'ecorefstarifytn';

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
            'branch' => $this-> branch -> name,
            'company' => $this-> company -> name,
            'direction' => $this-> direction -> name,
            'route' => $this-> route -> name,
            'routetn' => $this-> routetn -> name,
            'exc' => $this-> exc -> name,
            'date' => Carbon::parse($this->date)->format('Y-m'),
            'tn_rate' => $this-> tn_rate -> name,
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}









