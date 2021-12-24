<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
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
            'username' => $this->username,
            'check_org_permissions' => $this->check_org_permissions,
            'orgs' => $this->org_structure,
            'roles' => $this->roles->pluck('id'),
            'modules' => $this->modules->pluck('id'),
            'urls' => [
                'update' => route('admin.users.update', ['user' => $this->id])
            ]
        ];
    }
}
