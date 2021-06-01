<?php

namespace App\Http\Resources\BigData;

use Illuminate\Http\Resources\Json\JsonResource;

class WellSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->uwi
        ];
    }
}
