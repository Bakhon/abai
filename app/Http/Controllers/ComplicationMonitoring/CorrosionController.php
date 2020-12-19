<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\CorrosionFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CorrosionCreateRequest;
use App\Http\Requests\CorrosionUpdateRequest;
use App\Http\Requests\IndexTableRequest;
use App\Models\ComplicationMonitoring\Corrosion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CorrosionController extends Controller
{
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('corrosioncrud.create'),
                'list' => route('corrosioncrud.list'),
                'export' => route('corrosioncrud.export'),
            ],
            'title' => 'База данных по скорости коррозии',
            'fields' => [
                'field' => [
                    'title' => 'Месторождение',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Field::whereHas('corrosion')
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
                        'values' => \App\Models\Refs\Ngdu::whereHas('corrosion')
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
                        'values' => \App\Models\Refs\Cdng::whereHas('corrosion')
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
                        'values' => \App\Models\Refs\Gu::whereHas('corrosion')
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
                'start_date_of_background_corrosion' => [
                    'title' => 'Дата начала',
                    'type' => 'date',
                ],
                'final_date_of_background_corrosion' => [
                    'title' => 'Дата окончания',
                    'type' => 'date',
                ],
                'background_corrosion_velocity' => [
                    'title' => 'Фоновая скорость',
                    'type' => 'numeric',
                ],
                'start_date_of_corrosion_velocity_with_inhibitor_measure' => [
                    'title' => 'Дата начало замера скорости коррозии с реагентом',
                    'type' => 'date',
                ],
                'final_date_of_corrosion_velocity_with_inhibitor_measure' => [
                    'title' => 'Дата окончания замера скорости коррозии с реагентом',
                    'type' => 'date',
                ],
                'corrosion_velocity_with_inhibitor' => [
                    'title' => 'Скорость коррозии',
                    'type' => 'numeric',
                ],
                'sample_number' => [
                    'title' => 'Номер образца-свидетеля',
                    'type' => 'numeric',
                ],
                'weight_before' => [
                    'title' => 'Масса до установки, гр',
                    'type' => 'numeric',
                ],
                'days' => [
                    'title' => 'Количество дней экспозиции',
                    'type' => 'numeric',
                ],
                'weight_after' => [
                    'title' => 'Масса после извлечения, гр',
                    'type' => 'numeric',
                ],
                'avg_speed' => [
                    'title' => 'Средняя скорость коррозии, мм/г',
                    'type' => 'numeric',
                ]
            ]
        ];

        return view('сomplicationMonitoring.corrosion.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Corrosion::query()
            ->with('field')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu');

        $corrosion = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\CorrosionListResource::collection($corrosion)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportCorrosionToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('сomplicationMonitoring.corrosion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorrosionCreateRequest $request)
    {
        $corrosion = Corrosion::create($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corrosion $corrosioncrud)
    {
        return view('сomplicationMonitoring.corrosion.show', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Corrosion $corrosion)
    {
        $corrosion->load('history');
        return view('сomplicationMonitoring.corrosion.history', compact('corrosion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Corrosion $corrosioncrud)
    {
        return view('сomplicationMonitoring.corrosion.edit', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorrosionUpdateRequest $request, Corrosion $corrosioncrud)
    {
        $corrosioncrud->update($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Corrosion $corrosioncrud)
    {
        $corrosioncrud->delete();
        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('corrosioncrud.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new CorrosionFilter($query, $filter))->filter();
    }
}
