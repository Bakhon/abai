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
                'сorrosion' => $this->сorrosion,
                'actual_inhibitor_injection' => $this->actual_inhibitor_injection,
                'recommended_inhibitor_injection' => $this->recommended_inhibitor_injection,
                'difference' => $this->difference,
                'inhibitor_price' => $this->inhibitor_price,
                'lost_profits' => $this->lost_profits,
                'lost_profits_sum' => $this->lost_profits_sum,
            ],
        ];

        $result['links'] = $this->getLinks();

        return $result;
    }
}
