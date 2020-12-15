<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OmgCAListResource extends JsonResource
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
                'gu' => $this->gu ? $this->gu->name : null,
                'date' => \Carbon\Carbon::parse($this->date)->format('Y'),
                'plan_dosage' => $this->plan_dosage,
                'q_v' => $this->q_v,
            ],
            'links' => [
                'show' => route('omgca.show',$this->id),
                'edit' => route('omgca.edit',$this->id),
                'history' => route('omgca.history',$this->id),
                'delete' => route('omgca.destroy',$this->id),
            ]
        ];
    }
}
