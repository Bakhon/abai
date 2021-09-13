<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TechnicalStructureController extends Controller
{
    const PAGINATION = 12;

    const VIEW_PREFIX = 'economic.technical';

    protected $viewName = '';

    protected $model;

    public function index(): View
    {
        $models = $this->model::latest()->paginate(self::PAGINATION);

        return view($this->viewPath("index"), compact('models'));
    }

    public function create(): View
    {
        return view($this->viewPath("create"));
    }

    public function store(TechnicalStructureStoreRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $params['user_id'] = auth()->user()->id;

        $this->model::create($params);

        return redirect()
            ->route($this->viewPath('index'))
            ->with('success', __('app.created'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        return view($this->viewPath('edit'), compact('model'));
    }

    public function update(TechnicalStructureStoreRequest $request, int $id): RedirectResponse
    {
        $model = $this->model::findOrFail($id);

        $params = $request->validated();

        $params['user_id'] = auth()->user()->id;

        $model->update($params);

        return redirect()
            ->route($this->viewPath('index'))
            ->with('success', __('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->model::whereId($id)->delete();

        return redirect()
            ->route($this->viewPath('index'))
            ->with('success', __('app.deleted'));
    }

    public function getData(Request $request): array
    {
        $query = $this->model::query();

        if ($request->cdng_id) {
            $query->whereCdngId($request->cdng_id);
        }

        if ($request->ngdu_id) {
            $query->whereNgduId($request->ngdu_id);
        }

        if ($request->field_id) {
            $query->whereFieldId($request->field_id);
        }

        if ($request->company_id) {
            $query->whereCompanyId($request->company_id);
        }

        return $query->get()->toArray();
    }

    protected function viewPath(string $method = ""): string
    {
        return self::VIEW_PREFIX . "." . $this->viewName . "." . $method;
    }
}
