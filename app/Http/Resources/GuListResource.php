<?php

namespace App\Http\Resources;

class GuListResource extends CrudListResource
{

    protected $modelName = 'gu';
    protected $routeParentName = 'gus';

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
                'cdng' => $this->cdng ? $this->cdng->name : null,
                'lat' => $this->lat,
                'lon' => $this->lon,
            ]
        ];

        $result['links'] = $this->getLinks('update', 'history', 'delete');

        return $result;
    }
}
