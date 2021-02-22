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

    public function guPipes(Request $request, DruidService $druidService)
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

    private function getWellOilInfo($druidService)
    {
        $wellOil = $druidService->getWellOil();
        foreach ($wellOil as $row) {
            $result[$row['uwi']] = $row['oil'];
        }
        return $result;
    }

    private function getWellPointsWithInfo($druidService)
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

                    $well->name = $name;
                    return $well;
                }
            );
    }

    public function storeGu(Request $request)
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

    public function storeZu(Request $request)
    {
        $zu_input = $request->input('zu');
        $zu = $zu_input['id'] ? Zu::find($zu_input['id']) : new Zu;

        $zu->fill($zu_input);
        $zu->save();

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storeWell(Request $request, DruidService $druidService)
    {
        $well_input = $request->input('well');
        $well = $well_input['id'] ? Well::find($well_input['id']) : new Well;

        $well->fill($well_input);
        $well->save();

        $wellOilInfo = $this->getWellOilInfo($druidService);
        $name = 'Скважина: ' . $well->name . "\n";
        if (array_key_exists($well->name, $wellOilInfo)) {
            $name .= 'Добыча за 01.07.2020: ' . $wellOilInfo[$well->name] . "\n";
        }

        $well->name = $name;

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storePipe (Request $request) {
        $pipe_input = $request->input('pipe');
        if ($pipe_input['type'] == 'GuZu') {
            $pipe = $pipe_input['id'] ? GuZuPipe::find($pipe_input['id']) : new GuZuPipe;
        }

        if ($pipe_input['type'] == 'ZuWell') {
            $pipe = $pipe_input['id'] ? ZuWellPipe::find($pipe_input['id']) : new ZuWellPipe;
        }

        $coords = $pipe_input['coordinates'];
        $pipe_input['coordinates'] = array_map(
            function ($coord) {
                return [
                    round($coord[1], 8),
                    round($coord[0], 8),
                ];
            },
            $pipe_input['coordinates']
        );



        $pipe->fill($pipe_input);
        $pipe->save();

        return response()->json(
            [
                'pipe' => [
                    'color' => $pipe_input['type'] == 'GuZu' ?  [255, 0, 0] : [0, 255, 0],
                    'name' => (string)$pipe->id,
                    'coordinates' => $coords
                ],
                'status' => config('response.status.success'),
            ]
        );
    }

    private function getGuPipesWithCoords(&$coordinates)
    {
        return GuZuPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if (!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }

                    $coords = array_map(
                        function ($coord) {
                            return [
                                round($coord[1], 8),
                                round($coord[0], 8),
                            ];
                        },
                        $pipe->coordinates
                    );

                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        $coords
                    );
                    return [
                        'color' => [255, 0, 0],
                        'name' => (string)$pipe->id,
                        'coordinates' => $coords
                    ];
                }
            );
    }

    private function getZuWellPipesWithCoords(&$coordinates)
    {
        return ZuWellPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if (!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }

                    $coords = array_map(
                        function ($coord) {
                            return [
                                round($coord[1], 8),
                                round($coord[0], 8),
                            ];
                        },
                        $pipe->coordinates
                    );

                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        $coords
                    );
                    return [
                        'color' => [0, 255, 0],
                        'name' => (string)$pipe->id,
                        'coordinates' => $coords
                    ];
                }
            );
    }
}
