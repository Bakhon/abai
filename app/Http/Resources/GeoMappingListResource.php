<?php

namespace App\Http\Resources;

class GeoMappingListResource extends LasDictionariesResource
{
    protected $modelName = 'geo_mapping';
    protected $link = 'geo-mapping';

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
                'name_in_abai' => $this->geo->name_ru
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
