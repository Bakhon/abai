<?php

namespace App\Http\Resources;

class MeteringUnitsListResource extends CrudListResource
{

    protected $modelName = 'metering-units';
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
                'model' => $this->model,
                'type' => $this->type,
                'diameter' => $this->diameter,
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