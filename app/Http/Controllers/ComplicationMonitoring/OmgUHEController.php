<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\OmgUHEFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\OmgUHECreateRequest;
use App\Http\Requests\OmgUHEUpdateRequest;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgUHE;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\OmgUHEListResource;

class OmgUHEController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'omguhe';
    
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('omguhe.list'),
            ],
            'title' => trans('monitoring.omguhe.title'),
            'table_header' => [
                trans('monitoring.selection_node') => 1,
                trans('monitoring.omguhe.fields.fact_data') => 7,
            ],
            'fields' => [
                
                
                
                'gu' => [
                    'title' => trans('monitoring.gu.gu'),
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

                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
                ],

                'level' => [
                    'title' => trans('monitoring.level'),
                    'type' => 'numeric',
                ],

                'fill' => [
                    'title' => trans('monitoring.omguhe.fields.fill'),
                    'type' => 'numeric',
                ],

                'current_dosage' => [
                    'title' => trans('monitoring.omguhe.fields.fact_dosage'),
                    'type' => 'numeric',
                ],
                'daily_inhibitor_flowrate' => [
                    'title' => trans('monitoring.omguhe.fields.inhibitor_rate'),
                    'type' => 'numeric',
                ],
                'out_of_service_оf_dosing' => [
                    'title' => trans('monitoring.omguhe.fields.dosator_idle'),
                    'type' => 'select',
                    'filter' => [
                        'values' => [
                            [
                                'id' => '',
                                'name' => trans('monitoring.omguhe.fields.dosator.no_idle')
                            ],
                            [
                                'id' => '1',
                                'name' => trans('monitoring.omguhe.fields.dosator.idle')
                            ],
                        ]
                    ]
                ],
                'reason' => [
                    'title' => trans('monitoring.omguhe.fields.reason'),
                    'type' => 'numeric',
                ]
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route($this->modelName.'.export');
        }

        return view('omguhe.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = OmgUHE::query()
                                ->with('ngdu')
                                ->with('cdng')
                                ->with('gu')
                                ->with('zu')
                                ->with('well');

        $omguhe = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(OmgUHEListResource::collection($omguhe)->toJson()));
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportOmgUHEToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('omguhe');
        return view('omguhe.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(OmgUHECreateRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->validateFields($request, 'omguhe');


        $input = $request->validated();
        $input['date'] = Carbon::parse($input['date'])->format('Y-m-d H:i:s');

        $omgohe = new OmgUHE;
        $omgohe->fill($input);
        $omgohe->cruser_id = auth()->id();
        $omgohe->save();

        Session::flash('message', __('app.created'));

        return response()->json(
            [
                'status' => config('response.status.success')
            ]
        );

//        return redirect()->route('omguhe.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omguhe = OmgUHE::where('id', $id)
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
    public function history(OmgUHE $omguhe)
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
    public function edit(OmgUHE $omguhe)
    {
        $validationParams = $this->getValidationParams('omguhe');
        return view('omguhe.edit', compact('omguhe'), compact('validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OmgUHEUpdateRequest $request, OmgUHE $omguhe)
    {
        $this->validateFields($request, 'omguhe');
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
        $omguhe = OmgUHE::find($id);
        $omguhe->delete();

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
            return redirect()->route('omguhe.index')->with('success',__('app.deleted'));
        }
    }

    public function getPrevDayLevel(Request $request){
        $result = OmgUHE::where('gu_id', $request->gu_id)
                                        ->where('date', '<', $request->date)
                                        ->where('out_of_service_оf_dosing', '!=', '1')
                                        ->latest()
                                        ->first();
        
        $ddng = OmgCA::where('gu_id', $request->gu_id)
                        ->where('date', Carbon::parse($request->date)->year . "-01-01")
                        ->first();

        if($result && $ddng && $request->gu_id){
            if($result->fill){
                $res = [
                    'level' => $result->fill,
                    'qv' => $ddng->q_v
                ];

                return response()->json($res);
            }else{
                $res =  [
                    'level' => $result->level,
                    'qv' => $ddng->q_v
                ];

                return response()->json($res);
            }
        }else{
            return response()->json(null);
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new OmgUHEFilter($query, $filter))->filter();
    }
}
