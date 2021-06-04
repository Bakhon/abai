<?php

namespace App\Http\Controllers\Admin;

use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\Admin\UserListResource;
use App\Models\Refs\Org;
use App\User;
use App\Module;
use Illuminate\Support\Facades\Session;
use \Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    const LOGS_PER_PAGE = 20;

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
                'org' => [
                    'title' => 'Компания',
                    'type' => 'string',
                ],
                'created_at' => [
                    'title' => 'Дата создания',
                    'type' => 'string',
                ],
                'last_authorized_at' => [
                    'title' => 'Был в последний раз',
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

        return response()->json(json_decode(UserListResource::collection($users)->toJson()));
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
        $roles = Role::all();
        $orgs = Org::all();
        $modules = Module::all();

        return view('admin.users.edit', compact('user', 'roles', 'orgs','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'org_id' => $request->org_id
        ]);

        $user->syncRoles($request->roles);
        $user->modules()->sync($request->modules);
        return redirect()->route('admin.users.index')->with('success', __('app.updated'));
    }

    public function pageViewLogs(User $user)
    {
        $logs = $user->pageViewLogs()->paginate(self::LOGS_PER_PAGE);
        return view('admin.users.log', compact('user', 'logs'));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new UserFilter($query, $filter))->filter();
    }
}
