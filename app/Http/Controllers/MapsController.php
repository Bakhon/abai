<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    protected $mapService;

    public function __construct(\App\Services\MapService $mapService)
    {
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

    public function guPipes(Request $request)
    {
        $gus = \App\Models\Refs\Gu::all();

        $coordinates = [];
        $zuPipes = \App\Models\Pipes\GuZuPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if(!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }
                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        array_map(
                            function ($coord) {
                                return array_reverse($coord);
                            },
                            $pipe->coordinates
                        )
                    );
                    return [
                        'id' => $pipe->id,
                        'coordinates' => array_map(
                            function ($coord) {
                                return array_reverse($coord);
                            },
                            $pipe->coordinates
                        )
                    ];
                }
            );

        $wellPipes = \App\Models\Pipes\ZuWellPipe::query()
            ->whereHas('gu')
            ->get()
            ->map(
                function ($pipe) use (&$coordinates) {
                    if(!isset($coordinates[$pipe->gu_id])) {
                        $coordinates[$pipe->gu_id] = [];
                    }
                    $coordinates[$pipe->gu_id] = array_merge(
                        $coordinates[$pipe->gu_id],
                        array_map(
                            function ($coord) {
                                return array_reverse($coord);
                            },
                            $pipe->coordinates
                        )
                    );
                    return [
                        'id' => $pipe->id,
                        'coordinates' => array_map(
                            function ($coord) {
                                return array_reverse($coord);
                            },
                            $pipe->coordinates
                        )
                    ];
                }
            );

        foreach($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);

        $wellPoints = \App\Models\Refs\Well::query()
            ->whereHas('zu.gu')
            ->whereNotNull('wells.lat')
            ->whereNotNull('wells.lon')
            ->get()
            ->map(
                function ($well) {
                    return [
                        'name' => $well->name,
                        'coords' => [$well->lon, $well->lat],
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
                        'coords' => [$zu->lon, $zu->lat],
                    ];
                }
            );

        $guPoints = [];
        foreach ($gus as $gu) {
            if ($gu->lat && $gu->lon) {
                $guPoints[] = [
                    'id' => $gu->id,
                    'name' => $gu->name,
                    'coords' => [$gu->lon, $gu->lat]
                ];
            }
        }


        return [
            'wellPipes' => $wellPipes,
            'zuPipes' => $zuPipes,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'guCenters' => $guCenters,
            'center' => $center,
        ];
    }

}
