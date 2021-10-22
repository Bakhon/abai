<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\BigData\WellSearchResource;
use App\Models\BigData\BottomHole;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\GdisCurrent;
use App\Models\BigData\GdisCurrentValue;
use App\Models\BigData\LabResearchValue;
use App\Models\BigData\WellStatus;
use App\Models\BigData\MeasLiq;
use App\Models\BigData\MeasWaterCut;
use App\Models\BigData\Well;
use App\Models\BigData\WellWorkover;
use App\Models\BigData\Gtm;
use App\Repositories\WellCardGraphRepository;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WellsController extends Controller
{

    private $wellCardGraphRepo;

    public function  __construct(WellCardGraphRepository $wellCardGraphRepo)
    {
        $this->wellCardGraphRepo = $wellCardGraphRepo;
    }

    public function getStructureTree(StructureService $service, Request $request)
    {
        return $service->getTreeWithPermissions();
    }

    public function wellInfo($well)
    {
        $well = Well::select('id','uwi', 'drill_start_date', 'drill_end_date')->find($well);
        if (Cache::has('well_' . $well->id)) {
            return Cache::get('well_' . $well->id);
        }

        $orgs = $this->org($well);
        $wellInfo = [
            'wellInfo' => $well,
            'status' => $this->status($well),
            'tube_nom' => $this->tubeNom($well),
            'category' => $this->category($well),
            'category_last' => $this->categoryLast($well),
            'geo' => $this->geo($well),
            'well_expl' => $this->wellExpl($well),
            'techs' => $this->techs($well),
            'tap' => $this->tap($well),
            'well_type' => $this->wellType($well),
            'org' => $this->structureOrg($orgs),
            'main_org_code'=>$this->orgCode($orgs),
            'spatial_object' => $this->spatialObject($well),
            'spatial_object_bottom' => $this->spatialObjectBottom($well),
            'actual_bottom_hole' => $this->actualBottomHole($well),
            'lab_research_value' => $this->labResearchValue($well),
            'artificial_bottom_hole' => $this->artificialBottomHole($well),
            'well_perf_actual' => $this->wellPerfActual($well),
            'techModeProdOil' => $this->techModeProdOil($well),
            'tech_mode_inj' => $this->techModeInj($well),
            'krs_well_workover' => $this->getKrsPrs($well, 1),
            'prs_well_workover' => $this->getKrsPrs($well, 3),
            'well_treatment' => $this->wellTreatment($well),
            'well_treatment_sko' => $this->wellTreatmentSko($well),
            'gis' => $this->gis($well),
            'zone' => $this->zone($well),
            'well_react_infl' => $this->wellReact($well),
            'gtm' => $this->gtm($well),
            'rzatr_atm' => $this->gdisCurrentValueRzatr($well, 'FLVL'),
            'rzatr_stat' => $this->gdisCurrentValueRzatr($well, 'STLV'),
            'gu' => $this->getTechsByCode($well, [1, 3]),
            'agms' => $this->getTechsByCode($well, [2000000000004]),
        ];

        Cache::put('well_' . $well->id, $wellInfo, now()->addDay());
        return $wellInfo;
    }

    private function getToday(): Carbon
    {
        return Carbon::today();
    }

    private function geo(Well $well)
    {
        $geo_object = new Geo();
        $allParents = [];
        $parent = null;
        $item = $well->getGeo($this->getToday());
        if(isset($item))
        {
            $geo_tree = $geo_object->parentTree($item->id);
            $not_duplicate=[];
            $count_tree = count($geo_tree)-1;
            foreach($geo_tree as $key=>$geo_item)
            {
                if(!in_array($geo_item->geo,$not_duplicate))
                {
                    $parents_id[] = $geo_item->geo;
                    $not_duplicate[] = $geo_item->geo;
                }
                if($key==$count_tree)
                {
                    $parents_id[] = $geo_item->parent;
                }
            }

            if(isset($parents_id))
            {
                $items = $geo_object->getItems($parents_id);
                foreach($items as $item)
                {
                        $key = array_search($item->id, $parents_id);
                        $allParents[$key] = $item;
                }
            }

        }
        return $allParents;
    }


    public function get(Well $well)
    {
        return $well;
    }

    private function status(Well $well)
    {
        $status = $well->status()
            ->wherePivot('dend', '>', $this->getToday())
            ->wherePivot('dbeg', '<=', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru']);
        return ($status);
    }

    private function tubeNom(Well $well)
    {
        return $well->tubeNom()
            ->wherePivot('project_drill', '=', 'false')
            ->wherePivot('casing_type', '=', '8', 'or')
            ->WherePivot('casing_type', '=', '9')
            ->get(['dict.tube_nom.od']);
    }

    private function category(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '>', $this->getToday())
            ->wherePivot('dbeg', '<=', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->first(['name_ru']);
    }

    private function categoryLast(Well $well)
    {
        return $well->category()
            ->wherePivot('dend', '>', $this->getToday())
            ->wherePivot('dbeg', '<=', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['name_ru',]);
    }

    private function wellExpl(Well $well)
    {
        return $well->wellExpl()
            ->withPivot('dend as dend', 'dbeg as dbeg')
            ->orderBy('dbeg', 'desc')
            ->first(['name_ru', 'dend', 'dbeg']);
    }

    private function techs(Well $well)
    {
        $tech = new Tech();
        $allParents = [];
        $item = $well->getRelationTech($this->getToday());
        if ($item)
        {
            $dict_techs = $tech->parentTree($item->id);
            foreach($dict_techs as $dict_tech)
            {
                $allParents[]['name_ru'] = $dict_tech->name;
            }
            if(!empty($allParents))
            {
                $allParents = array_reverse($allParents);
            }
        }
        return $allParents;
    }

    private function tap(Well $well)
    {
        return $well->techs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg', 'tap as tap')
            ->orderBy('pivot_dbeg', 'desc')
            ->first(['tap']);
    }

    private function wellType(Well $well)
    {
        return $well->wellType()
            ->first(['name_ru']);
    }

    private function org(Well $well)
    {
        $dict_orgs = [];
        $org_object = new Org();
        $item = $well->getRelationOrg($this->getToday());
        if (isset($item))
        {
            $dict_orgs = $org_object->parentTree($item->id);
        }

        return $dict_orgs;
    }

    private function orgCode(array $dict_orgs)
    {
        foreach($dict_orgs as $dict_org)
        {
            if(!$dict_org->parent)
            {
                return $dict_org->code;
            }
        }
        return null;
    }

    private function structureOrg(array $dict_orgs)
    {
        $allParents = [];
        foreach($dict_orgs as $dict_org)
        {
            $allParents[]['name_ru'] = $dict_org->name;
        }

        return $allParents;
    }

    private function spatialObject(Well $well)
    {
        return $well->spatialObject()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    private function spatialObjectBottom(Well $well)
    {
        return $well->spatialObjectBottom()
            ->where('spatial_object_type', '=', '1')
            ->first(['coord_point']);
    }

    private function actualBottomHole(Well $well)
    {
        return BottomHole::where('well', $well->id)->where('bottom_hole_type', 1)->orderBy('depth', 'desc')->first();
    }

    private function artificialBottomHole(Well $well)
    {
        return BottomHole::where('well', $well->id)->where('bottom_hole_type', 2)->orderBy('depth', 'desc')->first();
    }

    private function labResearchValue(Well $well)
    {
        $lab_research_value = new LabResearchValue();
        return $lab_research_value->Rnas($well->id);
    }

    private function techModeInj(Well $well)
    {
        return $well->techModeInj()
            ->first(['inj_pressure', 'agent_vol']);
    }

    private function techModeProdOil(Well $well)
    {
        return $well->techModeProdOil()
            ->orderBy('dbeg', 'desc')
            ->first(['oil', 'liquid', 'wcut', 'oil_density']);
    }

    private function measLiq(Well $well)
    {
        return $well->measLiq()
            ->orderBy('dbeg', 'desc')
            ->first('liquid');
    }

    private function wellPerfActual(Well $well)
    {
        return $well->wellPerfActual()
            ->first();
    }

    private function measWaterCut(Well $well)
    {
        return $well->measWaterCut()
            ->orderBy('dbeg', 'desc')
            ->first(['water_cut']);
    }

    private function getKrsPrs(Well $well, $code)
    {
        $wellWorkover = $well->wellWorkover()->where('repair_type', $code)->orderBy('dbeg', 'desc')->first(['dbeg', 'dend']);
        if (isset($wellWorkover)) {
            return $wellWorkover;
        }
        return ['dend' => '', 'dbeg' => ''];
    }

    private function wellTreatment(Well $well)
    {
        return $well->wellTreatment()
            ->where('treatment_type', '=', '14')
            ->first(['treat_date']);
    }

    private function gdisCurrent(Well $well)
    {
        return $well->gdisCurrent()
            ->orderBy('meas_date', 'desc')
            ->first(['meas_date', 'note']);
    }

    private function wellTreatmentSko(Well $well)
    {
        return $well->wellTreatment()
            ->where('treatment_type', '=', '21')
            ->first(['treat_date']);
    }

    private function gdisConclusion(Well $well)
    {
        return $well->gdisConclusion()
            ->withPivot('meas_date')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['name_ru']);
    }

    private function gdisCurrentValue(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'PLST')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double']);
    }

    private function gdisCurrentValuePmpr(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'PMPR')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double']);
    }

    private function gdisCurrentValueFlvl(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'FLVL')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double']);
    }

    private function gdisCurrentValueStatic(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'STLV')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double']);
    }

    private function gdisCurrentValueRp(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'RP')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double', 'meas_date']);
    }

    private function gdisCurrentValueBhp(Well $well)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'BHP')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double', 'meas_date']);
    }

    private function gdisCurrentValueRzatr(Well $well, $method)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'gdis_current_value.metric', '=', 'dict.metric.id')
            ->join('prod.gdis_current as gdis_otp', 'prod.gdis_current.id', 'gdis_current_value.gdis_curr')
            ->join('dict.metric as metric_otp', 'gdis_current_value.metric', '=', 'dict.metric.id')
            ->where('metric_otp.code', '=', 'OTP')
            ->where('metric_otp.code', '=', $method)
            ->first();
    }

    private function gdisComplex(Well $well)
    {
        return $well->gdisComplex()
            ->join('dict.metric', 'prod.gdis_complex_value.metric', '=', 'dict.metric.id')
            ->withPivot('research_date as research_date')
            ->where('metric.code', '=', 'RP')
            ->orderBy('research_date', 'desc')
            ->first(['value_double', 'research_date']);
    }

    private function gis(Well $well)
    {
        return $well->gis()
            ->where('gis_type', '=', '1')
            ->orderBy('gis_date', 'desc')
            ->first(['gis_date']);
    }

    private function wellReact(Well $well)
    {
        return $well->wellReact()->first();
    }

    private function zone(Well $well)
    {
        return $well->zone()
            ->withPivot('dend as dend')
            ->wherePivot('dend', '>=', $this->getToday())
            ->orderBy('dend', 'desc')
            ->first(['name_ru', 'dend']);
    }

    private function gtm(Well $well)
    {
        $gtm = $well->gtm()->join('dict.gtm_type', 'prod.gtm.gtm_type', '=', 'dict.gtm_type.id')
            ->where('dict.gtm_type.gtm_kind', '=', '10')
            ->first(['dbeg']);
        if (isset($gtm)) {
            return $gtm;
        }
        return ['dend' => ''];
    }

    private function getTechsByCode(Well $well, $techTypes)
    {
        return $well->techs()->whereIn('tech_type', $techTypes)->first(['name_ru']);
    }

    public function search(StructureService $service, Request $request): array
    {
        if (empty($request->get('query'))) {
            return [];
        }
        $selectedUserDzo = $request->get('selectedUserDzo');
        $childrenIds = [];
        $orgsTree = $service->getTree(Carbon::now());
        if ($selectedUserDzo) {
            $childrenIds = $service::getChildIds($orgsTree, $selectedUserDzo);
        } else {
            $userDzoIds = array_map(function ($item) {
                return substr($item, strpos($item, ":") + 1);
            }, auth()->user()->org_structure);
            foreach ($userDzoIds as $userDzoId) {
                $childrenIds = array_merge($childrenIds, $service::getChildIds($orgsTree, $userDzoId));
            }
        }
        $wells = Well::query()
            ->whereRaw("LOWER(uwi) LIKE '%" . strtolower($request->get('query')) . "%'");
        if ($childrenIds) {
            $wells->whereHas('orgs', function ($query) use ($childrenIds) {
                    $query->whereIn('org.id', $childrenIds);
                });
        }
        $wells = $wells->paginate(30);

        return [
            'items' => WellSearchResource::collection($wells)
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProductionWellsScheduleData(Request $request):object {
        $wellId = $request->get('wellId');
        $period = $request->get('period');
        $result = $this->wellCardGraphRepo->wellItems($wellId,$period);
        return response()->json($result);
    }

    public function getInjectionHistory($wellId)
    {
        $measLiqs = MeasLiq::where('well', $wellId)
            ->orderBy('dbeg', 'asc')
            ->get();
        $groupedLiq = $measLiqs->groupBy(function($val) {
            return Carbon::parse($val->dbeg)->format('Y');
        });
        $liqByMonths = array();
        foreach($groupedLiq as $yearNumber => $value) {
            $liqByMonths[$yearNumber] = $value->groupBy(function($val) {
                   return Carbon::parse($val->dbeg)->format('m');
            });
        }

        $result = array();
        foreach($liqByMonths as $yearNumber => $monthes) {
           foreach($monthes as $monthNumber => $month) {
              $result[$yearNumber][$monthNumber] = array();
              foreach($month as $dayNumber => $day) {
                 $date = Carbon::parse($day['dbeg']);
                 $dateEnd = Carbon::parse($day['dend']);

                 array_push($result[$yearNumber][$monthNumber], array (
                    'liq' => $day['liquid'],
                    'date' => $date->format('Y-m-d'),
                    'workHours' => $date->diffInDays($dateEnd),
                 ));
              }
           }
        }
        return $result;
    }

    public function getActivityByWell(Request $request,$wellId)
    {

        $wellWorkover = WellWorkover::query()
            ->select(['dbeg','well','repair_type','work_plan','well_status'])
            ->whereIn('repair_type', [1,3])
            ->whereYear('dbeg',$request->year)
            ->whereMonth('dbeg',$request->month)
            ->where('well',$wellId)
            ->get();
        $wellWorkoverEnd = WellWorkover::query()
            ->select(['dend','well','repair_type','well_status','work_list'])
            ->whereIn('repair_type', [1,3])
            ->whereYear('dend',$request->year)
            ->whereMonth('dend',$request->month)
            ->where('well',$wellId)
            ->get();
        foreach($wellWorkoverEnd as $workEnd) {
            $wellWorkover->push($workEnd);
        }
        $gtms = Gtm::query()
            ->select(['param_result','gtm_type','dbeg'])
            ->where('well', $wellId)
            ->whereYear('dbeg',$request->year)
            ->whereMonth('dbeg',$request->month)
            ->get();
        foreach($gtms as $gtm) {
            $wellWorkover->push(array(
                'dbeg' => $gtm->dbeg,
                'repair_type' => $gtm->gtm_type->name_ru
            ));
        }
        return $wellWorkover;
    }
}
