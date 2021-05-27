<?php

namespace App\Http\Resources;

class StemTypeResource extends CrudListResource
{
    protected $modelName = 'stem_type';

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
                'name' => $this->name_ru
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
