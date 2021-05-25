<?php

namespace App\Http\Resources;

class RecordingMethodResource extends CrudListResource
{
    protected $modelName = 'recording_method';

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
