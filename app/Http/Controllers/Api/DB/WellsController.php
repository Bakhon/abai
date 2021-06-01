<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\BigData\WellInfoResource;
use App\Http\Resources\BigData\WellSearchResource;
use App\Models\BigData\Well;
use Illuminate\Http\Request;
use Carbon\Carbon;


class WellsController extends Controller
{
    public function get(Well $well)
    {
        $wellInfo = Well::where('id', $well->id)->with('category', 'techs', 'geo', 'orgs', 'status', 'well_type', 'well_expl', 'tube_nom')->first();
        return $wellInfo;
    }

    public function status(Well $well):array
    {
        $today = Carbon::today();
        $ststus = $well->status()->wherePivot('dend', '<>', $today)->first();
        return [
            'status' => new WellInfoResource($ststus)
        ];
        //return $ststus;
    }

    public function search(Request $request): array
    {
        if (empty($request->get('query'))) {
            return [];
        }

        $wells = Well::query()
            ->whereRaw("LOWER(uwi) LIKE '%" . strtolower($request->get('query')) . "%'")
            ->paginate(30);

        return [
            'items' => WellSearchResource::collection($wells)
        ];
    }
}
