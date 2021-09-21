<?php

namespace App\Http\Resources;

class AgzuListResource extends CrudListResource
{

    protected $modelName = 'agzu';
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
                'method_of_measurement' => $this->method_of_measurement,
                'number_of_connected_wells' => $this->number_of_connected_wells,
                'date_of_exploitation' => $this->date_of_exploitation,
                'current_state' => $this->current_state,
                'date_of_repair' => $this->date_of_repair,
                'type_of_repair' => $this->type_of_repair,
                'passport_pdf' => $this->passport_pdf,
                'certificate' => $this->certificate,
                ]
        ];

        $result['links'] = $this->getLinks();

        

        return $result;

    }
    

}