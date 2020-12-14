<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\OmgCAExport;
use App\Filters\OmgCAFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
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
            'header_links' => [
                'create' => route('omgca.create'),
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
                            ->pluck('name', 'id')
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
            ->paginate(10);

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
    public function store(Request $request)
    {
        // return $request;
        $request->validate(
            [
                'year' => 'required',
            ]
        );

        $omgca = new OmgCA;
        $omgca->field = ($request->field) ? $request->field : null;
        $omgca->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : null;
        $omgca->cdng_id = ($request->cdng_id) ? $request->cdng_id : null;
        $omgca->gu_id = ($request->gu_id) ? $request->gu_id : null;
        $omgca->zu_id = ($request->zu_id) ? $request->zu_id : null;
        $omgca->well_id = ($request->well_id) ? $request->well_id : null;
        $omgca->date = $request->year . "-01-01";
        $omgca->plan_dosage = ($request->plan_dosage) ? $request->plan_dosage : null;
        $omgca->q_v = ($request->q_v) ? $request->q_v : null;
        $omgca->cruser_id = Auth::user()->id;
        $omgca->save();

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

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
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
