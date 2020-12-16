<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PipeListResource extends JsonResource
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
                'gu' => $this->gu->name,
                'length' => $this->length,
                'outside_diameter' => $this->outside_diameter,
                'inner_diameter' => $this->inner_diameter,
                'thickness' => $this->thickness,
                'roughness' => $this->roughness,
                'material' => $this->material->name,
                'plot' => $this->plot,
            ],
            'links' => [
                'show' => route('pipes.show', $this->id),
                'edit' => route('pipes.edit', $this->id),
                'history' => route('pipes.history', $this->id),
                'delete' => route('pipes.destroy', $this->id),
            ]
        ];
    }
}
