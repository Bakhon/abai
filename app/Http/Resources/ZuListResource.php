<?php

namespace App\Http\Resources;

class ZuListResource extends CrudListResource
{

    protected $modelName = 'zu';
    protected $routeParentName = 'zus';

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
                'name' => $this->name,
                'gu' => $this->gu ? $this->gu->name : null,
                'lat' => $this->lat,
                'lon' => $this->lon,
            ]
        ];

        $result['links'] = $this->getLinks('update', 'history', 'delete');

        return $result;
    }
}
