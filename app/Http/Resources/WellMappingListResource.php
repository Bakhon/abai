<?php

namespace App\Http\Resources;

class WellMappingListResource extends LasDictionariesResource
{
    protected $modelName = 'well_mapping';
    protected $link = 'well-mapping';

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
                'name' => $this->name_ru,
                'name_in_abai' => $this->well->uwi
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
