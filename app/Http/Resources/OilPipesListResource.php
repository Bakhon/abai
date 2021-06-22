<?php

namespace App\Http\Resources;

class OilPipesListResource extends CrudListResource
{

    protected $modelName = 'oilgas';

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
                'ngdu_id' => $this->ngdu->name,
                'gu_id' => $this->gu->name,
                'zu_id' => $this->zu->name,
                'well_id' => $this->well->name,
                'type_id' => $this->type,
                'between_points' => $this->between_points,
                'comment' => $this->comment,
                'start_point' => $this->start_point,
                'end_point' => $this->end_point,
                'material_id' => $this->material,
            ]
        ];

        $result['links'] = $this->getLinks();



        // dd($this);
        return $result;
    }
}
