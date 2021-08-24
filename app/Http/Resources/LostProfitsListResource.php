<?php

namespace App\Http\Resources;

class LostProfitsListResource extends CrudListResource
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
                'lost_profits' => round($this->lost_profits, 2),
                'lost_profits_sum' => round($this->lost_profits_sum, 2)
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
