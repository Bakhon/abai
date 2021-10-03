<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\BigData\WellSearchResource;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\Well as dictWell;
use App\Models\BigData\GdisCurrent;
use App\Models\BigData\GdisCurrentValue;
use App\Models\BigData\WellStatus;
use App\Models\BigData\MeasLiq;
use App\Models\BigData\MeasWaterCut;
use App\Models\BigData\MeasLiqInjection;
use App\Models\BigData\Well;
use App\Models\BigData\WellWorkover;
use App\Models\BigData\Gtm;
use App\Services\BigData\StructureService;
use App\Services\BigData\MeasLogByMonth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WellsController extends Controller
{
    public function getStructureTree(StructureService $service, Request $request)
    {
        return $service->getTreeWithPermissions();
    }

    public function wellInfo(well $well)
    {
        return array(
            'wellInfo' => $this->get($well),
            'status' => $this->status($well),
            'tube_nom' => $this->tubeNom($well),
            'category' => $this->category($well),
            'category_last' => $this->categoryLast($well),
            'geo' => $this->geo($well),
            'well_expl' => $this->wellExpl($well),
            'techs' => $this->techs($well),
            'tap' => $this->tap($well),
            'well_type' => $this->wellType($well),
            'org' => $this->org($well),
            'spatial_object' => $this->spatialObject($well),
            'spatial_object_bottom' => $this->spatialObjectBottom($well),
            'actual_bottom_hole' => $this->actualBottomHole($well),
            'lab_research_value' => $this->labResearchValue($well),
            'artificial_bottom_hole' => $this->artificialBottomHole($well),
            'well_perf_actual' => $this->wellPerfActual($well),
            'techModeProdOil' => $this->techModeProdOil($well),
            'tech_mode_inj' => $this->techModeInj($well),
            'meas_liq' => $this->measLiq($well),
            'meas_water_cut' => $this->measWaterCut($well),
            'krs_well_workover' => $this->getKrsPrs($well, 1),
            'prs_well_workover' => $this->getKrsPrs($well, 3),
            'well_treatment' => $this->wellTreatment($well),
            'well_treatment_sko' => $this->wellTreatmentSko($well),
            'gdis_current' => $this->gdisCurrent($well),
            'gdis_conclusion' => $this->gdisConclusion($well),
            'gdis_current_value' => $this->gdisCurrentValue($well),
            'gdis_current_value_pmpr' => $this->gdisCurrentValuePmpr($well),
            'gdis_current_value_flvl' => $this->gdisCurrentValueFlvl($well),
            'gdis_current_value_static' => $this->gdisCurrentValueStatic($well),
            'gdis_current_value_rp' => $this->gdisCurrentValueRp($well),
            'gdis_current_value_bhp' => $this->gdisCurrentValueBhp($well),
            'gdis_complex' => $this->gdisComplex($well),
            'gis' => $this->gis($well),
            'zone' => $this->zone($well),
            'well_react_infl' => $this->wellReact($well),
            'gtm' => $this->gtm($well),
            'rzatr_atm' => $this->gdisCurrentValueRzatr($well, 'FLVL'),
            'rzatr_stat' => $this->gdisCurrentValueRzatr($well, 'STLV'),
            'gu' => $this->getTechsByCode($well, 'GU'),
            'agms' => $this->getTechsByCode($well, 'AGMS'),
        );
    }

    private function getToday(): Carbon
    {
        return Carbon::today();
    }

    private function geo(Well $well)
    {
        $allParents = [];
        $parent = null;
        if (isset($well->geo()->wherePivot('dend', '>', $this->getToday())
                ->wherePivot('dbeg', '<=', $this->getToday())
                ->withPivot('dend', 'dbeg')
                ->first()->id)) {
            $parent = $well->geo()
                ->wherePivot('dend', '>', $this->getToday())
                ->wherePivot('dbeg', '<=', $this->getToday())
                ->withPivot('dend', 'dbeg')
                ->orderBy('pivot_dbeg')
                ->first()->id;
        }
        while ($parent != null) {
            array_push($allParents, Geo::all()->find($parent));
            if (isset(Geo::with('firstParent')->find($parent)->firstParent->where('dend', '>', $this->getToday())
                    ->where('dbeg', '<=', $this->getToday())->first()->parent)) {
                $parent = Geo::with('firstParent')
                    ->find($parent)
                    ->firstParent
                    ->where('dend', '>', $this->getToday())
                    ->where('dbeg', '<=', $this->getToday())
                    ->first()->parent;
            } else {
                return $allParents;
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
            ->get(['od']);
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
        $allParents = [];
        $parent = null;
        if (isset($well->techs()
                ->wherePivot('dend', '>', $this->getToday())
                ->withPivot('dend', 'dbeg', 'tap as tap')
                ->orderBy('pivot_dbeg', 'desc')
                ->first()->id)) {
            $parent = $well->techs()
                ->wherePivot('dend', '>', $this->getToday())
                ->withPivot('dend', 'dbeg', 'tap as tap')
                ->orderBy('pivot_dbeg', 'desc')
                ->first()->id;
        }
        while ($parent != null) {
            array_push($allParents, Tech::all()->find($parent));
            if (isset(Tech::all()->where('dend', '>', $this->getToday())->find($parent)->parent)) {
                $parent = Tech::all()->where('dend', '>', $this->getToday())->find($parent)->parent;
            } else {
                return $allParents;
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
        $allParents = [];
        $parent = null;
        if (isset($well->orgs()
                ->wherePivot('dend', '>', $this->getToday())
                ->withPivot('dend', 'dbeg')
                ->orderBy('pivot_dbeg', 'desc')
                ->first()->id)) {
            $parent = $well->orgs()
                ->wherePivot('dend', '>', $this->getToday())
                ->withPivot('dend', 'dbeg')
                ->orderBy('pivot_dbeg', 'desc')
                ->first()->id;
        }
        while ($parent != null) {
            array_push($allParents, Org::all()->find($parent));
            if (isset(Org::all()->where('dend', '>', $this->getToday())->find($parent)->parent)) {
                $parent = Org::all()->where('dend', '>', $this->getToday())->find($parent)->parent;
            } else {
                return $allParents;
            }
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
        return $well->bottomHole()
            ->where('bottom_hole_type', '=', '1')
            ->withPivot('depth')
            ->first();
    }

    private function artificialBottomHole(Well $well)
    {
        return $well->bottomHole()
            ->where('bottom_hole_type', '=', '2')
            ->withPivot('depth')
            ->first();
    }

    private function labResearchValue(Well $well)
    {
        return $well->labResearchValue()
            ->withPivot('research_date as research_date')
            ->orderBy('research_date', 'desc')
            ->first(['value_double', 'research_date']);
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
            ->first(['oil', 'liquid']);
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

    private function getTechsByCode(Well $well, $code)
    {
        return $well->techs()
            ->join('dict.tech_type', 'dict.tech_type.id', '=', 'dict.tech.tech_type')
            ->where('dict.tech_type.code', '=', $code)
            ->where('dict.tech.dbeg', '<=', $this->getToday())
            ->where('dict.tech.dend', '>=', $this->getToday())
            ->first(['dict.tech.name_ru']);
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

    public function getProductionWellsScheduleData(Request $request):array {
        $result = [
            'measLiq' => [
                'name' => trans('app.liquid'),
                'type' => 'area',
                'data' => [],
                ],
            'measWaterCut' => [
                'name' => trans('app.waterCut'),
                'type' => 'line',
                'data' => [],
                ],
            'oil' => [
                'name' => trans('app.oil'),
                'type' => 'area',
                'data' => [],
                ],
            'ndin' => [
                'name' => trans('app.ndin'),
                'type' => 'line',
                'data' => [],
            ],
            'labels' => [],
            'wellStatuses' => [],
        ];
        $wellId = $request->get('wellId');
        $period = $request->get('period');
        $dateFrom = Carbon::now('Asia/Almaty');
        $measLiqs = MeasLiq::where('well', $wellId);
        $measWaterCuts = MeasWaterCut::where('well', $wellId);
        $wellStatuses = WellStatus::where('well', $wellId);
        $gdisCurrent = GdisCurrent::where('well', $wellId);
        $gdisCurrentValueResult = [];
        if ($period) {
            $dateFrom->subDays($period);
            $measLiqs->where('dbeg', '>=', $dateFrom);
            $measWaterCuts->where('dbeg', '>=', $dateFrom);
            $wellStatuses->where('dbeg', '>=', $dateFrom);
            if ($gdisCurrent) {
                $gdisCurrent->where('meas_date', '>=', $dateFrom);
            }
        }
        $measLiqs = $measLiqs->orderBy('dbeg', 'asc')
            ->get()
            ->toArray();
        $measWaterCuts = $measWaterCuts->orderBy('dbeg', 'asc')
            ->get()
            ->toArray();
        $wellStatuses = $wellStatuses->with('statusType')
            ->orderBy('dbeg', 'asc')
            ->get()
            ->toArray();
        if ($gdisCurrent) {
            $gdisCurrent = $gdisCurrent
                ->get()
                ->toArray();
            $gdisCurrent = array_map(function ($item) {
                return $item['id'];
            }, $gdisCurrent);
            if ($gdisCurrent) {
                $metric = Metric::where('code', 'FLVL')->first();
                if($metric) {
                    $gdisCurrentValue = GdisCurrentValue::where('metric', $metric->id)
                        ->whereIn('gdis_curr', $gdisCurrent)
                        ->with('gdisCurrent')
                        ->get();
                    foreach ($gdisCurrentValue as $gdisCurrentValueItem) {
                        $gdisCurrentValueResult[] = [
                            'value_double' => $gdisCurrentValueItem['value_double'],
                            'meas_date' => $gdisCurrentValueItem->gdisCurrent->meas_date
                        ];
                    }
                }
            }
        }
        foreach ($wellStatuses as $wellStatus) {
            $result['wellStatuses'][] = [
                DateTime::createFromFormat('Y-m-d H:i:sP', $wellStatus['dbeg'])->format('Y-m-d'),
                $wellStatus['status_type']['code'],
                $wellStatus['status_type']['name_ru'],
            ];
        }

        foreach ($measLiqs as $measLiq) {
            $measWaterCutVal = $oilVal = $gdisCurrentVal = 0;
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:sP', $measLiq['dbeg']);
            $result['measLiq']['data'][] = $measLiq['liquid'];
            $result['labels'][] = $dateTime->format('Y-m-d');
            foreach ($measWaterCuts as $measWaterCut) {
                $dateTimeWCBeg = DateTime::createFromFormat('Y-m-d H:i:sP', $measWaterCut['dbeg']);
                $dateTimeWCEnd = DateTime::createFromFormat('Y-m-d H:i:sP', $measWaterCut['dend']);
                if ($dateTimeWCBeg >= $dateTime && $dateTime >= $dateTimeWCEnd) {
                    $measWaterCutVal = $measWaterCut['water_cut'];
                    $oilVal = round(abs($measLiq['liquid'] * (1 - $measWaterCut['water_cut'] / 100) * 0.86));
                    break;
                }
            }
            foreach ($gdisCurrentValueResult as $gdisCurrentValueResultItem) {
                $dateTimeGdis = DateTime::createFromFormat('Y-m-d H:i:s',
                    $gdisCurrentValueResultItem['meas_date'] . ' 00:00:00');
                if ($dateTime == $dateTimeGdis) {
                    $gdisCurrentVal = $gdisCurrentValueResultItem['value_double'];
                    break;
                }
            }
            $result['measWaterCut']['data'][] = $measWaterCutVal;
            $result['oil']['data'][] = $oilVal;
            $result['ndin']['data'][] = $gdisCurrentVal;
        }

        return $result;
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

    public function getProductionHistory($wellId)
    {
        ini_set('max_execution_time', 600);

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

        $measWaterCuts = MeasWaterCut::where('well', $wellId)
            ->orderBy('dbeg', 'asc')
            ->get();
        $gdisCurrent = GdisCurrent::where('well', $wellId)
            ->select(['id'])
            ->get()
            ->toArray();
        $gdisCurrentValueResult = [];
        $gdisCurrent = array_map(function ($item) {
            return $item['id'];
        }, $gdisCurrent);

        $metric = Metric::where('code', 'FLVL')->first();
        $gdisCurrentValue = GdisCurrentValue::where('metric', $metric->id)
            ->whereIn('gdis_curr', $gdisCurrent)
            ->with('gdisCurrent')
            ->get();

        foreach ($gdisCurrentValue as $gdisCurrentValueItem) {
            $gdisCurrentValueResult[] = [
                'value_double' => $gdisCurrentValueItem['value_double'],
                'meas_date' => $gdisCurrentValueItem->gdisCurrent->meas_date
            ];
        }

        $result = array();
        foreach($liqByMonths as $yearNumber => $monthes) {
           foreach($monthes as $monthNumber => $month) {
              $result[$yearNumber][$monthNumber] = array();
              foreach($month as $dayNumber => $day) {
                 $date = Carbon::parse($day['dbeg']);
                 $dateEnd = Carbon::parse($day['dend']);
                 $liqCut = $measWaterCuts->filter(function ($val) use ($date) {
                    return Carbon::parse($val->dbeg)->format('d m Y') === $date->format('d m Y');
                 })->sum('water_cut');
                 $gdis = array_filter(
                     $gdisCurrentValueResult,
                     function ($val) use ($date) {
                          return Carbon::parse($val['meas_date'])->format('d m Y') === $date->format('d m Y');
                     },
                     ARRAY_FILTER_USE_KEY
                 );
                 array_push($result[$yearNumber][$monthNumber], array (
                    'liq' => $day['liquid'],
                    'date' => $date->format('Y-m-d'),
                    'liqCut' => $liqCut,
                    'workHours' => $date->diffInDays($dateEnd) * 24,
                    'oil' => round(abs($day['liquid'] * (1 - $liqCut / 100) * 0.86))
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
