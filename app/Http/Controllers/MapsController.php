<?php

namespace App\Http\Controllers;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\MapPipe;
use App\Models\Pipes\PipeCoord;
use Illuminate\Http\Request;
use App\Models\Pipes\GuZuPipe;
use App\Services\MapService;
use App\Models\Refs\Gu;
use App\Models\Refs\Zu;
use App\Models\Refs\Cdng;
use App\Models\Pipes\ZuWellPipe;
use App\Models\Refs\Well;
use App\Services\DruidService;
use App\Http\Resources\GuZuPipeResource;
use App\Http\Resources\ZuWellPipeResource;

use App\Imports\GuWellsImport;
use Maatwebsite\Excel\Facades\Excel;

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
        $gus = Gu::query()
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $cdngs = Cdng::all();

        return view('maps.gu_map', compact('cdngs', 'gus'));
    }

    public function getMapCenter (){
        $coordinates = [];
        $this->getPipesWithCoords($coordinates);

        foreach ($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);

        return $center;
    }

    public function guPipes(Request $request, DruidService $druidService): array
    {
        $pipes = MapPipe::with('coords', 'pipeType')->get();

        $center = [52.854602599069, 43.426262258809];

        $wellPoints = Well::query()
            ->whereHas('zu.gu')
            ->whereHas('ngdu')
            ->whereNotNull('wells.lat')
            ->whereNotNull('wells.lon')
            ->get();

        $zuPoints = Zu::query()
            ->whereHas('gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

//        $guPoints = Gu::with('omgngdu_last:id,daily_fluid_production,daily_oil_production,bsw,pump_discharge_pressure,heater_output_pressure,editable')

        $guPoints = Gu::query()
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        return [
            'pipes' => $pipes,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'center' => $center,
        ];
    }

    private function getPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        $map_pipes = MapPipe::with('coords', 'pipeType')->get();
        $coords = [];

        $map_pipes->map(
            function ($map_pipe) use (&$coordinates, &$coords) {
                $map_pipe->coords->map(
                    function ($coord) use (&$coordinates, &$map_pipe, &$coords) {
                        $coords[] = [$coord->lon, $coord->lat];

                        return $coord;
                    }
                );

                if (!isset($coordinates[$map_pipe->gu_id])) {
                    $coordinates[$map_pipe->gu_id] = [];
                }

                $coordinates[$map_pipe->gu_id] = array_merge(
                    $coordinates[$map_pipe->gu_id],
                    $coords
                );

                return $map_pipe;
            }
        );

        return $map_pipes;
    }

    private function getWellOilInfo(DruidService $druidService): array
    {
        $wellOil = $druidService->getWellOil();
        foreach ($wellOil as $row) {
            $result[$row['uwi']] = $row['oil'];
        }
        return $result;
    }

    private function getWellPointsWithInfo(DruidService $druidService): \Illuminate\Database\Eloquent\Collection
    {
        $wellOilInfo = $this->getWellOilInfo($druidService);
        return Well::query()
            ->whereHas('zu.gu')
            ->whereNotNull('wells.lat')
            ->whereNotNull('wells.lon')
            ->get()
            ->map(
                function ($well) use ($wellOilInfo) {
                    $name = 'Скважина: ' . $well->name . "\n";
                    if (array_key_exists($well->name, $wellOilInfo)) {
                        $name .= 'Добыча за 01.07.2020: ' . $wellOilInfo[$well->name] . "\n";
                    }

                    $well->origName = $well->name;
                    $well->name = $name;
                    return $well;
                }
            );
    }

    public function storeGu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $gu_input = $request->input('gu');
        $gu = $gu_input['id'] ? Gu::find($gu_input['id']) : new Gu;

        $gu->fill($gu_input);
        $gu->save();

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
        $well = $well_input['id'] ? Well::find($well_input['id']) : new Well;
        $well_input['name'] = $well_input['origName'];

        $well->fill($well_input);
        $well->save();

        $wellOilInfo = $this->getWellOilInfo($druidService);
        $name = 'Скважина: ' . $well->name . "\n";
        if (array_key_exists($well->name, $wellOilInfo)) {
            $name .= 'Добыча за 01.07.2020: ' . $wellOilInfo[$well->name] . "\n";
        }

        $well->origName = $well->name;
        $well->name = $name;

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
        $pipe = new MapPipe;
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = new PipeCoord;
            $pipe_coord->fill($coord);
            $pipe_coord->map_pipe_id = $pipe->id;
            $pipe_coord->save();
        }

        $pipe = MapPipe::with('coords', 'pipeType')->find($pipe->id);
        $pipe->color = $this->mapService->getPipeColor($pipe->between_points);

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

    public function updatePipe(Request $request, MapPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        $pipe_input = $request->input('pipe');
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = PipeCoord::find($coord['id']);
            $pipe_coord->fill($coord);
            $pipe_coord->save();
        }

        $pipe = MapPipe::with('coords', 'pipeType')->find($pipe->id);

        $pipe->color = $this->mapService->getPipeColor($pipe->between_points);

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

    public function deletePipe(MapPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        PipeCoord::where('map_pipe_id', $pipe->id)->delete();
        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }
}
