<?php

namespace App\Http\Resources;

class PipePassportListResource extends CrudListResource
{

    protected $modelName = 'pipe-passport';
    protected $routeParentName = 'pipe-passport';

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
                'field' => $this->field,
                'ngdu' => $this->ngdu,
                'cdng' => $this->cdng,
                'gu' => $this->gu,
                'name' => $this->name,
                'main_reserved' => $this->main_reserved,
                'from' => $this->from,
                'to' => $this->to,
                'length' => $this->length,
                'diameter' => $this->diameter,
                'thickness' => $this->thickness,
                'material' => $this->material,
                'installation_date' => $this->installation_date,
                'condition' => $this->condition,
                'gusts' => $this->gusts,
                'data_sheet' => $this->data_sheet ? __('app.yes') : __('app.no'),
                'used' => $this->used ? __('monitoring.pipe_passport.used') : '',
                'comment' => $this->comment,
            ]
        ];

        $result['links'] = $this->getLinks('update', 'history', 'delete');

        return $result;
    }
}
