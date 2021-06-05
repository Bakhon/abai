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
    public function getToday(): Carbon
    {
        return Carbon::today();
    }

    public function get(Well $well)
    {
        $wellInfo = Well::where('id', $well->id)->with('spatial_object')
            ->first();
        return $wellInfo;
    }

    public function status(Well $well)
    {
        $status = $well->status()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
        return $status;
    }

    public function tube_nom(Well $well)
    {
        $tube_nom = $well->tube_nom()
            ->wherePivot('project_drill', '=', 'false')
            ->wherePivot('casing_type', '=', '8', 'or')
            ->WherePivot('casing_type', '=', '9')
            ->get(['od']);
        return $tube_nom;
    }

    public function category(Well $well)
    {
        $category = $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
        return $category;
    }

    public function category_last(Well $well)
    {
        $category = $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
        return $category;
    }

    public function geo(Well $well)
    {
        $geo = $well->geo()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
        return $geo;
    }

    public function well_expl(Well $well)
    {
        $well_expl = $well->well_expl()
            ->where('dend', '<>', $this->getToday())
            ->where('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('dbeg', 'desc')
            ->first(['name_ru']);
        return $well_expl;
    }

    public function techs(Well $well)
    {
        $techs = $well->techs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg', 'tap')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
        return $techs;
    }

    public function well_type(Well $well)
    {
        $well_type = $well->well_type()
            ->first(['name_ru']);
        return $well_type;
    }

    public function org(Well $well)
    {
        $org = $well->orgs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
        return $org;
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
