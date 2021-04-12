<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\WaterMeasurementFilter;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Requests\WaterMeasurementCreateRequest;
use App\Http\Requests\WaterMeasurementUpdateRequest;
use App\Models\ComplicationMonitoring\CalculatedCorrosion;
use App\Models\ComplicationMonitoring\ConstantsValue;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\GuKormass;
use App\Models\ComplicationMonitoring\Kormass;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\Refs\Cdng;
use App\Models\Refs\Field;
use App\Models\Refs\Gu;
use App\Models\Refs\HydrocarbonOxidizingBacteria;
use App\Models\Refs\Ngdu;
use App\Models\Refs\OtherObjects;
use App\Models\Refs\SulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria;
use App\Models\Refs\WaterTypeBySulin;
use App\Models\Refs\Well;
use App\Models\Refs\Zu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Resources\WaterMeasurementListResource;
use App\Jobs\ExportWaterMeasurementToExcel;

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
                'date' => [
                    'title' => trans('monitoring.wm.fields.date'),
                    'type' => 'date',
                ],
                'other_objects' => [
                    'title' => trans('monitoring.other_objects'),
                    'type' => 'select',
                    'filter' => [
                        'values' => OtherObjects::whereHas('watermeasurement')
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
                    'title' => trans('monitoring.gu.gu'),
                    'type' => 'select',
                    'filter' => [
                        'values' => Gu::whereHas('watermeasurement')
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
                        'values' => WaterTypeBySulin::whereHas('watermeasurement')
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
                        'values' => SulphateReducingBacteria::whereHas('watermeasurement')
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
                        'values' => HydrocarbonOxidizingBacteria::whereHas('watermeasurement')
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
                        'values' => ThionicBacteria::whereHas('watermeasurement')
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
        $query = WaterMeasurement::query()
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
            json_decode(WaterMeasurementListResource::collection($watermeasurement)->toJson())
        );
    }

    public function export(IndexTableRequest $request)
    {
        $job = new ExportWaterMeasurementToExcel($request->validated());
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

        $wm = new WaterMeasurement;
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
        $wm = WaterMeasurement::where('id', $id)
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
    public function history(WaterMeasurement $watermeasurement)
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
    public function edit(WaterMeasurement $watermeasurement)
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
        WaterMeasurement $watermeasurement
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
        $wm = WaterMeasurement::find($id);
        $wm->delete();

        if ($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return redirect()->route('watermeasurement.index')->with('success', __('app.deleted'));
        }
    }

    public function getFields()
    {
        $otherObjects = Field::all();

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
        $otherObjects = OtherObjects::get();

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
        $ngdu = Ngdu::get();

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
        $cdng = Cdng::get();

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
        $gu = Gu::query()
            ->where('cdng_id', $request->cdng_id)
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
        $zu = Zu::where('gu_id', $request->gu_id)->get();

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
        $wells = Well::where('zu_id', $request->zu_id)->get();

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
        $wbs = WaterTypeBySulin::get();


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
        $srb = SulphateReducingBacteria::get();


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
        $hob = HydrocarbonOxidizingBacteria::get();


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
        $hb = ThionicBacteria::get();


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
        $wm = WaterMeasurement::find($request->id);


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
        $gus = Gu::query()
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
        $wm = WaterMeasurement::query()
            ->where('gu_id', $request->gu_id)
            ->where('date', '>=', Carbon::now()->subYear())
            ->where('date', '<=', Carbon::now())
            ->orderBy('date')
            ->get();

        $uhe = OmgUHE::query()
            ->where('gu_id', $request->gu_id)
            ->where('date', '>=', Carbon::now()->subDays(31))
            ->where('date', '<=', Carbon::now())
            ->get();

        $corrosion = CalculatedCorrosion::query()
            ->where('gu_id', $request->gu_id)
            ->where('date', '>=', Carbon::now()->subDays(31))
            ->where('date', '<=', Carbon::now())
            ->get();

        $kormass = GuKormass::where('gu_id', $request->gu_id)->with('kormass')->first();

        $pipe = Pipe::where('gu_id', $request->gu_id)->where('plot', 'eg')->first();
        $pipeAB = Pipe::where('gu_id', $request->gu_id)->where('plot', 'ab')->first();

        $constantsValues = ConstantsValue::get();

        $lastCorrosion = Corrosion::where('gu_id', $request->gu_id)
            ->whereNotNull('corrosion_velocity_with_inhibitor')->latest()->first();

        $chartIngibitor = $chartCorrosion = [
            'dt' => [],
            'value' => []
        ];

        $CarbonAndHydrogenChartData = $this->getCarbonAndHydrogenChartData($wm);
        $chartDtCarbonDioxide = $CarbonAndHydrogenChartData['chartDtCarbonDioxide'];
        $chartDtHydrogenSulfide = $CarbonAndHydrogenChartData['chartDtHydrogenSulfide'];


        foreach ($uhe as $key => $val) {
            $chartIngibitor['dt'][] = Carbon::parse($val->date)->format('Y-m-d');
            $chartIngibitor['value'][] = $val->current_dosage;
        }

        foreach ($corrosion as $key => $val) {
            $chartCorrosion['dt'][] = Carbon::parse($val->date)->format('Y-m-d');
            $chartCorrosion['value'][] = $val->corrosion;
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

    private function getCarbonAndHydrogenChartData (\Illuminate\Database\Eloquent\Collection $wm): array
    {
        $chartDtCarbonDioxideByMonths = [];
        $chartDtHydrogenSulfideByMonths = [];

        foreach ($wm as $key => $val) {
            $month = Carbon::parse($val->date)->month;
            $chartDtCarbonDioxideByMonths[$month][] = $val->carbon_dioxide;
            $chartDtHydrogenSulfideByMonths[$month][] = $val->hydrogen_sulfide;
        }

        for ($month = 0; $month < 12; $month++) {
            $month_date = Carbon::now()->subYear()->addMonth($month);
            $month_name = $month_date->format('Y-m');
            $month_num = $month_date->month;


            $chartDtCarbonDioxide['dt'][] = $month_name;
            $average = 0;
            if (isset($chartDtCarbonDioxideByMonths[$month_num])) {
                $dtCarbonDioxideMonth = array_filter($chartDtCarbonDioxideByMonths[$month_num]);
                $average = count($dtCarbonDioxideMonth) ? round(array_sum($dtCarbonDioxideMonth)/count($dtCarbonDioxideMonth), 2) : 0;
            }
            $chartDtCarbonDioxide['value'][] = $average;


            $chartDtHydrogenSulfide['dt'][] = $month_name;
            $average = 0;
            if (isset($chartDtHydrogenSulfideByMonths[$month_num])) {
                $dtHydrogenSulfideMonth = array_filter($chartDtHydrogenSulfideByMonths[$month_num]);
                $average = count($dtHydrogenSulfideMonth) ? round(array_sum($dtHydrogenSulfideMonth)/count($dtHydrogenSulfideMonth), 2) : 0;
            }

            $chartDtHydrogenSulfide['value'][] = $average;
        }

        return [
            'chartDtCarbonDioxide' => $chartDtCarbonDioxide,
            'chartDtHydrogenSulfide' => $chartDtHydrogenSulfide
        ];
    }

    public function getGuNgduCdngField(Request $request)
    {
        $gu = Gu::where('id', $request->gu_id)->first();
        $cdng = Cdng::where('id', $gu->cdng_id)->first();
        $kormass = GuKormass::where('gu_id', $request->gu_id)->first();

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
