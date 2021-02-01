<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
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
                'username' => $this->username,
                'org' => $this->org ? $this->org->name : null,
                'created_at' => $this->created_at->format('Y-m-d'),
                'last_authorized_at' => $this->last_authorized_at->format('Y-m-d'),
            ],
            'links' => [
                'edit' => route('admin.users.edit', $this->id),
            ]
        ];
    }
}
