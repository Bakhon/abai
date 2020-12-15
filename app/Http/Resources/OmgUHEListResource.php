<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OmgUHEListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fields' => [
                'field' => $this->field->name,
                'ngdu' => $this->ngdu->name,
                'cdng' => $this->cdng->name,
                'gu' => $this->gu->name,
                'zu' => $this->zu->name,
                'well' => $this->well->name,
                'date' => $this->date,
                'current_dosage' => $this->current_dosage,
                'daily_inhibitor_flowrate' => $this->daily_inhibitor_flowrate,
                'out_of_service_оf_dosing' => $this->out_of_service_оf_dosing ? 'Был простой' : 'Не было простоя',
                'reason' => $this->reason,
            ],
            'links' => [
                'show' => route('omguhe.show',$this->id),
                'edit' => route('omguhe.edit',$this->id),
                'history' => route('omguhe.history',$this->id),
                'delete' => route('omguhe.destroy',$this->id),
            ]
        ];

    }
}
