<?php

namespace App\Http\Controllers;

use App\Filters\PipeFilter;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\PipeCreateRequest;
use App\Http\Requests\PipeUpdateRequest;
use App\Models\ComplicationMonitoring\Pipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PipeController extends Controller
{
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'create' => route('pipes.create'),
                'list' => route('pipes.list'),
                'export' => route('pipes.export'),
            ],
            'title' => 'База данных по трубопроводам',
            'fields' => [
                'gu' => [
                    'title' => 'ГУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('pipe')
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
                'length' => [
                    'title' => 'Длина',
                    'type' => 'numeric',
                ],
                'outside_diameter' => [
                    'title' => 'Внешний диаметр',
                    'type' => 'numeric',
                ],
                'inner_diameter' => [
                    'title' => 'Внутренний диаметр',
                    'type' => 'numeric',
                ],
                'thickness' => [
                    'title' => 'Толщина стенок',
                    'type' => 'numeric',
                ],
                'roughness' => [
                    'title' => 'Жесткость',
                    'type' => 'numeric',
                ],
                'material' => [
                    'title' => 'Материал',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\ComplicationMonitoring\Material::whereHas('pipe')
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
                'plot' => [
                    'title' => 'Участок',
                    'type' => 'numeric',
                ],
            ]
        ];

        return view('pipes.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = Pipe::query()
            ->with('gu');

        $pipe = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(\App\Http\Resources\PipeListResource::collection($pipe)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $query = Pipe::query()
            ->with('gu');

        $pipes = $this
            ->getFilteredQuery($request->validated(), $query)
            ->get();

        return Excel::download(new \App\Exports\PipeExport($pipes), 'pipes.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PipeCreateRequest $request)
    {
        $pipe = Pipe::create($request->validated());

        return redirect()->route('pipes.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pipe $pipe)
    {
        return view('pipes.show', compact('pipe'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(Pipe $pipe)
    {
        $pipe->load('history');
        return view('pipes.history', compact('pipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pipe $pipe)
    {
        return view('pipes.edit', compact('pipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PipeUpdateRequest $request, Pipe $pipe)
    {
        $pipe->update($request->validated());
        return redirect()->route('pipes.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Pipe $pipe)
    {
        $pipe->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('pipes.index')->with('success', __('app.deleted'));
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new PipeFilter($query, $filter))->filter();
    }
}
