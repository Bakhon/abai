<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OmgCAFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgCAUpdateRequest;
use App\Models\ComplicationMonitoring\OmgCA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OmgCAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('omgca.index');
    }

    public function list(IndexTableRequest $request)
    {
        $query = OmgCA::query()
            ->with('gu');

        $omgca = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(10);

        $params = [
            'fields' => [
                'gu' => [
                    'title' => '',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('omgca')
                            ->orderBy('name', 'asc')
                            ->pluck('name', 'id')
                            ->toArray()
                    ]
                ],
                'date' => [
                    'title' => '',
                    'type' => 'number',
                ],
                'plan_dosage' => [
                    'title' => 'г/м³',
                    'type' => 'number',
                ],
                'q_v' => [
                    'title' => 'тыс.м³/год',
                    'type' => 'number',
                ],
            ]
        ];

        return response()->json([
            'omgca' => json_decode(\App\Http\Resources\OmgCAListResource::collection($omgca)->toJson()),
            'params' => $params
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omgca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $omgca = OmgCA::find($id);
        $omgca->delete();

        return redirect()->route('omgca.index')->with('success', __('app.deleted'));
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
