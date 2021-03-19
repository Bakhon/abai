<?php

namespace App\Http\Resources\BigData;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'payload' => $this->payload,
            'updated_at' => $this->updated_at,
            'user' => $this->user->name
        ];
    }
}
