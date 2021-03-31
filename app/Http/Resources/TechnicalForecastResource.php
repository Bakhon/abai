<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalForecastResource extends JsonResource
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
            'source_id' => $this -> source_id,
            'gu_id' => $this -> gu_id,
            'well_id' => $this -> well_id,
            'date' => $this -> date,
            'oil' => $this -> oil,
            'liquid' => $this -> liquid,
            'days_worked' => $this -> days_worked,
            'prs' => $this -> prs,
            'comment' => $this -> comment,
            'author_id' => $this -> author_id,
            'created_at' => $this -> created_at,
            'editor_id' => $this -> editor_id,
            'updated_at' => $this -> updated_at,
        ];
    }
}
