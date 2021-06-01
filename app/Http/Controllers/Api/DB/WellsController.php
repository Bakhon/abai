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
        $wellInfo = Well::where('id', $well->id)->with('techs', 'geo', 'orgs', 'well_type', 'well_expl', 'tube_nom')->first();
        return $wellInfo;
    }

    public function status(Well $well)
    {
        $today = Carbon::today();
        $status = $well->status()
            ->wherePivot('dend', '<>', $today)
            ->wherePivot('dbeg', '<>', $today)
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')->first();
       return $status;
    }
    public function category(Well $well)
    {
        $today = Carbon::today();
        $category = $well->category()
            ->wherePivot('dend', '<>', $today)
            ->wherePivot('dbeg', '<>', $today)
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')->first();
        return $category;
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
