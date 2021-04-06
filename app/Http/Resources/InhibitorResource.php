<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InhibitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $price = $this->prices->whereNull('date_to')->last();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'density' => $this->density,
            'price' => $price->price,
            'minDate' => $price->date_from
        ];
    }
}
