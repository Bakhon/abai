<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\OmgUHEExport;
use App\Filters\OmgUHEFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgUHEUpdateRequest;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OmgUHEController extends Controller
{
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('omguhe.create'),
                'list' => route('omguhe.list'),
                'export' => route('omguhe.export'),
            ],
            'title' => 'База данных ОМГ УХЭ',
            'table_header' => [
                'Узел отбора' => 6,
                'Фактические данные от УХЭ' => 5,
            ],
            'fields' => [
                'field' => [
                    'title' => 'Месторождение',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Field::whereHas('omguhe')
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
                'ngdu' => [
                    'title' => 'НГДУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Ngdu::whereHas('omguhe')
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
                'cdng' => [
                    'title' => 'ЦДНГ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Cdng::whereHas('omguhe')
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
                'gu' => [
                    'title' => 'ГУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('omguhe')
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
                'zu' => [
                    'title' => 'ЗУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Zu::whereHas('omguhe')
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
                'well' => [
                    'title' => 'Скважина',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Well::whereHas('omguhe')
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
                    'title' => 'Дата',
                    'type' => 'date',
                ],
                'current_dosage' => [
                    'title' => 'Фактическая дозировка, г/м3',
                    'type' => 'numeric',
                ],
                'daily_inhibitor_flowrate' => [
                    'title' => 'Суточный расход ингибитора, кг/сут',
                    'type' => 'numeric',
                ],
                'out_of_service_оf_dosing' => [
                    'title' => 'Простой дозатора',
                    'type' => 'select',
                    'filter' => [
                        'values' => [
                            [
                                'id' => '',
                                'name' => 'Простоя не было'
                            ],
                            [
                                'id' => '1',
                                'name' => 'Был простой'
                            ],
                        ]
                    ]
                ],
                'reason' => [
                    'title' => 'Причина',
                    'type' => 'numeric',
                ]
            ]
        ];

        return view('omguhe.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = ComplicationMonitoringOmgUHE::query()
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well');

        $omguhe = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\OmgUHEListResource::collection($omguhe)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $query = ComplicationMonitoringOmgUHE::query()
            ->with('field')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $omguhe = $this
            ->getFilteredQuery($request->validated(), $query)
            ->get();

        return Excel::download(new OmgUHEExport($omguhe), 'omguhe.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omguhe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $omgohe = new ComplicationMonitoringOmgUHE;
        $omgohe->field_id = $request->field_id ?: NULL;
        $omgohe->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : NULL;
        $omgohe->cdng_id = ($request->cdng_id) ? $request->cdng_id : NULL;
        $omgohe->gu_id = ($request->gu_id) ? $request->gu_id : NULL;
        $omgohe->zu_id = ($request->zu_id) ? $request->zu_id : NULL;
        $omgohe->well_id = ($request->well_id) ? $request->well_id : NULL;
        $omgohe->date = date("Y-m-d H:i", strtotime($request->date));
        $omgohe->current_dosage = ($request->current_dosage) ? $request->current_dosage : NULL;
        $omgohe->level = ($request->level) ? $request->level : NULL;
        $omgohe->fill = ($request->fill) ? $request->fill : NULL;
        $omgohe->daily_inhibitor_flowrate = ($request->daily_inhibitor_flowrate) ? $request->daily_inhibitor_flowrate : NULL;
        if($request->out_of_service_оf_dosing == true){
            $omgohe->out_of_service_оf_dosing = 1;
        }else{
            $omgohe->out_of_service_оf_dosing = 0;
        }
        $omgohe->reason = ($request->reason) ? $request->reason : NULL;
        $omgohe->cruser_id = Auth::user()->id;
        $omgohe->save();

        return redirect()->route('omguhe.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omguhe = ComplicationMonitoringOmgUHE::where('id', '=', $id)
                            ->with('ngdu')
                            ->with('cdng')
                            ->with('gu')
                            ->with('zu')
                            ->with('well')
                            ->first();

        return view('omguhe.show', compact('omguhe'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(ComplicationMonitoringOmgUHE $omguhe)
    {
        $omguhe->load('history');
        return view('omguhe.history', compact('omguhe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplicationMonitoringOmgUHE $omguhe)
    {
        return view('omguhe.edit', compact('omguhe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OmgUHEUpdateRequest $request, ComplicationMonitoringOmgUHE $omguhe)
    {
        $omguhe->update($request->validated());
        return redirect()->route('omguhe.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $omguhe = ComplicationMonitoringOmgUHE::find($id);
        $omguhe->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('omguhe.index')->with('success',__('app.deleted'));
        }
    }

    public function getPrevDayLevel(Request $request){
        $result = ComplicationMonitoringOmgUHE::where('gu_id', '=', $request->gu_id)
                                        ->where('date', '<', $request->date)
                                        ->where('out_of_service_оf_dosing', '<>', '1')
                                        ->latest()
                                        ->first();

        if($result){
            if($result->fill){
                return $result->fill;
            }else{
                return $result->level;
            }
        }else{
            return false;
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgUHEFilter($query, $filter))->filter();
    }
}
