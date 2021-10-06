<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Gu;
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
        $pipes = OilPipe::with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'hydroCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'reverseCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->WithLastReverseCalc()
            ->get();

        $manualPipes = ManualOilPipe::with('coords', 'pipeType')
            ->with([
                'hydroCalcLong' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'hydroCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                },
                'reverseCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->WithLastReverseCalc()
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

        return [
            'pipes' => $pipes,
            'ngdus' => $ngdus,
            'cdngs' => $cdngs,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'center' => $center,
            'pipeTypes' => $pipeTypes,
        ];
    }

    private function getPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        $oilPipes = OilPipe::with('coords', 'pipeType')->get();
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
                },
                'reverseCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->WithLastReverseCalc()
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
                },
                'reverseCalc' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                }
            ])
            ->WithLastHydroCalc()
            ->WithLastReverseCalc()
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
            ManualHydroCalcResult::whereIn('oil_pipe_id', function($query) use ($pipe){
                $query->select('id')
                    ->from(with(new ManualOilPipe)->getTable())
                    ->where('gu_id', $pipe->gu_id);
            })->delete();

            ManualHydroCalcLong::whereIn('oil_pipe_id', function($query) use ($pipe){
                $query->select('id')
                    ->from(with(new ManualOilPipe)->getTable())
                    ->where('gu_id', $pipe->gu_id);
            })->delete();
        }

        PipeCoord::where('oil_pipe_id', $pipe->id)->delete();
        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function getHydroReverseCalc(Request $request)
    {
        $date = $request->input('date');

        $pipes = OilPipe::with(
            [
                'coords',
                'pipeType',
                'hydroCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'reverseCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'hydroCalcLong' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )->get();

        $manualPipes = ManualOilPipe::with(
            [
                'coords',
                'pipeType',
                'hydroCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'reverseCalc' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'hydroCalcLong' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
            ]
        )->get();

        $pipes = $pipes->merge($manualPipes);

        return [
            'pipes' => $pipes
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
}
