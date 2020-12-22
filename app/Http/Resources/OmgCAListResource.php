<?php

namespace App\Http\Resources;

class OmgCAListResource extends CrudListResource
{

    protected $modelName = 'omgca';

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
                'gu' => $this->gu ? $this->gu->name : null,
                'date' => \Carbon\Carbon::parse($this->date)->format('Y'),
                'plan_dosage' => $this->plan_dosage,
                'q_v' => $this->q_v,
            ]
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
