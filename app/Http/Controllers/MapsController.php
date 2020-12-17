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
        $gu = \App\Models\Refs\Gu::find($request->get('gu'));

        $coordinates = [];
        $zuPipes = $gu->zuPipes->map(function($pipe) use(&$coordinates) {
            $coordinates = array_merge($coordinates, $pipe->coordinates);
            return [
                'id' => $pipe->id,
                'coordinates' => $pipe->coordinates
            ];
        });

        $wellPipes = $gu->wellPipes->map(function($pipe) use(&$coordinates) {
            $coordinates = array_merge($coordinates, $pipe->coordinates);
            return [
                'id' => $pipe->id,
                'coordinates' => $pipe->coordinates
            ];
        });

        $center = !empty($coordinates) ? $this->mapService->calculateCenterOfCoordinates($coordinates) : null;

        $wellPoints = $gu->wells()
            ->whereNotNull('wells.lat')
            ->whereNotNull('wells.lon')
            ->get()
            ->map(function($well){
                return [
                    'name' => $well->name,
                    'coords' => [$well->lat, $well->lon],
                ];
            });

        $zuPoints = $gu->zus()
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get()
            ->map(function($zu){
                return [
                    'name' => $zu->name,
                    'coords' => [$zu->lat, $zu->lon],
                ];
            });

        $guPoint = null;
        if($gu->lat && $gu->lon) {
            $guPoint = [
                'name' => $gu->name,
                'coords' => [$gu->lat, $gu->lon]
            ];
        }


        return [
            'wellPipes' => $wellPipes,
            'zuPipes' => $zuPipes,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoint' => $guPoint,
            'center' => $center
        ];
    }

}
