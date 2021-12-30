<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTableRequest;
use App\Jobs\ManualCalculateHydroDynamics;
use App\Models\ComplicationMonitoring\BG;
use App\Models\ComplicationMonitoring\BknsWell;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\KmbWell;
use App\Models\ComplicationMonitoring\ManualGu;
use App\Models\ComplicationMonitoring\ManualHydroCalcLong;
use App\Models\ComplicationMonitoring\ManualHydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\ManualWell;
use App\Models\ComplicationMonitoring\ManualZu;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\OmgNGDUZu;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\WaterWell;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use App\Services\DruidService;
use App\Services\MapService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TechMapController extends Controller
{
    protected $mapService;
    protected $modelNameSpace = 'App\\Models\\ComplicationMonitoring\\';

    public function __construct(MapService $mapService)
    {
        $this->middleware('can:monitoring view pipes map');

        $this->mapService = $mapService;
    }

    public function guMap()
    {
        return view('complicationMonitoring.tech_map.index');
    }

    public function getMapCenter()
    {
        $coordinates = [];
        $this->getPipesWithCoords($coordinates);

        foreach ($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);

        return $center;
    }

    public function mapData(): array
    {
        $date = HydroCalcResult::orderBy('date', 'desc')->first()->date;
        $pipes = OilPipe::with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'hydroCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])
            ->where('water_pipe', false)
            ->get();

        $manualPipes = ManualOilPipe::with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) {
                    $query->where('date', Carbon::yesterday()->format('Y-m-d'));
                },
                'hydroCalc' => function ($query) {
                    $query->where('date', Carbon::yesterday()->format('Y-m-d'));
                }
            ])
            ->get();

        $center = [52.854602599069, 43.426262258809];

        $wellPoints = Well::query()
            ->whereHas('zu.gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->WithLastOmgngdu()
            ->get();

        $wellManualPoints = ManualWell::query()
            ->whereNotNull('zu_id')
            ->whereNotNull('gu_id')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->WithLastOmgngdu()
            ->get();

        $zuPoints = Zu::query()
            ->whereHas('gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $zuManualPoints = ManualZu::query()
            ->whereHas('gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $guPoints = Gu::whereNotNull('lat')
            ->whereNotNull('lon')
            ->WithLastOmgngdu()
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $guManualPoints = ManualGu::whereNotNull('lat')
            ->whereNotNull('lon')
            ->WithLastOmgngdu()
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $wellPoints = $wellPoints->merge($wellManualPoints);
        $zuPoints = $zuPoints->merge($zuManualPoints);
        $guPoints = $guPoints->merge($guManualPoints);
        $pipes = $pipes->merge($manualPipes);

        $pipeTypes = PipeType::all();
        $ngdus = Ngdu::all();
        $cdngs = Cdng::all();
        $water_pipes = OilPipe::with('coords', 'pipeType')
            ->where('water_pipe', true)
            ->get();

        $water_pipes->map(function ($pipe) {
            $pipe->name = 'Pipe ID: ' . $pipe->id;
            return $pipe;
        });

        $water_wells = WaterWell::all();
        $bgs = BG::all();
        $kmb_wells = KmbWell::all();
        $bkns_wells = BknsWell::all();

        return [
            'pipes' => $pipes,
            'ngdus' => $ngdus,
            'cdngs' => $cdngs,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'center' => $center,
            'pipeTypes' => $pipeTypes,
            'date' => $date,
            'water_pipes' => $water_pipes,
            'water_wells' => $water_wells,
            'bgs' => $bgs,
            'kmb_wells' => $kmb_wells,
            'bkns_wells' => $bkns_wells
        ];
    }

    private function getPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        $oilPipes = OilPipe::with('coords', 'pipeType')
            ->where('water_pipe', false)
            ->get();

        $coords = [];

        $oilPipes->map(
            function ($oilPipe) use (&$coordinates, &$coords) {
                $oilPipe->coords->map(
                    function ($coord) use (&$coordinates, &$oilPipe, &$coords) {
                        $coords[] = [$coord->lon, $coord->lat];

                        return $coord;
                    }
                );

                if (!isset($coordinates[$oilPipe->gu_id])) {
                    $coordinates[$oilPipe->gu_id] = [];
                }

                $coordinates[$oilPipe->gu_id] = array_merge(
                    $coordinates[$oilPipe->gu_id],
                    $coords
                );

                return $oilPipe;
            }
        );

        return $oilPipes;
    }

    private function getWellOilInfo(DruidService $druidService): array
    {
        $wellOil = $druidService->getWellOil();
        foreach ($wellOil as $row) {
            $result[$row['uwi']] = $row['oil'];
        }
        return $result;
    }

    public function storeGu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring create gu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $gu_input = $request->input('gu');
        $gu = new ManualGu;

        $gu->fill($gu_input);
        $gu->save();

        $gu = ManualGu::with(
            [
                'omgngdu' => function ($query) {
                    $query->select(
                        'id',
                        'date',
                        'gu_id',
                        'daily_fluid_production',
                        'daily_oil_production',
                        'bsw',
                        'pump_discharge_pressure',
                        'heater_output_temperature',
                        'editable'
                    )->orderBy('date', 'desc')->first();
                }
            ]
        )
            ->find($gu->id);

        return response()->json(
            [
                'gu' => $gu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storeZu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring create zu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $zu_input = $request->input('zu');
        $zu = new ManualZu;

        $zu->fill($zu_input);
        $zu->save();

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storeWell(Request $request, DruidService $druidService): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring create well', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $well_input = $request->input('well');
        $well = new ManualWell;

        $well->fill($well_input);
        $well->save();

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storePipe(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring create pipe', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $pipe_input = $request->input('pipe');
        $pipe = new ManualOilPipe;
        $pipe->fill($pipe_input);
        $pipe->user_id = auth()->user()->id;
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = new PipeCoord;
            $pipe_coord->fill($coord);
            $pipe_coord->oil_pipe_id = $pipe->id;
            $pipe_coord->save();
        }

        $pipe = ManualOilPipe::with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'hydroCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->find($pipe->id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateGu(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring update gu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $model = $id >= 10000 ? app($this->modelNameSpace . 'ManualGu') : app($this->modelNameSpace . 'Gu');
        $modelPipe = $id >= 10000 ? app($this->modelNameSpace . 'ManualOilPipe') : app($this->modelNameSpace . 'OilPipe');
        $gu = $model->find($id);

        $startPointPipes = $modelPipe->where('gu_id', $gu->id)->where('start_point', $gu->name)->get();
        $endPointPipes = $modelPipe->where('gu_id', $gu->id)->where('end_point', $gu->name)->get();

        $gu_input = $request->input('gu');

        $gu->fill($gu_input);
        $gu->save();

        $this->updatePipePoints($startPointPipes, $gu->name, 'start_point');
        $this->updatePipePoints($endPointPipes, $gu->name, 'end_point');

        $gu = $model->with(
            [
                'omgngdu' => function ($query) {
                    $query->select(
                        'id',
                        'date',
                        'gu_id',
                        'daily_fluid_production',
                        'daily_oil_production',
                        'bsw',
                        'pump_discharge_pressure',
                        'heater_output_temperature',
                        'editable'
                    )->orderBy('date', 'desc')->first();
                }
            ]
        )
            ->find($gu->id);

        return response()->json(
            [
                'gu' => $gu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateZu(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring update zu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);
        $modelPipe = $id >= 10000 ? app($this->modelNameSpace . 'ManualOilPipe') : app($this->modelNameSpace . 'OilPipe');

        $startPointPipes = $modelPipe->where('zu_id', $zu->id)->where('start_point', $zu->name)->get();
        $endPointPipes = $modelPipe->where('zu_id', $zu->id)->where('end_point', $zu->name)->get();

        $zu_input = $request->input('zu');

        $zu->fill($zu_input);
        $zu->save();

        $this->updatePipePoints($startPointPipes, $zu->name, 'start_point');
        $this->updatePipePoints($endPointPipes, $zu->name, 'end_point');

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateWell(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring update well', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $well = $id >= 10000 ? ManualWell::find($id) : Well::find($id);
        $modelPipe = $id >= 10000 ? app($this->modelNameSpace . 'ManualOilPipe') : app($this->modelNameSpace . 'OilPipe');

        $startPointPipes = $modelPipe->where('well_id', $well->id)->where('start_point', $well->name)->get();
        $endPointPipes = $modelPipe->where('well_id', $well->id)->where('end_point', $well->name)->get();

        $well_input = $request->input('well');

        $well->fill($well_input);
        $well->save();

        $this->updatePipePoints($startPointPipes, $well->name, 'start_point');
        $this->updatePipePoints($endPointPipes, $well->name, 'end_point');

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updatePipe(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring update pipe', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $model = $id >= 10000 ? app($this->modelNameSpace . 'ManualOilPipe') : app($this->modelNameSpace . 'OilPipe');
        $pipe = $model->find($id);

        $pipe_input = $request->input('pipe');

        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = PipeCoord::findOrNew($coord['id']);
            $pipe_coord->fill($coord);
            $pipe_coord->save();
        }

        $pipe = $model->with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'hydroCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->find($id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteGu(int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring delete gu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $gu = $id >= 10000 ? ManualGu::find($id) : Gu::find($id);
        OmgNGDU::where('gu_id', $gu->id)->delete();
        $gu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteZu(int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring delete zu', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $zu = $id >= 10000 ? ManualZu::find($id) : Zu::find($id);
        OmgNGDUZu::where('zu_id', $zu->id)->delete();
        $zu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteWell(int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring delete well', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $well = $id >= 10000 ? ManualWell::find($id) : Well::find($id);
        OmgNGDUWell::where('well_id', $well->id)->delete();
        $well->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deletePipe(int $id): \Symfony\Component\HttpFoundation\Response
    {
        if (!auth()->user()->hasPermissionTo('monitoring delete pipe', 'web')) {
            return response()->json(
                [
                    'status' => config('response.status.error'),
                    'message' => trans('app.no_permissions_rights')
                ]
            );
        }

        $pipe = $id >= 100000 ? ManualOilPipe::find($id) : OilPipe::find($id);

        if ($id >= 100000) {
            ManualHydroCalcResult::whereIn('oil_pipe_id', function ($query) use ($pipe) {
                $query->select('id')
                    ->from(with(new ManualOilPipe)->getTable())
                    ->where('gu_id', $pipe->gu_id);
            })->delete();

            ManualHydroCalcLong::whereIn('oil_pipe_id', function ($query) use ($pipe) {
                $query->select('id')
                    ->from(with(new ManualOilPipe)->getTable())
                    ->where('gu_id', $pipe->gu_id);
            })->delete();
        }

        $pipe->user_id = auth()->user()->id;
        $pipe->save();
        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function getHydroCalc(Request $request)
    {
        $date = $request->input('date');

        $pipes = OilPipe::with(
            [
                'coords',
                'zu',
                'pipeType',
                'hydroCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'hydroCalcLong' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'well.omgngdu' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ]
        )->where('water_pipe', false)
            ->orderBy('between_points')
            ->get();

        $press_alerts = [];
        $press_zu = [];

        foreach ($pipes as $pipe) {
            $press_diff = $pipe->hydroCalc && isset($pipe->well->omgngdu[0]) && $pipe->well->omgngdu[0]->pressure ? $pipe->hydroCalc->press_start - $pipe->well->omgngdu[0]->pressure : null;

            if ($press_diff != null && $press_diff != 0) {
                $press_alerts[] = [
                    'message' => 'Расчетное давление (' . $pipe->hydroCalc->press_start . ') отличается от датчиков (' . $pipe->well->omgngdu[0]->pressure . ') на скважине ' . $pipe->well->name,
                    'variant' => 'danger'
                ];
            }

            if ($pipe->between_points == 'well-zu' && $pipe->hydroCalc && $pipe->hydroCalc->press_end) {
                $press_zu[$pipe->zu_id] = $pipe->hydroCalc->press_end;
            }
            
            if ($pipe->between_points == 'zu-gu' 
                && $pipe->hydroCalc 
                && $pipe->hydroCalc->press_start 
                && $pipe->hydroCalc->press_start  != $press_zu[$pipe->zu_id]) {
                $press_alerts[] = [
                    'message' => 'Конечное давление ('.$press_zu[$pipe->zu_id].') на трубах СКВ-ЗУ не совпадает с начальным давлением ('.$pipe->hydroCalc->press_start.') на трубе ЗУ-ГУ, '.$pipe->zu->name,
                    'variant' => 'danger'
                ];
            }
            

            unset($pipe->well);
            unset($pipe->zu);
        }

        $manualPipes = ManualOilPipe::with(
            [
                'coords',
                'pipeType',
                'hydroCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'hydroCalcLong' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )->get();

        $wellPoints = Well::with(
            [
                'omgngdu' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )
            ->whereHas('zu.gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $wellManualPoints = ManualWell::with(
            [
                'omgngdu' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )
            ->whereNotNull('zu_id')
            ->whereNotNull('gu_id')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $guPoints = Gu::with(
            [
                'omgngdu' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $guManualPoints = ManualGu::with(
            [
                'omgngdu' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $wellPoints = $wellPoints->merge($wellManualPoints);
        $guPoints = $guPoints->merge($guManualPoints);
        $pipes = $pipes->merge($manualPipes);

        return [
            'pipes' => $pipes,
            'wells' => $wellPoints,
            'gus' => $guPoints,
            'press_alerts' => $press_alerts
        ];
    }

    public function updatePipePoints(\Illuminate\Database\Eloquent\Collection $pipes, string $name, string $point): void
    {
        if ($pipes) {
            foreach ($pipes as $pipe) {
                $pipe->$point = $name;
                $pipe->save();
            }
        }
    }

    public function calculate(IndexTableRequest $request)
    {
        $job = new ManualCalculateHydroDynamics($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }
}
