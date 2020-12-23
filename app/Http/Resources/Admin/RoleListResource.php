<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleListResource extends JsonResource
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
            'fields' => [
                'name' => $this->name,
            ],
            'links' => [
                'edit' => route('admin.roles.edit', $this->id),
                'delete' => route('admin.roles.destroy', $this->id),
            ]
        ];
    }
}
