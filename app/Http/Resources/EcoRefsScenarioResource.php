<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EcoRefsScenarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->id,
            $this->name,
            $this->scFa->name ?? '',
            $this->params['oil_prices'],
            $this->params['course_prices'],
            $this->params['optimizations'],
            $this->created_at
        ];
    }
}
