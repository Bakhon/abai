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
                'сorrosion' => round($this->сorrosion, 2),
                'actual_inhibitor_injection' => round($this->actual_inhibitor_injection, 2),
                'recommended_inhibitor_injection' => round($this->recommended_inhibitor_injection, 2),
                'difference' => round($this->difference, 2),
                'inhibitor_price' => round($this->inhibitor_price, 2),
                'economical_effect' => round($this->economical_effect, 2),
                'economical_effect_sum' => round($this->economical_effect_sum, 2)
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
