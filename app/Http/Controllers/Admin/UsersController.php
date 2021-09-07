<?php

namespace App\Http\Controllers\Admin;

use App\Filters\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\Admin\UserEditResource;
use App\Http\Resources\Admin\UserListResource;
use App\User;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    protected $modelName = 'users';

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

        $params['model_name'] = $this->modelName;
        $params['filter'] = session($this->modelName.'_filter');

        return view('admin.users.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $input = $request->validated();
        $model_name_filter = $input['model_name'].'_filter';
        session([$model_name_filter => $input]);

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
        return view(
            'admin.users.edit',
            [
                'user' => new UserEditResource($user)
            ]
        );
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
