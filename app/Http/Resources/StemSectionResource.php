<?php

namespace App\Http\Resources;

class StemSectionResource extends CrudListResource
{
    protected $modelName = 'stem_section';

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
                'name' => $this->name
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
