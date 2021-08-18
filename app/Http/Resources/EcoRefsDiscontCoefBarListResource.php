<?php

namespace App\Http\Resources;

use Carbon\Carbon;

class EcoRefsDiscontCoefBarListResource extends CrudListResource
{

    protected $modelName = 'ecorefsdiscontcoefbar';

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
            'company' => $this-> company -> name,
            'direction' => $this-> direction -> name,
            'route' => $this-> route -> name,
            'date' => Carbon::parse($this->date)->format('Y-m'),
            'barr_coef' => $this-> barr_coef -> name,
            'discont' => $this-> discont -> name,
            'macro' => $this-> macro -> name,
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}









