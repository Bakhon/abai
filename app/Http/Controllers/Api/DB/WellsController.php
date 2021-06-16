<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\BigData\WellSearchResource;
use App\Models\BigData\Well;
use App\Models\BigData\TechModeProdOil;
use Illuminate\Http\Request;
use Carbon\Carbon;


class WellsController extends Controller
{
    public function wellInfo(well $well)
    {
        return array(
            'well' => $this->get($well),
            'status' => $this->status($well),
            'tube_nom' => $this->tubeNom($well),
            'category' => $this->category($well),
            'category_last' => $this->categoryLast($well),
            'geo' => $this->geo($well),
            'well_expl' => $this->wellExpl($well),
            'techs' => $this->techs($well),
            'well_type' => $this->wellType($well),
            'org' => $this->org($well),
            'spatial_object' => $this->spatialObject($well),
            'spatial_object_bottom' => $this->spatialObjectBottom($well),
            'actual_bottom_hole' => $this->actualBottomHole($well),
            'lab_research_value' => $this->LabResearchValue($well),
            'artificial_bottom_hole' => $this->artificialBottomHole($well),
            'well_perf_actual' => $this->WellPerfActual($well),
            'tech_mode_prod_oil' => $this->TechModeProdOil($well),
            'tech_mode_inj' => $this->TechModeInj($well),
            'meas_liq' => $this->MeasLiq($well),
            'meas_water_cut' => $this->MeasWaterCut($well),
            'krs_well_workover' => $this->KrsWellWorkover($well),
            'well_treatment' => $this->WellTreatment($well),
        );
    }

    private function getToday(): Carbon
    {
        return Carbon::today();
    }

    private function get(Well $well)
    {
        return $well;
    }

    private function status(Well $well)
    {
        $status = $well->status()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
        return ($status);
    }

    private function tubeNom(Well $well)
    {
        return $well->tube_nom()
            ->wherePivot('project_drill', '=', 'false')
            ->wherePivot('casing_type', '=', '8', 'or')
            ->WherePivot('casing_type', '=', '9')
            ->get(['od']);
    }

    private function category(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
    }

    private function categoryLast(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
    }

    private function geo(Well $well)
    {
        return $well->geo()
            ->wherePivot('dend', '<>', $this->getToday())
            ->wherePivot('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
    }

    private function wellExpl(Well $well)
    {
        return $well->well_expl()
            ->where('dend', '<>', $this->getToday())
            ->where('dbeg', '<>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('dbeg', 'desc')
            ->first(['name_ru']);
    }

    private function techs(Well $well)
    {
        return $well->techs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg', 'tap as tap')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
    }

    private function wellType(Well $well)
    {
        return $well->well_type()
            ->first(['name_ru']);
    }

    private function org(Well $well)
    {
        return $well->orgs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->get();
    }

    private function spatialObject(Well $well)
    {
        return $well->spatial_object()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    private function spatialObjectBottom(Well $well)
    {
        return $well->spatial_object_bottom()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    private function actualBottomHole(Well $well)
    {
        return $well->bottom_hole()
            ->where('bottom_hole_type', '=', '1')
            ->withPivot('depth')
            ->first();
    }

    private function artificialBottomHole(Well $well)
    {
        return $well->bottom_hole()
            ->where('bottom_hole_type', '=', '2')
            ->withPivot('depth')
            ->first();
    }

    private function LabResearchValue(Well $well)
    {
        return $well->lab_research_value()
            ->withPivot('research_date as research_date')
            ->orderBy('research_date', 'desc')
            ->first(['value_double', 'research_date']);
    }

    private function TechModeInj(Well $well)
    {
        return $well->tech_mode_inj()
            ->first(['inj_pressure', 'agent_vol']);
    }

    private function TechModeProdOil(Well $well)
    {
        return $well->tech_mode_prod_oil()
            ->orderBy('dbeg', 'desc')
            ->first(['oil', 'liquid']);
    }

    private function MeasLiq(Well $well)
    {
        return $well->meas_liq()
            ->orderBy('dbeg', 'desc')
            ->first('liquid');
    }

    private function WellPerfActual(Well $well)
    {
        return $well->well_perf_actual()
            ->first();
    }

    private function MeasWaterCut(Well $well)
    {
        return $well->meas_water_cut()
            ->orderBy('dbeg', 'desc')
            ->first(['water_cut']);
    }

    private function KrsWellWorkover(Well $well)
    {
        return $well->well_workover()
            ->where('repair_type', '=', '1')
            ->orderBy('dbeg', 'desc')
            ->first(['dbeg', 'dend']);
    }

    private function WellTreatment(Well $well)
    {
        return $well->well_treatment()
            ->where('treatment_type', '=', '21')
            ->first(['treat_date']);
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
