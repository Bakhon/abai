<?php

namespace App\Http\Resources;

class MaterialListResource extends CrudListResource
{
    protected $modelName = 'materials';

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
                'yield_point' => $this->yield_point,
                'roughness' => $this->roughness,
                'material' => $this->material->name,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}