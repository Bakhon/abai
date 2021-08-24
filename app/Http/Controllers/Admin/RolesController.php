<?php

namespace App\Http\Controllers\Admin;

use App\Filters\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleCreateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\Admin\RoleListResource;
use App\Models\PermissionSection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    static protected $modules = [
        [
            'name' => 'monitoring',
            'title' => 'Модуль мониторинг'
        ],
        [
            'name' => 'economic',
            'title' => 'Модуль экономика'
        ],
        [
            'name' => 'bigdata',
            'title' => 'Модуль Прототип БД'
        ],
        [
            'name' => 'tr',
            'title' => 'Модуль ТР'
        ],
        [
            'name' => 'visualcenter',
            'title' => 'Модуль центр визуализации'
        ],
        [
            'name' => 'podborGno',
            'title' => 'Модуль Подбор ГНО'
        ],
        [
            'name' => 'paegtm',
            'title' => 'Модуль Подбор ГТМ'
        ],
        [
            'name' => 'digitalDrilling',
            'title' => 'Модуль Цифровое бурение'
        ],
    ];

    static protected $fieldCodes = [
        'list' => 'Просмотр списка',
        'create' => 'Создание',
        'read' => 'Чтение',
        'update' => 'Изменение',
        'delete' => 'Удаление',
        'export' => 'Экспорт в excel',
        'view history' => 'Просмотр истории',
        'view' => 'Просмотр',
        'load_las' => 'Загрузка las',
        'one_dzo' => 'Только Дашборды "Добыча" и "Форма ввода" для одного ДЗО',
    ];

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('admin.roles.create'),
                'list' => route('admin.roles.list'),
            ],
            'title' => 'Список ролей',
            'fields' => [
                'name' => [
                    'title' => 'Название',
                    'type' => 'string',
                ],
            ],
            'hide_filter' => true
        ];

        return view('admin.roles.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Role::query();

        $users = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(RoleListResource::collection($users)->toJson()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::query()
            ->get()
            ->keyBy('name');

        $sections = PermissionSection::all();
        $fieldCodes = self::$fieldCodes;
        $modules = self::$modules;

        return view('admin.roles.create', compact('permissions', 'sections', 'fieldCodes', 'modules'));
    }

    /**
     * Store resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleCreateRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', __('app.updated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()
            ->get()
            ->keyBy('name');

        $sections = PermissionSection::all();
        $fieldCodes = self::$fieldCodes;
        $modules = self::$modules;

        return view('admin.roles.edit', compact('role', 'permissions', 'sections', 'fieldCodes', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.roles.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('admin.roles.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new RoleFilter($query, $filter))->filter();
    }
}
