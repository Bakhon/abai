<?php

namespace App\Http\Controllers;

use App\Filters\InhibitorFilter;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\InhibitorCreateRequest;
use App\Http\Requests\InhibitorUpdateRequest;
use App\Models\Inhibitor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class InhibitorsController extends Controller
{
    use WithFieldsValidation;

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('inhibitors.create'),
                'list' => route('inhibitors.list'),
            ],
            'title' => 'Справочник ингибиторов',
            'fields' => [
                'name' => [
                    'title' => 'Название',
                    'type' => 'numeric',
                ],
                'price' => [
                    'title' => 'Цена',
                    'type' => 'numeric',
                ],
                'date_from' => [
                    'title' => 'Дата изменения цены',
                    'type' => 'numeric',
                ],
            ]
        ];

        return view('inhibitors.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Inhibitor::query()
            ->with('prices');

        $inhibitor = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(
            json_decode(\App\Http\Resources\InhibitorListResource::collection($inhibitor)->toJson())
        );
    }

    public function create()
    {
        $validationParams = $this->getValidationParams('pipes');
        return view('inhibitors.create', compact('validationParams'));
    }

    public function store(InhibitorCreateRequest $request)
    {
        $this->validateFields($request, 'pipes');

        $inhibitor = Inhibitor::create($request->only(['name']));
        $inhibitor->prices()->create(
            [
                'price' => $request->price,
                'date_from' => \Carbon\Carbon::now()->startOfDay()
            ]
        );

        return redirect()->route('inhibitors.index')->with('success', __('app.created'));
    }

    public function show(Inhibitor $inhibitor)
    {
        return view(
            'inhibitors.show',
            [
                'inhibitor' => $inhibitor,
                'price' => $inhibitor->prices->whereNull('date_to')->last()
            ]
        );
    }

    public function edit(Inhibitor $inhibitor)
    {
        $validationParams = $this->getValidationParams('pipes');
        return view(
            'inhibitors.edit',
            [
                'inhibitor' => new \App\Http\Resources\InhibitorResource($inhibitor),
                'validationParams' => $validationParams
            ]
        );
    }

    public function update(InhibitorUpdateRequest $request, Inhibitor $inhibitor)
    {
        $this->validateFields($request, 'pipes');

        if ($request->name) {
            $inhibitor->update($request->only('name'));
        }
        if ($request->price) {
            if ($inhibitor->prices->where('date_from', $request->date_from)->isNotEmpty()) {
                $inhibitor->prices->where('date_from', $request->date_from)->update(['price' => $request->price]);
            } else {
                $oldPrice = $inhibitor->prices->whereNull('date_to')->first();
                $oldPrice->date_to = \Carbon\Carbon::parse($request->date_from)->subDay()->startOfDay();
                $oldPrice->save();

                $inhibitor->prices()->create(
                    [
                        'price' => $request->price,
                        'date_from' => $request->date_from
                    ]
                );
            }
        }

        return redirect()->route('inhibitors.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Inhibitor $inhibitor)
    {
        $inhibitor->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('inhibitors.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new InhibitorFilter($query, $filter))->filter();
    }
}
