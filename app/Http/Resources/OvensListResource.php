<?php

namespace App\Http\Resources;

class OvensListResource extends CrudListResource
{

    protected $modelName = 'ovens';
    protected $routeParentName;

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
                'gu_id' => $this->gu->name,
                'cipher' => $this->cipher,
                'type' => $this->type,
                'rated_heat_output' => $this->rated_heat_output,
                'date_of_exploitation' => $this->date_of_exploitation,
                'current_state' => $this->current_state,
                'date_of_repair' => $this->date_of_repair,
                'type_of_repair' => $this->type_of_repair,
                ]
            
            
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}