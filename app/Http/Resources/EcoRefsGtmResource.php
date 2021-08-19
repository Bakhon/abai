<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EcoRefsGtmResource extends JsonResource
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
            $this->company->name ?? '',
            $this->price,
            $this->pi,
            $this->comment,
            $this->created_at
        ];
    }
}
