<?php

namespace App\Http\Controllers\Admin;

use App\Filters\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleCreateRequest;
use App\Http\Requests\IndexTableRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    static protected  $sections = [
            'oilgas' => 'Баз данных по нефти и газу',
            'watermeasurement' => 'База данных по промысловой жидкости и газу',
            'corrosion' => 'База данных по скорости корозии',
            'omgca' => 'ОМГ ДДНГ',
            'omgngdu' => 'ОМГ НГДУ',
            'omguhe' => 'ОМГ УХЭ',
            'pipes' => 'Трубопроводы',
            'inhibitors' => 'Ингибиторы'
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

        return response()->json(json_decode(\App\Http\Resources\Admin\RoleListResource::collection($users)->toJson()));
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
        $permissions = \Spatie\Permission\Models\Permission::query()
            ->get()
            ->keyBy('name');

        $sections = self::$sections;

        return view('admin.roles.create', compact('permissions', 'sections'));
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
            'name' => $request->name
        ]);

        $role->permissions()->sync($request->permissions);

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
        $permissions = \Spatie\Permission\Models\Permission::query()
            ->get()
            ->keyBy('name');

        $sections = self::$sections;

        return view('admin.roles.edit', compact('role', 'permissions', 'sections'));
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
        $role->permissions()->sync($request->permissions);
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
