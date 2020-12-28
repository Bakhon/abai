<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    protected $mapService;

    public function __construct(\App\Services\MapService $mapService)
    {
        $this->middleware('can:monitoring view pipes map');

        $this->mapService = $mapService;
    }

    public function guMap()
    {

        $gus = \App\Models\Refs\Gu::query()
            ->whereHas('zuPipes')
            ->orWhereHas('wellPipes')
            ->select('name', 'id')
            //dirty hack for alphanumeric sort but other solutions doesn't work
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        return view('maps.gu_map', compact('gus'));
    }

    public function guPipes(Request $request, \App\Services\DruidService $druidService)
    {
        $gus = \App\Models\Refs\Gu::all();

        $coordinates = [];
        $zuPipes = \App\Models\Pipes\GuZuPipe::query()
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

        $wellPipes = \App\Models\Pipes\ZuWellPipe::query()
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

        foreach ($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);


        $wellOilInfo = $this->getWellOilInfo($druidService);
        $wellPoints = \App\Models\Refs\Well::query()
            ->whereHas('zu.gu')
            ->whereNotNull('wells.lat')
            ->whereNotNull('wells.lon')
            ->get()
            ->map(
                function ($well) use($wellOilInfo) {

                    $name = 'Скважина: '.$well->name."\n";
                    if(array_key_exists($well->name, $wellOilInfo)) {
                        $name .= 'Добыча за 01.07.2020: ' . $wellOilInfo[$well->name] . "\n";
                    }

                    return [
                        'name' => $name,
                        'coords' => [(float)$well->lon, (float)$well->lat],
                    ];
                }
            );

        $zuPoints = \App\Models\Refs\Zu::query()
            ->whereHas('gu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get()
            ->map(
                function ($zu) {
                    return [
                        'name' => $zu->name,
                        'coords' => [(float)$zu->lon, (float)$zu->lat],
                    ];
                }
            );

        $guPoints = [];
        foreach ($gus as $gu) {
            if ($gu->lat && $gu->lon) {
                $guPoints[] = [
                    'id' => $gu->id,
                    'name' => $gu->name,
                    'coords' => [(float)$gu->lon, (float)$gu->lat]
                ];
            }
        }


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
        foreach($wellOil as $row) {
            $result[$row['uwi']] = $row['oil'];
        }
        return $result;
    }

}
