<?php

namespace App\Http\Resources;

class EconomicalEffectListResource extends CrudListResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'fields' => [
                'gu' => $this->gu->name,
                'date' => $this->date,
                'сorrosion' => $this->сorrosion,
                'actual_inhibitor_injection' => $this->actual_inhibitor_injection,
                'recommended_inhibitor_injection' => $this->recommended_inhibitor_injection,
                'difference' => $this->difference,
                'inhibitor_price' => $this->inhibitor_price,
                'economical_effect' => $this->economical_effect,
                'economical_effect_sum' => $this->economical_effect_sum,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
