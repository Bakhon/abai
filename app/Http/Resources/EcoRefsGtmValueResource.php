<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EcoRefsGtmValueResource extends JsonResource
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
            $this->date,
            $this->gtm->name ?? '',
            $this->priority,
            $this->growth,
            $this->amount,
            $this->comment,
            $this->created_at
        ];
    }
}
