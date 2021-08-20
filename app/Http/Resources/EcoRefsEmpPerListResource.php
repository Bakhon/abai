<?php

namespace App\Http\Resources;

use Carbon\Carbon;

class EcoRefsEmpPerListResource extends CrudListResource
{

    protected $modelName = 'ecorefsempper';

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
            'emp_per' => $this-> emp_per -> name,
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}









