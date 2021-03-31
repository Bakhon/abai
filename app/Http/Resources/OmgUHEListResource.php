<?php

namespace App\Http\Resources;

class OmgUHEListResource extends CrudListResource
{

    protected $modelName = 'omguhe';

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
                'field' => $this->field->name,
                'ngdu' => $this->ngdu->name,
                'cdng' => $this->cdng->name,
                'gu' => $this->gu->name,
                'zu' => $this->zu->name,
                'level' => $this->level,
                'fill' => $this->fill,
                'well' => $this->well->name,
                'date' => $this->date->format('d.m.Y H:i'),
                'inhibitor' => $this->inhibitor->name,
                'current_dosage' => $this->current_dosage,
                'daily_inhibitor_flowrate' => $this->daily_inhibitor_flowrate,
                'out_of_service_of_dosing' => $this->out_of_service_of_dosing ? 'Был простой' : 'Не было простоя',
                'reason' => $this->reason,
                'consumption' => $this->consumption,
                'yearly_inhibitor_flowrate' => $this->yearly_inhibitor_flowrate
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;

    }
}
