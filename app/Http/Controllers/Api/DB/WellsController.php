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
    public function wellInfo(well $well)
    {
        return array(
            'well' => $this->get($well),
            'status' => $this->status($well),
            'tube_nom' => $this->tube_nom($well),
            'category' => $this->category($well),
            'category_last' => $this->category_last($well),
            'geo' => $this->geo($well),
            'well_expl' => $this->well_expl($well),
            'techs' => $this->techs($well),
            'well_type' => $this->well_type($well),
            'org' => $this->org($well),
            'spatial_object' => $this->spatial_object($well),
            'spatial_object_bottom' => $this->spatial_object_bottom($well),
            'actual_bottom_hole' => $this->actual_bottom_hole($well),
        );
    }

    public function getToday(): Carbon
    {
        return Carbon::today();
    }

    public function get(Well $well)
    {
        return $well;
    }

    public function status(Well $well)
    {
        $status = $well->status()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
        return ($status);
    }

    public function tube_nom(Well $well)
    {
        return $well->tube_nom()
            ->wherePivot('project_drill', '=', 'false')
            ->wherePivot('casing_type', '=', '8', 'or')
            ->WherePivot('casing_type', '=', '9')
            ->get(['od']);
    }

    public function category(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
    }

    public function category_last(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
    }

    public function geo(Well $well)
    {
        return $well->geo()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
    }

    public function well_expl(Well $well)
    {
        return $well->well_expl()
            ->where('dend', '<>', $this->getToday())
            ->where('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('dbeg', 'desc')
            ->first(['name_ru']);
    }

    public function techs(Well $well)
    {
        return $well->techs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg', 'tap')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
    }

    public function well_type(Well $well)
    {
        return $well->well_type()
            ->first(['name_ru']);
    }

    public function org(Well $well)
    {
        return $well->orgs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
    }

    public function spatial_object(Well $well)
    {
        return $well->spatial_object()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    public function spatial_object_bottom(Well $well)
    {
        return $well->spatial_object_bottom()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    public function actual_bottom_hole(Well $well)
    {
        return $well->bottom_hole()
            ->where('bottom_hole_type', '=', '1')
            ->withPivot('depth')
            ->first();
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
