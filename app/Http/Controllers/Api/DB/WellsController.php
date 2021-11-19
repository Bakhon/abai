<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\BigData\WellSearchResource;
use App\Models\BigData\BottomHole;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Gtm;
use App\Models\BigData\LabResearchValue;
use App\Models\BigData\MeasLiq;
use App\Models\BigData\MeasWaterCut;
use App\Models\BigData\MeasLiqInjection;
use App\Models\BigData\MeasWell;
use App\Models\BigData\PzabTechMode;
use App\Models\BigData\DmartDailyProd;
use App\Models\BigData\WellDailyDrill;
use App\Models\BigData\Well; 
use App\Models\BigData\WellEquipParam;
use App\Models\BigData\WellEquip;
use App\Models\BigData\WellWorkover;
use App\Models\BigData\TechModeOil;
use App\Models\BigData\WellStatus;
use App\Repositories\WellCardGraphRepository;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WellsController extends Controller
{

    private $wellCardGraphRepo;

    public function __construct(WellCardGraphRepository $wellCardGraphRepo)
    {
        $this->wellCardGraphRepo = $wellCardGraphRepo;        
    }

    public function getStructureTree(StructureService $service, Request $request)
    {
        return $service->getTreeWithPermissions();
    }

    public function wellInfo($well)
    {
    
        $well = Well::select('id','uwi', 'drill_start_date', 'drill_end_date', 'whc_alt', 'whc_h')->find($well);
        if (Cache::has('well_' . $well->id)) {
            return Cache::get('well_' . $well->id);
        }     
          
              
        $show_param = [];
        $category = DB::connection('tbd')->table('prod.well_category')
                   ->join('dict.well_category_type', 'prod.well_category.category', '=', 'dict.well_category_type.id')
                   ->where('prod.well_category.well', '=', $well->id)
                   ->orderBy('dbeg', 'desc')
                   ->select('dict.well_category_type.code')                    
                   ->take(1)                
                   ->get();
                            
        if($category[0]->code == 'OIL')  
        {            
            $show_param = [                
                'pump_code' => $this->wellEquipParam($well, 'NAS'),   
                'type_sk' => $this->wellEquipParam($well, 'TSK'),  
                'well_equip_param' => $this->wellEquipParam($well, 'PSD'),
                'techModeProdOil' => $this->techModeProdOil($well),  
                'dmart_daily_prod_oil' => $this->dmartDailyProd($well),              
                'meas_well' => $this->measWell($well),
                'lab_research_value' => $this->labResearchValue($well),
                'measLiq' => $this->measLiq($well), 
                'dinzamer' => $this->gdisCurrentValueRzatr($well, 'FLVL'),   
            ];           
        }
        if($category[0]->code == 'INJ') 
        {
            $show_param = [
                'diametrStuzer' => $this->wellEquip($well),
                'depth_nkt' => $this->wellEquipParam($well, 'PAKR'),                
                'tech_mode_inj' => $this->techModeInj($well),
                'meas_water_inj' => $this->measLiqInjection($well),
            ];  
        }   
               
        $orgs = $this->org($well);                  
        $wellInfo = [
            'wellInfo' => $well,
            'wellDailyDrill' => $this->wellDailyDrill($well), 
            'status' => $this->status($well),  //
            'date_expl' => $this->date_expl($well),
            'category' => $this->category($well),
            'category_last' => $this->categoryLast($well),
            'geo' => $this->geo($well),   //          
            'well_expl_right' => $this->wellExplOnRight($well), 
            'techs' => $this->techs($well),
            'tap' => $this->tap($well),
            'tubeNom' => $this->tubeNom($well),
            'well_type' => $this->wellType($well),
            'org' => $this->structureOrg($orgs),
            'main_org_code'=>$this->orgCode($orgs),
            'spatial_object' => $this->spatialObject($well),
            'spatial_object_bottom' => $this->spatialObjectBottom($well),
            'actual_bottom_hole' => $this->actualBottomHole($well),            
            'artificial_bottom_hole' => $this->artificialBottomHole($well),
            'well_perf_actual' => $this->wellPerfActual($well),                                                                                  
            'krs_well_workover' => $this->getKrsPrs($well, 1),
            'prs_well_workover' => $this->getKrsPrs($well, 3),
            'well_treatment' => $this->wellTreatment($well),
            'well_treatment_sko' => $this->wellTreatmentSko($well),
            'gis' => $this->gis($well),
            'zone' => $this->zone($well),
            'well_react_infl' => $this->wellReact($well),
            'gtm' => $this->gtm($well),                 
            'gdisCurrent' => $this->gdisCurrent($well),               
            'rzatr_atm' => $this->gdisCurrentValueOtp($well),                                                                                                          
            'rzatr_stat' => $this->gdisCurrentValueRzatr($well, 'STLV'),
            'gdis_complex' => $this->gdisComplex($well),          
            'gu' => $this->getTechsByCode($well, [1, 3]),
            'agms' => $this->getTechsByCode($well, [2000000000004]),            
            'techmode' => $this->pzabWell($well), 
            'diametr_pump' => $this->wellEquipParam($well, 'DIAN'),                     
        ];

        $wellInfo = array_merge($wellInfo, $show_param);
      
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
        if (isset($item)) {
            $geo_tree = $geo_object->parentTree($item->id);
            $not_duplicate = [];
            $count_tree = count($geo_tree) - 1;
            foreach ($geo_tree as $key => $geo_item) {
                if (!in_array($geo_item->geo, $not_duplicate)) {
                    $parents_id[] = $geo_item->geo;
                    $not_duplicate[] = $geo_item->geo;
                }
                if ($key == $count_tree) {
                    $parents_id[] = $geo_item->parent;
                }
            }

            if (isset($parents_id)) {
                $items = $geo_object->getItems($parents_id);
                foreach ($items as $item) {
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
            ->get(['prod.well_constr.od']);
    }

    private function date_expl(Well $well)
    {
        $date_expl = $well->wellExplDate()   
                    ->where('status', '=', '3')
                    ->orderBy('dbeg', 'asc')                                 
                    ->select(['dbeg'])
                    ->get()
                    ->toArray();

        if($date_expl){
            return $date_expl[0];
        }

        return "";
    }


    private function category(Well $well)
    {
        $category = $well->category()
            ->wherePivot('dend', '>', $this->getToday())
            ->wherePivot('dbeg', '<=', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg')
            ->select(['name_ru'])
            ->get()
            ->toArray();

        if($category){
            return $category[0];
        }    
        
        return "";
    }

    private function categoryLast(Well $well)
    {
        $categoryLast = $well->category()
            ->wherePivot('dend', '>', $this->getToday())
            ->wherePivot('dbeg', '<=', $this->getToday())
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dbeg', 'desc')
            ->select(['name_ru',])
            ->get()
            ->toArray();
         
        if($categoryLast){
            return $categoryLast[0];
        }    
        
        return "";
    }

    private function wellExpl(Well $well)
    {
        return $well->wellExpl()
            ->withPivot('dend as dend', 'dbeg as dbeg')
            ->orderBy('dbeg', 'asc')
            ->first(['name_ru', 'dend', 'dbeg']);
    }

    private function wellEquipParam(Well $well, $method)
    {
        return $well->wellEquipParam()->join('dict.equip_param', 'prod.well_equip_param.equip_param', '=', 'dict.equip_param.id')
               ->join('dict.metric', 'dict.equip_param.metric', '=', 'dict.metric.id')
               ->withPivot('dbeg')
               ->where('metric.code', '=', $method) 
               ->orderBy('pivot_dbeg', 'desc')          
               ->first(['value_double', 'value_string', 'equip_param']);                          
    } 

    private function wellExplOnRight(Well $well)
    {
        $wellExpl = $well->wellExpl()
                ->withPivot('dend as dend', 'dbeg as dbeg')
                ->orderBy('dbeg', 'desc')
                ->select(['name_ru', 'dend', 'dbeg'])
                ->get()
                ->toArray();

        if($wellExpl){
            return $wellExpl[0];
        }        

        return "";

    }

    private function techs(Well $well)
    {
        $tech = new Tech();
        $allParents = [];
        $item = $well->getRelationTech($this->getToday());
        if ($item) {
            $dict_techs = $tech->parentTree($item->id);
            foreach ($dict_techs as $dict_tech) {
                $allParents[]['name_ru'] = $dict_tech->name;
            }
            if (!empty($allParents)) {
                $allParents = array_reverse($allParents);
            }
        }
        return $allParents;
    }

    private function tap(Well $well)
    {
        $tap = $well->techs()
            ->wherePivot('dend', '>', $this->getToday())
            ->withPivot('dend', 'dbeg', 'tap as tap')
            ->orderBy('pivot_dbeg', 'desc')
            ->select(['tap'])
            ->get()
            ->toArray();
        
        if($tap){
            return $tap[0];
        }        
        return "";
    }

    private function wellType(Well $well)
    {
        $wellType = $well->wellType()
            ->select(['name_ru'])
            ->get()
            ->toArray();

        if($wellType){
            return $wellType[0];
        }  

        return "";
    }

    private function org(Well $well)
    {
        $dict_orgs = [];
        $org_object = new Org();
        $item = $well->getRelationOrg($this->getToday());
        if (isset($item)) {
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
        $spatialObject = $well->spatialObject()
            ->where('spatial_object_type', '=', '1')
            ->select(['coord_point'])
            ->get()
            ->toArray();

        if($spatialObject){
            return $spatialObject[0];
        }    
        
        return "";
    }

    private function spatialObjectBottom(Well $well)
    {
        $spatialObjectBottom = $well->spatialObjectBottom()
            ->where('spatial_object_type', '=', '1')
            ->select(['coord_point'])
            ->get()
            ->toArray();
        
        if($spatialObjectBottom){
            return $spatialObjectBottom[0];
        }

        return "";
    }

    private function actualBottomHole(Well $well)
    {      
        return BottomHole::where('well', $well->id)->where('bottom_hole_type', 1)->orderBy('depth', 'desc')->first();
    }

    private function artificialBottomHole(Well $well)
    {       
        return BottomHole::where('well', $well->id)->where('bottom_hole_type', 2)->orderBy('depth', 'desc')->first();
    }

    private function pzabWell(Well $well)
    {
        return $well->pzabWell()
               ->orderBy('date', 'desc')
               ->first(['well', 'date', 'p_res', 'bhp']); 
    }

    private function dmartDailyProd(Well $well)
    {
       $arr = $well->dmartDailyProd()
            ->orderBy('date', 'desc')
            ->select('oil', 'liquid', 'wcut', 'gas', 'hdin', 'date')
            ->get()
            ->toArray();
        if($arr){
            return $arr[0]; 
        }     
        return "";                          
    }

    private function wellEquip(Well $well)
    {
       return $well->wellEquip()             
             ->join('dict.equip_factory_param', 'prod.well_equip.equip', '=', 'dict.equip_factory_param.equip')
             ->join('dict.equip_type', 'prod.well_equip.equip_type', '=', 'dict.equip_type.id')
             ->where('dict.equip_type.code', '=', 'CHK')
             ->join('dict.metric', 'dict.equip_factory_param.prm', '=', 'dict.metric.id')
             ->where('dict.metric.code', '=', 'BND')
             ->first(['prm', 'value_double']); 
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
        $techmode = $well->techModeProdOil()
            ->orderBy('dbeg', 'desc')
            ->select(['oil', 'liquid', 'wcut', 'oil_density'])
            ->get()
            ->toArray();
         if($techmode){
            return $techmode[0]; 
         }
         return ""; 
    }

    private function measLiq(Well $well)
    {
        return $well->measLiq()
            ->orderBy('dbeg', 'desc')
            ->first('liquid');
    }

    private function measLiqInjection(Well $well)
    {
        return $well->measLiqInjection()
            ->orderBy('dbeg', 'desc')
            ->first(['water_inj_val', 'pressure_inj']); 
    }

    private function measWell(Well $well)
    {
        return $well->measWell()
            ->join('dict.metric', 'prod.meas_well.metric', '=', 'dict.metric.id')
            ->where('dict.metric.code', '=', 'GASR')
            ->orderBy('dbeg', 'desc')
            ->first(['value_double', 'dbeg']);
    }
    
    private function wellPerfActual(Well $well)
    {
        $wellPerfActual = $well->wellPerfActualNew()             
                        ->withPivot('perf_date')            
                        ->orderBy('pivot_perf_date', 'desc')
                        ->select(['perf_date', 'top', 'base'])
                        ->get()
                        ->toArray();
        
        if($wellPerfActual){
            return $wellPerfActual[0];
        }

        return "";
    }

    private function measWaterCut(Well $well)
    {
        return $well->measWaterCut()
            ->orderBy('dbeg', 'desc')
            ->first(['water_cut']);
    }

    private function getKrsPrs(Well $well, $code)
    {
        $wellWorkover = $well->wellWorkover()->where('repair_type', $code)->orderBy('dbeg', 'desc')->first(
            ['dbeg', 'dend']);

        if (isset($wellWorkover)) {
            return $wellWorkover;
        }
        return ['dend' => '', 'dbeg' => ''];
    }

    private function wellTreatment(Well $well)
    {
       $wellTreatment = $well->wellTreatment()
            ->where('treatment_type', '=', '14')
            ->first(['treat_date']);
        if($wellTreatment){
            return $wellTreatment[0];
        }
        return "";
    }

    private function gdisCurrent(Well $well)
    {
        $gdisCurrent = $well->gdisCurrent()
            ->orderBy('meas_date', 'desc')
            ->select(['meas_date', 'note'])
            ->get()
            ->toArray();

        if($gdisCurrent){
            return $gdisCurrent[0];
        }  

        return "";
    }

    private function wellTreatmentSko(Well $well)
    {
        return $well->wellTreatment()
            ->where('treatment_type', '=', '21')
            ->first(['treat_date']);
    }

    private function wellDailyDrill(Well $well)
    {                     
        $wellDailyDrill = $well->wellDailyDrill()
              ->select(['dbeg', 'dend'])
              ->get()
              ->toArray();

        if($wellDailyDrill){
            return $wellDailyDrill[0];
        }       

        return "";
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

    private function gdisCurrentValueOtp(Well $well)
    {    
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'prod.gdis_current_value.metric', '=', 'dict.metric.id')
            ->withPivot('meas_date')
            ->where('metric.code', '=', 'OTP')
            ->orderBy('pivot_meas_date', 'desc')
            ->first(['value_double', 'meas_date']); 
    }

    private function gdisCurrentValueRzatr(Well $well, $method)
    {
        return $well->gdisCurrentValue()
            ->join('dict.metric', 'gdis_current_value.metric', '=', 'dict.metric.id')                      
            ->where('dict.metric.code', '=', $method)
            ->get()
            ->last(); 
    }
  
    private function gdisComplex(Well $well)
    {
        return $well->gdisComplex()
            ->join('dict.metric', 'prod.gdis_complex_value.metric', '=', 'dict.metric.id')
            ->withPivot('dbeg')
            ->where('metric.code', '=', 'PVOP')
            ->orderBy('dbeg', 'desc')
            ->first(['value_string', 'dbeg']);     
    }

    private function gis(Well $well)
    {
        $gis = $well->gis()
            ->where('gis_type', '=', '1')
            ->orderBy('gis_date', 'desc')
            ->get(['gis_date'])
            ->toArray();

        if($gis){
            return $gis[0];
        }    
        return "";
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
        if (empty($request->get('query')) || strlen($request->get('query')) < 2) {
            return [];
        }
        $selectedUserDzo = $request->get('selectedUserDzo');
        $childrenIds = [];
        $orgsTree = $service->getTree(Carbon::now());
        if ($selectedUserDzo) {
            $childrenIds = $service::getChildIds($orgsTree, $selectedUserDzo);
        }

        $wellQuery = Well::query()
            ->whereRaw("LOWER(uwi) LIKE '%" . strtolower($request->get('query')) . "%'")
            ->with('orgs');
        if ($childrenIds) {
            $wellQuery->whereHas(
                'orgs',
                function ($query) use ($childrenIds) {
                    $query->whereIn('org.id', $childrenIds);
                }
            );
        }
        $wells = $wellQuery->limit(50)->get();

        $orgsToFilter = [];
        $userDzoIds = array_map(function ($item) {
            return substr($item, strpos($item, ":") + 1);
        }, auth()->user()->org_structure);
        foreach ($userDzoIds as $userDzoId) {
            $orgsToFilter = array_merge($orgsToFilter, $service::getChildIds($orgsTree, $userDzoId));
        }
        if (!empty($orgsToFilter)) {
            $wells = $wells->filter(function ($well) use ($orgsToFilter) {
                $wellOrgs = $well->orgs->pluck('id')->toArray();
                return !empty(array_intersect($wellOrgs, $orgsToFilter));
            });
        }

        return [
            'items' => WellSearchResource::collection($wells)
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProductionWellsScheduleData(Request $request): object
    {
        $wellId = $request->get('wellId');
        $period = $request->get('period');
        $result = $this->wellCardGraphRepo->wellItems($wellId,$period);
        return  response()->json($result);
    }

    public function getInjectionHistory($wellId)
    {
        $measLiqs = MeasLiq::where('well', $wellId)
            ->orderBy('dbeg', 'asc')
            ->get();
        $groupedLiq = $measLiqs->groupBy(function ($val) {
            return Carbon::parse($val->dbeg)->format('Y');
        });
        $liqByMonths = array();
        foreach ($groupedLiq as $yearNumber => $value) {
            $liqByMonths[$yearNumber] = $value->groupBy(function ($val) {
                return Carbon::parse($val->dbeg)->format('m');
            });
        }

        $result = array();
        foreach ($liqByMonths as $yearNumber => $monthes) {
            foreach ($monthes as $monthNumber => $month) {
                $result[$yearNumber][$monthNumber] = array();
                foreach ($month as $dayNumber => $day) {
                    $date = Carbon::parse($day['dbeg']);
                    $dateEnd = Carbon::parse($day['dend']);

                    array_push($result[$yearNumber][$monthNumber], array(
                        'liq' => $day['liquid'],
                        'date' => $date->format('Y-m-d'),
                        'workHours' => $date->diffInDays($dateEnd),
                    ));
                }
            }
        }
        return $result;
    }

    public function getActivityByWell(Request $request, $wellId)
    {
        $wellWorkover = WellWorkover::query()
            ->select(['dbeg', 'well', 'repair_type', 'work_plan', 'well_status'])
            ->whereIn('repair_type', [1, 3])
            ->whereYear('dbeg', $request->year)
            ->whereMonth('dbeg', $request->month)
            ->where('well', $wellId)
            ->get();
        $wellWorkoverEnd = WellWorkover::query()
            ->select(['dend', 'well', 'repair_type', 'well_status', 'work_list'])
            ->whereIn('repair_type', [1, 3])
            ->whereYear('dend', $request->year)
            ->whereMonth('dend', $request->month)
            ->where('well', $wellId)
            ->get();
        foreach ($wellWorkoverEnd as $workEnd) {
            $wellWorkover->push($workEnd);
        }
        $gtms = Gtm::query()
            ->select(['param_result', 'gtm_type', 'dbeg'])
            ->where('well', $wellId)
            ->whereYear('dbeg', $request->year)
            ->whereMonth('dbeg', $request->month)
            ->get();
        foreach ($gtms as $gtm) {
            $wellWorkover->push(
                array(
                    'dbeg' => $gtm->dbeg,
                    'repair_type' => $gtm->gtm_type->name_ru
                )
            );
        }
        return $wellWorkover;
    }

    public function getProductionTechModeOil(Request $request, $wellId)
    {
        $minYear = min($request->year);
        $maxYear = max($request->year);
        return TechModeOil::query()
            ->select()
            ->whereYear('dbeg', '>=', $minYear)
            ->whereYear('dbeg', '<=', $maxYear)
            ->where('well', $wellId)
            ->get()
            ->toArray();
    }
}
