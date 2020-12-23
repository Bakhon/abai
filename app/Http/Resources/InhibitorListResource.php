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

        $result = [
            'id' => $this->id,
            'fields' => [
                'name' => $this->name,
                'price' => $price->price,
                'date_from' => $price->date_from->format('Y-m-d'),
            ],
            'links' => []
        ];

        if (auth()->user()->can('monitoring read inhibitors')) {
            $result['links']['show'] = route('inhibitors.show', $this->id);
        }
        if (auth()->user()->can('monitoring update inhibitors')) {
            $result['links']['edit'] = route('inhibitors.edit', $this->id);
        }
        if (auth()->user()->can('monitoring delete inhibitors')) {
            $result['links']['delete'] = route('inhibitors.destroy', $this->id);
        }

        return $result;
    }
}
