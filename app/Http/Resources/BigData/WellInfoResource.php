<?php

namespace App\Http\Resources\BigData;

use Illuminate\Http\Resources\Json\JsonResource;

class WellInfoResource extends JsonResource
{
    public function toArray($request)
    {
        return[
            'name_ru' => $this -> name_ru,
        ];
    }
}
