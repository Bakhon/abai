<?php

namespace App\Http\Resources\BigData;

use Illuminate\Http\Resources\Json\JsonResource;

class WellInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'name_ru' => $this -> name_ru,
        ];
    }
}
