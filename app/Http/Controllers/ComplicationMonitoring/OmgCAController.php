<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\OmgCAExport;
use App\Filters\OmgCAFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgCACreateRequest;
use App\Http\Requests\OmgCAUpdateRequest;
use App\Models\ComplicationMonitoring\OmgCA;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OmgCAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('omgca.create'),
                'list' => route('omgca.list'),
                'export' => route('omgca.export'),
            ],
            'title' => 'База данных ОМГ ДДНГ',
            'table_header' => [
                'Узел отбора' => 1,
                'Фактические данные ОМГ ЦА' => 3,
            ],
            'fields' => [
                'gu' => [
                    'title' => 'ГУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('omgca')
                            ->orderBy('name', 'asc')
                            ->get()
                            ->map(
                                function ($item) {
                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                    ];
                                }
                            )
                            ->toArray()
                    ]
                ],
                'date' => [
                    'title' => 'Год',
                    'type' => 'number',
                ],
                'plan_dosage' => [
                    'title' => 'Планируемая дозировка, г/м³',
                    'type' => 'number',
                ],
                'q_v' => [
                    'title' => 'Техрежим Qв, тыс.м³/год',
                    'type' => 'number',
                ],
            ]
        ];

        return view('omgca.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = OmgCA::query()
            ->with('gu');

        $omgca = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\OmgCAListResource::collection($omgca)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $query = OmgCA::query()
            ->with('gu');

        $omgca = $this
            ->getFilteredQuery($request->validated(), $query)
            ->get();

        return Excel::download(new OmgCAExport($omgca), 'omgca.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('omgca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(OmgCACreateRequest $request)
    {
        if($request->get('all_gus')) {

            $fields = $request->validated();
            unset($fields['all_gus']);
            unset($fields['gu_id']);
            $fields['cruser_id'] = auth()->id();

            $existedGus = OmgCA::query()
                ->where('date', $request->date)
                ->get()
                ->pluck('gu_id')
                ->toArray();

            $gus = \App\Models\Refs\Gu::query()
                ->whereNotIn('id', $existedGus)
                ->get();

            foreach($gus as $gu) {
                $gu->omgca()->create($fields);
            }

        }
        else {
            $omgca = new OmgCA;
            $omgca->fill($request->validated());
            $omgca->cruser_id = auth()->id();
            $omgca->save();
        }

        return redirect()->route('omgca.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $omgca = OmgCA::where('id', '=', $id)
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->first();

        return view('omgca.show', compact('omgca'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function history(OmgCA $omgca)
    {
        $omgca->load('history');
        return view('omgca.history', compact('omgca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(OmgCA $omgca)
    {
        return view('omgca.edit', compact('omgca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(OmgCAUpdateRequest $request, OmgCA $omgca)
    {
        $omgca->update($request->validated());
        return redirect()->route('omgca.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $omgca = OmgCA::find($id);
        $omgca->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('omgca.index')->with('success', __('app.deleted'));
        }
    }

    public function checkDublicate(Request $request)
    {
        $query = OmgCA::where('date', '=', $request->dt)
            ->where('gu_id', '=', $request->gu);

        if ($request->id) {
            $query->where('id', '!=', $request->id);
        }

        $row = $query->first();

        if ($row) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgCAFilter($query, $filter))->filter();
    }
}
