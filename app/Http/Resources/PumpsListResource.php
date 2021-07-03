<?php

namespace App\Http\Resources;

class PumpsListResource extends CrudListResource
{

    protected $modelName = 'pumps';
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
                'ngdu_id' => $this->ngdu->name,
                'gu_id' => $this->gu->name,
                'number' => $this->number,
                'model' => $this->model,
                'type' => $this->type,
                'perfomance' => $this->perfomance,
                'power' => $this->power,
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
