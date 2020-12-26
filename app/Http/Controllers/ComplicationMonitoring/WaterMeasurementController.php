<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\WaterMeasurementFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\WaterMeasurementCreateRequest;
use App\Http\Requests\WaterMeasurementUpdateRequest;
use App\Models\ComplicationMonitoring\ConstantsValue;
use App\Models\ComplicationMonitoring\Corrosion as ComplicationMonitoringCorrosion;
use App\Models\ComplicationMonitoring\GuKormass as ComplicationMonitoringGuKormass;
use App\Models\ComplicationMonitoring\Kormass;
use App\Models\ComplicationMonitoring\OmgUHE as ComplicationMonitoringOmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement as ComplicationMonitoringWaterMeasurement;
use App\Models\Refs\Cdng as RefsCdng;
use App\Models\Refs\Field as RefsField;
use App\Models\Refs\Gu as RefsGu;
use App\Models\Refs\HydrocarbonOxidizingBacteria as RefsHydrocarbonOxidizingBacteria;
use App\Models\Refs\Ngdu as RefsNgdu;
use App\Models\Refs\OtherObjects as RefsOtherObjects;
use App\Models\Refs\SulphateReducingBacteria as RefsSulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria as RefsThionicBacteria;
use App\Models\Refs\WaterTypeBySulin as RefsWaterTypeBySulin;
use App\Models\Refs\Well as RefsWell;
use App\Models\Refs\Zu as RefsZu;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class WaterMeasurementController extends CrudController
{
    use WithFieldsValidation;

    protected $modelName = 'watermeasurement';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('watermeasurement.list'),
            ],
            'title' => trans('monitoring.wm.title'),
            'fields' => [
                
                'gu' => [
                    'title' => trans('monitoring.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Gu::whereHas('watermeasurement')
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
                    'title' => trans('monitoring.well'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Well::whereHas('watermeasurement')
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
                'hydrocarbonate_ion' => [
                    'title' => 'НСО3-',
                    'type' => 'numeric',
                ],
                'carbonate_ion' => [
                    'title' => 'СО32-',
                    'type' => 'numeric',
                ],
                'sulphate_ion' => [
                    'title' => 'SO42-',
                    'type' => 'numeric',
                ],
                'chlorum_ion' => [
                    'title' => 'Cl-',
                    'type' => 'numeric',
                ],
                'calcium_ion' => [
                    'title' => 'Ca2+',
                    'type' => 'numeric',
                ],
                'magnesium_ion' => [
                    'title' => 'Mg2+',
                    'type' => 'numeric',
                ],
                'potassium_ion_sodium_ion' => [
                    'title' => 'Na+K+',
                    'type' => 'numeric',
                ],
                'density' => [
                    'title' => trans('monitoring.wm.fields.density'),
                    'type' => 'numeric',
                ],
                'ph' => [
                    'title' => 'pH',
                    'type' => 'numeric',
                ],
                'mineralization' => [
                    'title' => trans('monitoring.wm.fields.mineralization'),
                    'type' => 'numeric',
                ],
                'total_hardness' => [
                    'title' => trans('monitoring.wm.fields.total_hardness'),
                    'type' => 'numeric',
                ],
                'water_type_by_sulin' => [
                    'title' => trans('monitoring.wm.fields.water_type_by_sulin'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\WaterTypeBySulin::whereHas('watermeasurement')
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
                'content_of_petrolium_products' => [
                    'title' => trans('monitoring.wm.fields.content_of_petrolium_products'),
                    'type' => 'numeric',
                ],
                'mechanical_impurities' => [
                    'title' => trans('monitoring.wm.fields.mechanical_impurities'),
                    'type' => 'numeric',
                ],
                'strontium_content' => [
                    'title' => trans('monitoring.wm.fields.strontium_content'),
                    'type' => 'numeric',
                ],
                'barium_content' => [
                    'title' => trans('monitoring.wm.fields.barium_content'),
                    'type' => 'numeric',
                ],
                'total_iron_content' => [
                    'title' => trans('monitoring.wm.fields.total_iron_content'),
                    'type' => 'numeric',
                ],
                'ferric_iron_content' => [
                    'title' => trans('monitoring.wm.fields.ferric_iron_content'),
                    'type' => 'numeric',
                ],
                'ferrous_iron_content' => [
                    'title' => trans('monitoring.wm.fields.ferrous_iron_content'),
                    'type' => 'numeric',
                ],
                'hydrogen_sulfide' => [
                    'title' => trans('monitoring.wm.fields.hydrogen_sulfide'),
                    'type' => 'numeric',
                ],
                'oxygen' => [
                    'title' => trans('monitoring.wm.fields.oxygen'),
                    'type' => 'numeric',
                ],
                'carbon_dioxide' => [
                    'title' => trans('monitoring.wm.fields.carbon_dioxide'),
                    'type' => 'numeric',
                ],
                'sulphate_reducing_bacteria' => [
                    'title' => trans('monitoring.wm.fields.sulphate_reducing_bacteria'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\SulphateReducingBacteria::whereHas('watermeasurement')
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
                'hydrocarbon_oxidizing_bacteria' => [
                    'title' => trans('monitoring.wm.fields.hydrocarbon_oxidizing_bacteria'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\HydrocarbonOxidizingBacteria::whereHas('watermeasurement')
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
                'thionic_bacteria' => [
                    'title' => trans('monitoring.wm.fields.thionic_bacteria'),
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\ThionicBacteria::whereHas('watermeasurement')
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
            ]
        ];

        if(auth()->user()->can('monitoring create '.$this->modelName)) {
            $params['links']['create'] = route($this->modelName.'.create');
        }
        if(auth()->user()->can('monitoring export '.$this->modelName)) {
            $params['links']['export'] = route($this->modelName.'.export');
        }

        return view('watermeasurement.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = ComplicationMonitoringWaterMeasurement::query()
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->with('waterTypeBySulin')
            ->with('sulphateReducingBacteria')
            ->with('hydrocarbonOxidizingBacteria')
            ->with('thionicBacteria');

        $watermeasurement = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(
            json_decode(\App\Http\Resources\WaterMeasurementListResource::collection($watermeasurement)->toJson())
        );
    }

    public function export(IndexTableRequest $request)
    {
        $job = new \App\Jobs\ExportWaterMeasurementToExcel($request->validated());
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
        $validationParams = $this->getValidationParams('watermeasurement');
        return view('watermeasurement.create', compact('validationParams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WaterMeasurementCreateRequest $request)
    {
        $this->validateFields($request, 'watermeasurement');

        $wm = new ComplicationMonitoringWaterMeasurement;
        $wm->fill($request->validated());
        $wm->cruser_id = auth()->id();
        $wm->save();

        return redirect()->route('watermeasurement.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wm = ComplicationMonitoringWaterMeasurement::where('id', '=', $id)
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->with('waterTypeBySulin')
            ->with('sulphateReducingBacteria')
            ->with('hydrocarbonOxidizingBacteria')
            ->with('thionicBacteria')
            ->first();

        return view('watermeasurement.show', compact('wm'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history(ComplicationMonitoringWaterMeasurement $watermeasurement)
    {
        $watermeasurement->load('history');
        return view('watermeasurement.history', compact('watermeasurement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplicationMonitoringWaterMeasurement $watermeasurement)
    {
        $validationParams = $this->getValidationParams('watermeasurement');
        return view('watermeasurement.edit', compact('watermeasurement', 'validationParams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        WaterMeasurementUpdateRequest $request,
        ComplicationMonitoringWaterMeasurement $watermeasurement
    ) {
        $this->validateFields($request, 'watermeasurement');
        $watermeasurement->update($request->validated());
        return redirect()->route('watermeasurement.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $wm = ComplicationMonitoringWaterMeasurement::find($id);
        $wm->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('watermeasurement.index')->with('success', __('app.deleted'));
        }
    }

    public function getFields()
    {
        $otherObjects = RefsField::all();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $otherObjects
            ]
        );
    }

    public function getOtherObjects()
    {
        $otherObjects = RefsOtherObjects::get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $otherObjects
            ]
        );
    }

    public function getNgdu()
    {
        $ngdu = RefsNgdu::get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $ngdu
            ]
        );
    }

    public function getCdng()
    {
        $cdng = RefsCdng::get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $cdng
            ]
        );
    }

    public function getGu(Request $request)
    {
        $gu = RefsGu::query()
            ->where('cdng_id', '=', $request->cdng_id)
            ->select('name', 'id', 'cdng_id')
            //dirty hack for alphanumeric sort but other solutions doesn't work
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $gu
            ]
        );
    }

    public function getZu(Request $request)
    {
        $zu = RefsZu::where('gu_id', '=', $request->gu_id)->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $zu
            ]
        );
    }

    public function getWell(Request $request)
    {
        $wells = RefsWell::where('zu_id', '=', $request->zu_id)->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $wells
            ]
        );
    }

    public function getWaterBySulin()
    {
        $wbs = RefsWaterTypeBySulin::get();


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $wbs
            ]
        );
    }

    public function getSulphateReducingBacteria()
    {
        $srb = RefsSulphateReducingBacteria::get();


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $srb
            ]
        );
    }

    public function getHydrocarbonOxidizingBacteria()
    {
        $hob = RefsHydrocarbonOxidizingBacteria::get();


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $hob
            ]
        );
    }

    public function getThionicBacteria()
    {
        $hb = RefsThionicBacteria::get();


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $hb
            ]
        );
    }

    public function getWm(Request $request)
    {
        $wm = ComplicationMonitoringWaterMeasurement::find($request->id);


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $wm
            ]
        );
    }

    public function getAllGu()
    {
        $gus = RefsGu::query()
            ->select('name', 'id', 'cdng_id')
            //dirty hack for alphanumeric sort but other solutions doesn't work
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $gus
            ]
        );
    }

    public function getGuData(Request $request)
    {
        $wm = ComplicationMonitoringWaterMeasurement::query()
            ->where('gu_id', '=', $request->gu_id)
            ->where('date', '>=', \Carbon\Carbon::now()->subYear()->startOfMonth())
            ->where('date', '<=', \Carbon\Carbon::now()->startOfMonth())
            ->get()
            ->groupBy(
                function ($item) {
                    return \Carbon\Carbon::parse($item->date)->diffInMonths(\Carbon\Carbon::now()->startOfMonth()) > 6
                        ? '1 полугодие'
                        : '2 полугодие';
                }
            );

        $uhe = ComplicationMonitoringOmgUHE::query()
            ->where('gu_id', '=', $request->gu_id)
            ->where('date', '>=', \Carbon\Carbon::now()->subYear()->startOfMonth())
            ->where('date', '<=', \Carbon\Carbon::now()->startOfMonth())
            ->get()
            ->groupBy(
                function ($item) {
                    return \Carbon\Carbon::parse($item->date)->diffInMonths(\Carbon\Carbon::now()->startOfMonth()) > 6
                        ? '1 полугодие'
                        : '2 полугодие';
                }
            );

        $corrosion = ComplicationMonitoringCorrosion::query()
            ->where('gu_id', '=', $request->gu_id)
            ->where(
                'final_date_of_corrosion_velocity_with_inhibitor_measure',
                '>=',
                \Carbon\Carbon::now()->subYear()->startOfMonth()
            )
            ->where(
                'final_date_of_corrosion_velocity_with_inhibitor_measure',
                '<=',
                \Carbon\Carbon::now()->startOfMonth()
            )
            ->get()
            ->groupBy(
                function ($item) {
                    return \Carbon\Carbon::parse($item->date)->diffInMonths(\Carbon\Carbon::now()->startOfMonth()) > 6
                        ? '1 полугодие'
                        : '2 полугодие';
                }
            );

        $kormass = ComplicationMonitoringGuKormass::where('gu_id', '=', $request->gu_id)->with('kormass')->first();
        $pipe = Pipe::where('gu_id', '=', $request->gu_id)->where('plot', '=', 'eg')->first();
        $pipeAB = Pipe::where('gu_id', '=', $request->gu_id)->where('plot', '=', 'ab')->first();
        $lastCorrosion = ComplicationMonitoringCorrosion::where('gu_id', '=', $request->gu_id)->whereNotNull(
            'corrosion_velocity_with_inhibitor'
        )->latest()->first();
        $constantsValues = ConstantsValue::get();
        $chartDtCarbonDioxide = $chartDtHydrogenSulfide = $chartIngibitor = $chartCorrosion = [
            'dt' => [],
            'value' => []
        ];

        foreach ($wm as $key => $wmMonth) {
            $chartDtCarbonDioxide['dt'][] = $key;
            $chartDtCarbonDioxide['value'][] = $wmMonth->avg('carbon_dioxide');

            $chartDtHydrogenSulfide['dt'][] = $key;
            $chartDtHydrogenSulfide['value'][] = $wmMonth->avg('hydrogen_sulfide');
        }

        foreach ($uhe as $key => $uheMonth) {
            $chartIngibitor['dt'][] = $key;
            $chartIngibitor['value'][] = $uheMonth->avg('current_dosage');
        }

        foreach ($corrosion as $key => $corrosionMonth) {
            $chartCorrosion['dt'][] = $key;
            $chartCorrosion['value'][] = $corrosionMonth->avg('corrosion_velocity_with_inhibitor');
        }

        if ($kormass && $kormass->kormass->name != 'Прямой УПСВ') {
            $kn = explode("-", $kormass->kormass->name);
            $kormass = $kn[1];
        } else {
            $kormass = 'Прямой УПСВ';
        }


        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'chart1' => $chartDtCarbonDioxide,
                'chart2' => $chartDtHydrogenSulfide,
                'chart3' => $chartCorrosion,
                'chart4' => $chartIngibitor,
                'kormass' => $kormass,
                'pipe' => $pipe,
                'pipeab' => $pipeAB,
                'lastCorrosion' => $lastCorrosion,
                'constantsValues' => $constantsValues
            ]
        );
    }

    public function getGuNgduCdngField(Request $request)
    {
        $gu = RefsGu::where('id', '=', $request->gu_id)->first();
        $cdng = RefsCdng::where('id', '=', $gu->cdng_id)->first();
        $kormass = ComplicationMonitoringGuKormass::where('gu_id', '=', $request->gu_id)->first();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'cdng' => $gu->cdng_id,
                'ngdu' => $cdng->ngdu_id,
                'kormass' => $kormass->kormass_id
            ]
        );
    }

    public function getAllKormasses()
    {
        $kormasses = Kormass::orderBy('name')->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $kormasses
            ]
        );
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new WaterMeasurementFilter($query, $filter))->filter();
    }
}
