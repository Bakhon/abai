<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\WaterMeasurementExport;
use App\Filters\WaterMeasurementFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
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

class WaterMeasurementController extends Controller
{
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
                'create' => route('watermeasurement.create'),
                'list' => route('watermeasurement.list'),
                'export' => route('watermeasurement.export'),
            ],
            'title' => 'Лабораторные данные по промысловой жидкости',
            'fields' => [
                'date' => [
                    'title' => 'Дата отбора',
                    'type' => 'date',
                ],
                'other_objects' => [
                    'title' => 'Прочие объекты',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\OtherObjects::whereHas('watermeasurement')
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
                        'values' => \App\Models\Refs\Ngdu::whereHas('watermeasurement')
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
                        'values' => \App\Models\Refs\Cdng::whereHas('watermeasurement')
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
                'zu' => [
                    'title' => 'ЗУ',
                    'type' => 'select',
                    'filter' => [
                        'values' => \App\Models\Refs\Zu::whereHas('watermeasurement')
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
                    'title' => 'Плотность при 20°С, г/см³',
                    'type' => 'numeric',
                ],
                'ph' => [
                    'title' => 'рН',
                    'type' => 'numeric',
                ],
                'mineralization' => [
                    'title' => 'Общая минерализация, мг/дм³',
                    'type' => 'numeric',
                ],
                'total_hardness' => [
                    'title' => 'Общая жесткость, мг-экв/дм³',
                    'type' => 'numeric',
                ],
                'water_type_by_sulin' => [
                    'title' => 'Тип воды по Сулину',
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
                    'title' => 'Содержание нефтепродуктов, мг/дм³',
                    'type' => 'numeric',
                ],
                'mechanical_impurities' => [
                    'title' => 'Механические примеси, мг/дм³',
                    'type' => 'numeric',
                ],
                'strontium_content' => [
                    'title' => 'Содержание стронция, мг/дм³',
                    'type' => 'numeric',
                ],
                'barium_content' => [
                    'title' => 'Содержание бария, мг/дм³',
                    'type' => 'numeric',
                ],
                'total_iron_content' => [
                    'title' => 'Содержание общего железа мг/дм³',
                    'type' => 'numeric',
                ],
                'ferric_iron_content' => [
                    'title' => 'Содержание трехвалентного железа мг/дм³',
                    'type' => 'numeric',
                ],
                'ferrous_iron_content' => [
                    'title' => 'Содержание двухвалентного железа мг/дм³',
                    'type' => 'numeric',
                ],
                'hydrogen_sulfide' => [
                    'title' => 'H₂S, мг/дм³ (после буферной емкости)',
                    'type' => 'numeric',
                ],
                'oxygen' => [
                    'title' => 'О₂, мг/дм³',
                    'type' => 'numeric',
                ],
                'carbon_dioxide' => [
                    'title' => 'CO₂, мг/дм³ (после буферной емкости)',
                    'type' => 'numeric',
                ],
                'sulphate_reducing_bacteria' => [
                    'title' => 'СВБ, кл/см³',
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
                    'title' => 'УОБ, кл/см³',
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
                    'title' => 'ТБ, кл/см³',
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

        return response()->json(json_decode(\App\Http\Resources\WaterMeasurementListResource::collection($watermeasurement)->toJson()));
    }

    public function export(IndexTableRequest $request)
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
            ->get();

        return Excel::download(new WaterMeasurementExport($wm), 'watermeasurement.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('watermeasurement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'date' => 'required',
            ]
        );

        $wm = new ComplicationMonitoringWaterMeasurement;
        $wm->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : null;
        $wm->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : null;
        $wm->cdng_id = ($request->cdng_id) ? $request->cdng_id : null;
        $wm->gu_id = ($request->gu_id) ? $request->gu_id : null;
        $wm->zu_id = ($request->zu_id) ? $request->zu_id : null;
        $wm->well_id = ($request->well_id) ? $request->well_id : null;
        $wm->date = date("Y-m-d H:i", strtotime($request->date));
        $wm->hydrocarbonate_ion = ($request->hydrocarbonate_ion) ? $request->hydrocarbonate_ion : null;
        $wm->carbonate_ion = ($request->carbonate_ion) ? $request->carbonate_ion : null;
        $wm->sulphate_ion = ($request->sulphate_ion) ? $request->sulphate_ion : null;
        $wm->chlorum_ion = ($request->chlorum_ion) ? $request->chlorum_ion : null;
        $wm->calcium_ion = ($request->calcium_ion) ? $request->calcium_ion : null;
        $wm->magnesium_ion = ($request->magnesium_ion) ? $request->magnesium_ion : null;
        $wm->potassium_ion_sodium_ion = ($request->potassium_ion_sodium_ion) ? $request->potassium_ion_sodium_ion : null;
        $wm->density = ($request->density) ? $request->density : null;
        $wm->ph = ($request->ph) ? $request->ph : null;
        $wm->mineralization = ($request->mineralization) ? $request->mineralization : null;
        $wm->total_hardness = ($request->total_hardness) ? $request->total_hardness : null;
        $wm->water_type_by_sulin_id = ($request->water_type_by_sulin_id) ? $request->water_type_by_sulin_id : null;
        $wm->content_of_petrolium_products = ($request->content_of_petrolium_products) ? $request->content_of_petrolium_products : null;
        $wm->mechanical_impurities = ($request->mechanical_impurities) ? $request->mechanical_impurities : null;
        $wm->strontium_content = ($request->strontium_content) ? $request->strontium_content : null;
        $wm->barium_content = ($request->barium_content) ? $request->barium_content : null;
        $wm->total_iron_content = ($request->total_iron_content) ? $request->total_iron_content : null;
        $wm->ferric_iron_content = ($request->ferric_iron_content) ? $request->ferric_iron_content : null;
        $wm->ferrous_iron_content = ($request->ferrous_iron_content) ? $request->ferrous_iron_content : null;
        $wm->hydrogen_sulfide = ($request->hydrogen_sulfide) ? $request->hydrogen_sulfide : null;
        $wm->oxygen = ($request->oxygen) ? $request->oxygen : null;
        $wm->carbon_dioxide = ($request->carbon_dioxide) ? $request->carbon_dioxide : null;
        $wm->sulphate_reducing_bacteria_id = ($request->sulphate_reducing_bacteria_id) ? $request->sulphate_reducing_bacteria_id : null;
        $wm->hydrocarbon_oxidizing_bacteria_id = ($request->hydrocarbon_oxidizing_bacteria_id) ? $request->hydrocarbon_oxidizing_bacteria_id : null;
        $wm->thionic_bacteria_id = ($request->thionic_bacteria_id) ? $request->thionic_bacteria_id : null;
        $wm->cruser_id = Auth::user()->id;
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
        return view('watermeasurement.edit', compact('watermeasurement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ComplicationMonitoringWaterMeasurement $watermeasurement)
    {
        $request->validate(
            [
                'date' => 'required',
            ]
        );

        $watermeasurement->other_objects_id = ($request->other_objects_id) ? $request->other_objects_id : null;
        $watermeasurement->ngdu_id = ($request->ngdu_id) ? $request->ngdu_id : null;
        $watermeasurement->cdng_id = ($request->cdng_id) ? $request->cdng_id : null;
        $watermeasurement->gu_id = ($request->gu_id) ? $request->gu_id : null;
        $watermeasurement->zu_id = ($request->zu_id) ? $request->zu_id : null;
        $watermeasurement->well_id = ($request->well_id) ? $request->well_id : null;
        $watermeasurement->date = date("Y-m-d H:i:s", strtotime($request->date));
        $watermeasurement->hydrocarbonate_ion = ($request->hydrocarbonate_ion) ? $request->hydrocarbonate_ion : null;
        $watermeasurement->carbonate_ion = ($request->carbonate_ion) ? $request->carbonate_ion : null;
        $watermeasurement->sulphate_ion = ($request->sulphate_ion) ? $request->sulphate_ion : null;
        $watermeasurement->chlorum_ion = ($request->chlorum_ion) ? $request->chlorum_ion : null;
        $watermeasurement->calcium_ion = ($request->calcium_ion) ? $request->calcium_ion : null;
        $watermeasurement->magnesium_ion = ($request->magnesium_ion) ? $request->magnesium_ion : null;
        $watermeasurement->potassium_ion_sodium_ion = ($request->potassium_ion_sodium_ion) ? $request->potassium_ion_sodium_ion : null;
        $watermeasurement->density = ($request->density) ? $request->density : null;
        $watermeasurement->ph = ($request->ph) ? $request->ph : null;
        $watermeasurement->mineralization = ($request->mineralization) ? $request->mineralization : null;
        $watermeasurement->total_hardness = ($request->total_hardness) ? $request->total_hardness : null;
        $watermeasurement->water_type_by_sulin_id = ($request->water_type_by_sulin_id) ? $request->water_type_by_sulin_id : null;
        $watermeasurement->content_of_petrolium_products = ($request->content_of_petrolium_products) ? $request->content_of_petrolium_products : null;
        $watermeasurement->mechanical_impurities = ($request->mechanical_impurities) ? $request->mechanical_impurities : null;
        $watermeasurement->strontium_content = ($request->strontium_content) ? $request->strontium_content : null;
        $watermeasurement->barium_content = ($request->barium_content) ? $request->barium_content : null;
        $watermeasurement->total_iron_content = ($request->total_iron_content) ? $request->total_iron_content : null;
        $watermeasurement->ferric_iron_content = ($request->ferric_iron_content) ? $request->ferric_iron_content : null;
        $watermeasurement->ferrous_iron_content = ($request->ferrous_iron_content) ? $request->ferrous_iron_content : null;
        $watermeasurement->hydrogen_sulfide = ($request->hydrogen_sulfide) ? $request->hydrogen_sulfide : null;
        $watermeasurement->oxygen = ($request->oxygen) ? $request->oxygen : null;
        $watermeasurement->carbon_dioxide = ($request->carbon_dioxide) ? $request->carbon_dioxide : null;
        $watermeasurement->sulphate_reducing_bacteria_id = ($request->sulphate_reducing_bacteria_id) ? $request->sulphate_reducing_bacteria_id : null;
        $watermeasurement->hydrocarbon_oxidizing_bacteria_id = ($request->hydrocarbon_oxidizing_bacteria_id) ? $request->hydrocarbon_oxidizing_bacteria_id : null;
        $watermeasurement->thionic_bacteria_id = ($request->thionic_bacteria_id) ? $request->thionic_bacteria_id : null;
        $watermeasurement->cruser_id = Auth::user()->id;
        $watermeasurement->save();

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

        if($request->ajax()) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        else {
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
            ->where('date', '>=', \Carbon\Carbon::now()->subMonths(3))
            ->where('date', '<=', \Carbon\Carbon::now())
            ->get();
        $uhe = ComplicationMonitoringOmgUHE::where('gu_id', '=', $request->gu_id)->get();
        $corrosion = ComplicationMonitoringCorrosion::where('gu_id', '=', $request->gu_id)->get();
        $kormass = ComplicationMonitoringGuKormass::where('gu_id', '=', $request->gu_id)->with('kormass')->first();
        $pipe = Pipe::where('gu_id', '=', $request->gu_id)->where('plot', '=', 'eg')->first();
        $pipeAB = Pipe::where('gu_id', '=', $request->gu_id)->where('plot', '=', 'ab')->first();
        $lastCorrosion = ComplicationMonitoringCorrosion::where('gu_id', '=', $request->gu_id)->whereNotNull(
            'corrosion_velocity_with_inhibitor'
        )->latest()->first();
        $constantsValues = ConstantsValue::get();
        $chartDtCarbonDioxide['dt'] = [];
        $chartDtHydrogenSulfide['dt'] = [];
        $chartDtCarbonDioxide['value'] = [];
        $chartDtHydrogenSulfide['value'] = [];

        foreach ($wm as $row) {
            $date = new DateTime($row->date);
            array_push($chartDtCarbonDioxide['dt'], $date->format('Y-m-d'));
            array_push($chartDtHydrogenSulfide['dt'], $date->format('Y-m-d'));
            array_push($chartDtCarbonDioxide['value'], $row->carbon_dioxide);
            array_push($chartDtHydrogenSulfide['value'], $row->hydrogen_sulfide);
        }

        $chartIngibitor['dt'] = [];
        $chartIngibitor['value'] = [];
        foreach ($uhe as $row) {
            $date = new DateTime($row->date);
            array_push($chartIngibitor['dt'], $date->format('Y-m-d'));
            array_push($chartIngibitor['value'], $row->current_dosage);
        }

        $chartCorrosion['dt'] = [];
        $chartCorrosion['value'] = [];
        foreach ($corrosion as $row) {
            $date = new DateTime($row->final_date_of_corrosion_velocity_with_inhibitor_measure);
            array_push($chartCorrosion['dt'], $date->format('Y-m-d'));
            array_push($chartCorrosion['value'], $row->corrosion_velocity_with_inhibitor);
        }

        if ($kormass->kormass->name != 'Прямой УПСВ') {
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
