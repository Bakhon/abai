<?php

namespace App\Http\Resources;

class BufferTankListResource extends CrudListResource
{

    protected $modelName = 'buffer_tank';
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
                'field' => $this->field->name,
                'ngdu_id' => $this->ngdu->name,
                'cdng_id' => $this->cdng->name,
                'gu_id' => $this->gu->name,
                'model' => $this->model,
                'name' => $this->name,
                'type' => $this->type,
                'volume' => $this->volume,
                'date_of_exploitation' => $this->date_of_exploitation,
                'current_state' => $this->current_state,
                'extarnal_and_internal_inspection' => $this->extarnal_and_internal_inspection,
                'hydraulic_test' => $this->hydraulic_test,
                'date_of_repair' => $this->date_of_repair,
                'type_of_repair' => $this->type_of_repair,
                ]  
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
