<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BigdataSectionResource extends JsonResource
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
            'tag' => $this->tag,
            'icon' => $this->icon,
            'reports' => BigdataReportResource::collection($this->reports)
        ];
    }
}
