<?php

namespace App\Http\Resources;

class ZusCleaningListResource extends CrudListResource
{

    protected $modelName = 'zu-cleanings';
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
                'zu_id' => $this->zu->name,
                'date' => $this->date,
                'number_of_failures' => $this->number_of_failures,
                ]
        ];

        $result['links'] = $this->getLinks();

        

        return $result;

    }
    

}