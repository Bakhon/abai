<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuZuPipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $coords = array_map(
            function ($coord) {
                return [
                    round($coord[1], 8),
                    round($coord[0], 8),
                ];
            },
            $this->coordinates
        );

        return [
            'id' => $this->id,
            'color' => [255, 0, 0],
            'name' => (string)$this->id,
            'zu_id' => $this->zu_id,
            'gu_id' => $this->gu_id,
            'coordinates' => $coords,
        ];
    }
}
