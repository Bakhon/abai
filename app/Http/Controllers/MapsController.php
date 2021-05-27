<?php

namespace App\Http\Controllers;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\OilPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Ngdu;
use Illuminate\Http\Request;
use App\Services\MapService;
use App\Models\Refs\Gu;
use App\Models\Refs\Zu;
use App\Models\Refs\Cdng;
use App\Models\Refs\Well;
use App\Services\DruidService;

class MapsController extends Controller
{
    protected $mapService;

    public function __construct(MapService $mapService)
    {
        $this->middleware('can:monitoring view pipes map');

        $this->mapService = $mapService;
    }

    public function guMap()
    {
        return view('maps.gu_map');
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

    public function mapData(Request $request, DruidService $druidService): array
    {
        $pipes = OilPipe::with('coords', 'pipeType')->get();

        $center = [52.854602599069, 43.426262258809];

        $wellPoints = Well::query()
            ->whereHas('zu.gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $zuPoints = Zu::query()
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
        $gu_input = $request->input('gu');
        $gu = new Gu;

        $gu->fill($gu_input);
        $gu->save();

        $gu = Gu::with(
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
        $zu_input = $request->input('zu');
        $zu = new Zu;

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
        $well_input = $request->input('well');
        $well = new Well;

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
        $pipe_input = $request->input('pipe');
        $pipe = new OilPipe;
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = new PipeCoord;
            $pipe_coord->fill($coord);
            $pipe_coord->oil_pipe_id = $pipe->id;
            $pipe_coord->save();
        }

        $pipe = OilPipe::with('coords', 'pipeType')->find($pipe->id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateGu(Request $request, Gu $gu): \Symfony\Component\HttpFoundation\Response
    {
        $gu_input = $request->input('gu');

        $gu->fill($gu_input);
        $gu->save();

        $gu = Gu::with(
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

    public function updateZu(Request $request, Zu $zu): \Symfony\Component\HttpFoundation\Response
    {
        $zu_input = $request->input('zu');

        $zu->fill($zu_input);
        $zu->save();

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateWell(Request $request, Well $well): \Symfony\Component\HttpFoundation\Response
    {
        $well_input = $request->input('well');

        $well->fill($well_input);
        $well->save();

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updatePipe(Request $request, OilPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        $pipe_input = $request->input('pipe');
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = PipeCoord::find($coord['id']);
            $pipe_coord->fill($coord);
            $pipe_coord->save();
        }

        $pipe = OilPipe::with('coords', 'pipeType')->find($pipe->id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteGu(Gu $gu): \Symfony\Component\HttpFoundation\Response
    {
        $gu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteZu(Zu $zu): \Symfony\Component\HttpFoundation\Response
    {
        $zu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteWell(Well $well): \Symfony\Component\HttpFoundation\Response
    {
        $well->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deletePipe(OilPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        PipeCoord::where('oil_pipe_id', $pipe->id)->delete();
        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function getSpeedFlow(Request $request)
    {
        $date = $request->input('date');
        $pipes = OilPipe::with(
            [
                'coords',
                'pipeType',
                'speedFlowGuUpsv' => function ($query) use ($date) {
                    $query->where('date', $date);
                },
                'speedFlowWellGu' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ]
        )->get();

        return [
            'pipes' => $pipes
        ];
    }
}
