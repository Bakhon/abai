<?php

namespace App\Http\Resources;

class SibListResource extends CrudListResource
{

    protected $modelName = 'sib';
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
                'gu' => $this->gu ? $this->gu->name : '',
                'cipher' => $this->cipher,
                'type' => $this->type,
                'volume' => $this->volume,
                'date_of_exploitation' => $this->date_of_exploitation,
                'current_state' => $this->current_state,
                'date_of_repair' => $this->date_of_repair,
                'type_of_repair' => $this->type_of_repair,
                'pdf' => $this->pdf
                ]
            ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}