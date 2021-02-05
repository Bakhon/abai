<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BigdataReportResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'tag' => $this->tag,
            'is_active' => true
        ];
    }
}
