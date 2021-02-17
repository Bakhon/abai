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
                'status' => 'success',
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
                                round($coord[1], 6),
                                round($coord[0], 6),
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
                        'path' => $coords
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
                                round($coord[1], 6),
                                round($coord[0], 6),
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
                        'path' => $coords
                    ];
                }
            );
    }
}
