<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RoleListResource;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index()
    {
        return [
            'roles' => RoleListResource::collection(Role::all())
        ];
    }

}
