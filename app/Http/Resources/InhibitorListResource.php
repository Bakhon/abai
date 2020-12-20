<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InhibitorListResource extends JsonResource
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
            'fields' => [
                'name' => $this->name,
                'price' => $price->price,
                'date_from' => $price->date_from->format('Y-m-d'),
            ],
            'links' => [
                'show' => route('inhibitors.show', $this->id),
                'edit' => route('inhibitors.edit', $this->id),
                'delete' => route('inhibitors.destroy', $this->id),
            ]
        ];
    }
}
