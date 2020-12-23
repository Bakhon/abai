<?php

namespace App\Http\Controllers\Admin;

use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('admin.users.list'),
            ],
            'title' => 'Список пользователей',
            'fields' => [
                'username' => [
                    'title' => 'Логин',
                    'type' => 'string',
                ],
                'name' => [
                    'title' => 'Имя пользователя',
                    'type' => 'string',
                ],
                'company' => [
                    'title' => 'Компания',
                    'type' => 'string',
                ],
                'created_at' => [
                    'title' => 'Дата создания',
                    'type' => 'string',
                ],
            ],
        ];

        return view('admin.users.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = \App\User::query();

        $users = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\Admin\UserListResource::collection($users)->toJson()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = \Spatie\Permission\Models\Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')->with('success', __('app.updated'));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new UserFilter($query, $filter))->filter();
    }
}
