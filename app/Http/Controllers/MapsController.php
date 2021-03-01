<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pipes\GuZuPipe;
use App\Services\MapService;
use App\Models\Refs\Gu;
use App\Models\Refs\Zu;
use App\Models\Refs\Cdng;
use App\Models\Pipes\ZuWellPipe;
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
        $gus = Gu::query()
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $cdngs = Cdng::all();

        return view('maps.gu_map', compact('cdngs', 'gus'));
    }

    public function guPipes(Request $request, DruidService $druidService): array
    {
        $coordinates = [];
        $zuPipes = $this->getGuPipesWithCoords($coordinates);

        $wellPipes = $this->getZuWellPipesWithCoords($coordinates);

        foreach ($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);

        $wellPoints = $this->getWellPointsWithInfo($druidService);

        $zuPoints = Zu::query()
            ->whereHas('gu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $guPoints = Gu::query()
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        return [
            'pipes' => $wellPipes->merge($zuPipes),
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'guCenters' => $guCenters,
            'center' => $center,
        ];
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
        $pipe = $pipe_input['type'] == 'GuZu' ? new GuZuPipe : new ZuWellPipe;

        $pipe->fill($pipe_input);
        $pipe->coordinates = $this->switchCoords($pipe_input['coordinates']);
        $pipe->save();

        $pipe->color = $pipe_input['type'] == 'GuZu' ? [255, 0, 0] : [0, 255, 0];
        $pipe->name = (string)$pipe->id;
        $pipe->coordinates = $pipe_input['coordinates'];

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

    public function updatePipe(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $pipe_input = $request->input('pipe');
        $type = isset($pipe_input['well_id']) && $pipe_input['well_id'] ? 'ZuWell' : 'GuZu';

        if ($type == 'ZuWell') {
            $pipe = ZuWellPipe::find($id);
        } else {
            $pipe = GuZuPipe::find($id);
        }

        $pipe->fill($pipe_input);
        $pipe->coordinates = $this->switchCoords($pipe_input['coordinates']);
        $pipe->save();

        $pipe->color = $type == 'GuZu' ? [255, 0, 0] : [0, 255, 0];
        $pipe->name = (string)$pipe->id;
        $pipe->coordinates = $pipe_input['coordinates'];

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

    public function deletePipe(int $id, string $type): \Symfony\Component\HttpFoundation\Response
    {
        if ($type == 'ZuWell') {
            $pipe = ZuWellPipe::find($id);
        } else {
            $pipe = GuZuPipe::find($id);
        }

        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    private function getGuPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        return GuZuPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if (!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }

                    $coords = $this->switchCoords($pipe->coordinates);

                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        $coords
                    );

                    $pipe->coordinates = $coords;
                    $pipe->color = [255, 0, 0];
                    $pipe->name = (string)$pipe->id;
                    return $pipe;
                }
            );
    }

    private function getZuWellPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        return ZuWellPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if (!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }

                    $coords = $this->switchCoords($pipe->coordinates);

                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        $coords
                    );

                    $pipe->coordinates = $coords;
                    $pipe->color = [0, 255, 0];
                    $pipe->name = (string)$pipe->id;
                    return $pipe;
                }
            );
    }

    private function switchCoords($coords)
    {
        return array_map(
            function ($coord) {
                return [
                    round($coord[1], 8),
                    round($coord[0], 8),
                ];
            },
            $coords
        );
    }
}
