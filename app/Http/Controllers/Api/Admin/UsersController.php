<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\User;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update(
            [
                'org_structure' => $request->orgs,
                'check_org_permissions' => $request->check_org_permissions
            ]
        );

        $user->syncRoles($request->roles);
        $user->modules()->sync($request->modules);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
