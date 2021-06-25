<?php

namespace App\Http\Resources;

class GeoMappingListResource extends LasDictionariesResource
{
    protected $modelName = 'file_status';
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
                'well_name' => $this->geo->name_ru
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
