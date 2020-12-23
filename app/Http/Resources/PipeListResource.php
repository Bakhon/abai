<?php

namespace App\Http\Resources;

class PipeListResource extends CrudListResource
{

    protected $modelName = 'pipes';

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
                'gu' => $this->gu->name,
                'length' => $this->length,
                'outside_diameter' => $this->outside_diameter,
                'inner_diameter' => $this->inner_diameter,
                'thickness' => $this->thickness,
                'roughness' => $this->roughness,
                'material' => $this->material->name,
                'plot' => $this->plot,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
