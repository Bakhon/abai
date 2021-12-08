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
use App\Models\BigData\TechModeOil;
use App\Models\BigData\Well;
use App\Models\BigData\WellWorkover;
use App\Models\BigData\WellBlock;
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
        $well = Well::select(
            'id',
            'uwi',
            'drill_start_date',
            'drill_end_date',
            'whc_alt',
            'whc_h',
            'whc',
            'bottom_coord'
        )->find($well);
        if (Cache::has('well_' . $well->id)) {
            return Cache::get('well_' . $well->id);
        }

        $show_param = [];
        $category = DB::connection('tbd')->table('prod.well_category')
            ->join('dict.well_category_type', 'prod.well_category.category', '=', 'dict.well_category_type.id')
            ->where('prod.well_category.well', '=', $well->id)
            ->orderBy('dbeg', 'desc')
            ->select('dict.well_category_type.code')
            ->get();

        if ($category[0]->code == 'OIL') {
            $show_param = [
                'pump_code' => $this->wellEquipParametr($well, 'NAS'),
                'type_sk' => $this->wellEquipParametr($well, 'TSK'),
                'techModeProdOil' => $this->techModeProdOil($well),
                'dmart_daily_prod_oil' => $this->dmartDailyProd($well),
                'meas_well' => $this->measWell($well),
                'lab_research_value' => $this->labResearchValue($well), 
                'diameter_pump' => $this->wellEquipParametr($well, 'DIAN'),   
                'depthLow' => $this->pumpDepthLowing($well, [6,20,49,36,75]),
                'pump_capacity' => $this->wellEquipParams($well, '33'),   
            ];
        }
        if ($category[0]->code == 'INJ') {
            $show_param = [
                'depth_paker' => $this->wellEquipParams($well, '31'),
                'tech_mode_inj' => $this->techModeInj($well),
                'dailyInjectionOil' => $this->dailyInjectionOil($well),
                'depth_nkt' => $this->depthNkt($well),
                'diametr_stuzer' => $this->diametrStuzer($well),
            ];
        }

        $orgs = $this->org($well);
        $mainOrg = $this->orgCode($orgs);
        $wellInfo = [
            'wellInfo' => $well,
            'wellDailyDrill' => $this->wellDailyDrill($well),
            'status' => $this->status($well),
            'date_expl' => $this->date_expl($well),
            'category' => $this->category($well),
            'category_last' => $this->categoryLast($well),
            'geo' => $this->geo($well),
            'well_expl_right' => $this->wellExplOnRight($well),
            'techs' => $this->techs($well),
            'tap' => $this->tap($well),
            'tubeNom' => $this->tubeNom($well),
            'well_type' => $this->wellType($well),
            'org' => $this->structureOrg($orgs),
            'main_org_code' => $this->orgCode($orgs),
            'spatial_object' => $well->spatialObject,
            'spatial_object_bottom' => $well->spatialObjectBottom,
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
            'rzatr_stat' => $this->gdisCurrentValueRzatr($well, 'STLV'),
            'gdis_complex' => $this->gdisComplex($well, 'RP', $mainOrg),
            'gu' => $this->getTechsByCode($well, [1, 3]),
            'agms' => $this->getTechsByCode($well, [2000000000004]),
            'techmode' => $this->gdisComplex($well, 'BHP', $mainOrg),    
            'well_block' => $this->wellBlock($well),       
        ];

        $wellInfo = array_merge($wellInfo, $show_param);

     //   Cache::put('well_' . $well->id, $wellInfo, now()->addDay());
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
            ->get(['name_ru'])
            ->toArray();

        if($status){
                return $status[0];
            }

        return "";
    }

    private function tubeNom(Well $well)
    {
        $wellConstr = $well->tubeNom()
                        ->wherePivot('project_drill', '=', 'false')
                        ->wherePivot('casing_type', '=', '8', 'or')
                        ->WherePivot('casing_type', '=', '9')
                        ->get(['prod.well_constr.nd'])
                        ->toArray();

        if($wellConstr){
        return $wellConstr[0];
        }

        if(!$wellConstr){
        $wellConstrOd = DB::connection('tbd')
                        ->table('prod.well_constr')
                        ->where('well', '=', $well->id)
                        ->where('nd', '!=', null)                        
                        ->orderBy('id', 'asc')
                        ->get('nd')
                        ->toArray();   
        if($wellConstrOd){
        return $wellConstrOd[0];
        }
        return "";
        }                   
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
            ->withPivot('dend', 'dbeg')
            ->orderBy('pivot_dend')
            ->select(['name_ru'])
            ->get()
            ->toArray();

        if ($category) {
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

        if ($categoryLast) {
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

    private function depthNkt(Well $well)
    {
       $depthNkt = DB::connection('tbd')
                    ->table('prod.well_equip_param as we')
                    ->join('prod.well_equip as w', 'we.well_equip', '=', 'w.id')
                    ->join('dict.equip_param as p', 'we.equip_param', '=', 'p.id')
                    ->join('dict.equip_type as t', 'p.equip_type', '=', 't.id')
                    ->join('dict.metric as m', 'p.metric', '=', 'm.id')
                    ->where('t.code', '=', 'NKT')
                    ->where('m.code', '=', 'PAKR')
                    ->where('w.well', '=', $well->id)
                    ->orderBy('we.dbeg', 'desc')
                    ->get('we.value_double')
                    ->toArray();
       if($depthNkt){
           return $depthNkt[0];
       }             
       return "";             
    }

    private function wellEquipParams(Well $well, $method){
        $wellEquipParams = DB::connection('tbd')
                            ->table('prod.well_equip_param as we')
                            ->join('prod.well_equip as w', 'we.well_equip', '=', 'w.id')
                            ->where('w.well', '=', $well->id)
                            ->where('we.equip_param', '=', $method)
                            ->orderBy('we.dbeg', 'desc')
                            ->get(['we.value_double'])
                            ->toArray();
        if($wellEquipParams){
            return $wellEquipParams[0];
        }                    
        return "";
    }

    private function wellEquipParametr(Well $well, $code)
    {
       $wellEquipParametr = DB::connection('tbd')
                            ->table('prod.well_equip')
                            ->join('dict.equip_factory_param', 'prod.well_equip.equip', '=', 'dict.equip_factory_param.equip')
                            ->join('dict.metric', 'dict.equip_factory_param.prm', '=', 'dict.metric.id')
                            ->where('dict.metric.code', '=', $code)
                            ->where('prod.well_equip.well', '=', $well->id)
                            ->orderBy('prod.well_equip.dbeg', 'desc')
                            ->get()                           
                            ->toArray();
       if($wellEquipParametr){
           return $wellEquipParametr[0];
       }            
       return "";
    }

    private function diametrStuzer(Well $well)
    {
        $diametrstuzer = DB::connection('tbd')
                ->table('prod.well_equip as wq')
                ->join('dict.equip_factory_param as efp', 'wq.equip', '=', 'efp.equip')
                ->join('dict.equip as eq', 'efp.equip', '=', 'eq.id')
                ->join('dict.equip_type as e', 'eq.equip_type', '=', 'e.id')
                ->join('dict.metric as m', 'efp.prm', '=', 'm.id')
                ->where('m.code', '=', 'BND')
                ->where('e.code', '=', 'CHK')
                ->where('wq.well', $well->id)
                ->orderBy('wq.dbeg', 'desc')
                ->get('efp.value_double')
                ->toArray();

        if($diametrstuzer){
            return $diametrstuzer[0];
        }
        return "";
    }

    private function pumpDepthLowing(Well $well, $param)
    {
       $pumpDepth = DB::connection('tbd')
                    ->table('prod.well_equip_param')
                    ->join('prod.well_equip', 'prod.well_equip_param.well_equip', '=', 'prod.well_equip.id')                                        
                    ->whereIn('prod.well_equip_param.equip_param', $param)
                    ->where('prod.well_equip.well', '=', $well->id)
                    ->orderBy('prod.well_equip_param.dbeg', 'desc')
                    ->get()
                    ->toArray();

        if($pumpDepth){
            return $pumpDepth[0];
        }
        return "";
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

    private function wellBlock(Well $well)
    {
        $wellBlock = $well->wellBlock()
                     ->join('dict.block', 'prod.well_block.block', '=', 'dict.block.id')
                     ->orderBy('prod.well_block.dbeg')
                     ->get()
                     ->toArray();
        if($wellBlock){
            return $wellBlock[0];
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

        if ($spatialObject) {
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
        $bottomHole = BottomHole::where('well', $well->id)->where('bottom_hole_type', 1)->orderBy('depth', 'desc')->get()->toArray();
        if($bottomHole){
            return $bottomHole[0];
        }
        return "";
    }

    private function artificialBottomHole(Well $well)
    {
        $BottomHole = BottomHole::where('well', $well->id)->where('bottom_hole_type', 2)->orderBy('depth', 'desc')->get()->toArray();
        if($BottomHole){
            return $BottomHole[0];
        }
        return "";
    }

    private function dailyInjectionOil(Well $well)
    {
        $dailyInjectionOil = $well->dailyInjectionOil()
            ->where('well', '=', $well->id)
            ->orderBy('date', 'desc')
            ->get(['water_inj_val', 'pressure_inj', 'pump_stroke', 'choke', 'water_vol'])
            ->toArray();

        if ($dailyInjectionOil) {
            return $dailyInjectionOil[0];
        }
        return "";
    }

    private function pzabWell(Well $well)
    {
        $pzabWell = $well->pzabWell()
               ->orderBy('date', 'desc')
               ->get(['well', 'date', 'p_res', 'bhp'])
               ->toArray();

        if($pzabWell){
            return $pzabWell[0];
        }

        return "";
    }

    private function dmartDailyProd(Well $well)
    {
        $arr = $well->dmartDailyProd()
            ->orderBy('date', 'desc')
            ->select('oil', 'liquid', 'wcut', 'gas', 'hdin', 'date', 'pzat')
            ->get()
            ->toArray();
        if ($arr) {
            return $arr[0];
        }
        return "";
    }

    private function wellEquip(Well $well)
    {
        $wellEquip = $well->wellEquip()
            ->join('dict.equip_factory_param', 'prod.well_equip.equip', '=', 'dict.equip_factory_param.equip')
            ->join('dict.equip_type', 'prod.well_equip.equip_type', '=', 'dict.equip_type.id')
            ->where('dict.equip_type.code', '=', 'CHK')
            ->join('dict.metric', 'dict.equip_factory_param.prm', '=', 'dict.metric.id')
            ->where('dict.metric.code', '=', 'BND')
            ->get(['prm', 'value_double'])
            ->toArray();

       if($wellEquip){
           return $wellEquip[0];
       }

       return "";
    }

    private function labResearchValue(Well $well)
    {
        $lab_research_value = new LabResearchValue();
        return $lab_research_value->Rnas($well->id);
    }

    private function techModeInj(Well $well)
    {
        $techModeInj = $well->techModeInj()
            ->orderBy('dbeg', 'desc')
            ->get(['inj_pressure', 'agent_vol'])
            ->toArray();

        if($techModeInj){
            return $techModeInj[0];
        }

        return "";
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
        $measLiqInjection = $well->measLiqInjection()
            ->orderBy('dbeg', 'desc')
            ->get(['water_inj_val', 'pressure_inj'])
            ->toArray();

        if($measLiqInjection){
            return $measLiqInjection[0];
        }
        return "";
    }

    private function measWell(Well $well)
    {
        $measWell = $well->measWell()
            ->join('dict.metric', 'prod.meas_well.metric', '=', 'dict.metric.id')
            ->where('dict.metric.code', '=', 'GASR')
            ->orderBy('dbeg', 'desc')
            ->get(['value_double', 'dbeg'])
            ->toArray();

            if($measWell){
                return $measWell[0];
            }

            return "";
    }

    private function wellPerfActual(Well $well)
    {
        $wellPerfActual = $well->wellPerfActualNew()
            ->withPivot('perf_date')
            ->orderBy('pivot_perf_date', 'desc')
            ->select(['perf_date', 'top', 'base'])
            ->get()
            ->toArray();

        if ($wellPerfActual) {
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
        $wellWorkover = $well->wellWorkover()->where('repair_type', $code)->orderBy('dbeg', 'desc')->get(
            ['dbeg', 'dend'])->toArray();

        if ($wellWorkover) {
            return $wellWorkover[0];
        }
        return ['dend' => '', 'dbeg' => ''];
    }

    private function wellTreatment(Well $well)
    {
       $wellTreatment = $well->wellTreatment()
            ->where('treatment_type', '=', '14')
            ->get(['treat_date'])
            ->toArray();

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

        if ($gdisCurrent) {
            return $gdisCurrent[0];
        }

        return "";
    }

    private function wellTreatmentSko(Well $well)
    {
        $wellTreatmentSko = $well->wellTreatment()
            ->where('treatment_type', '=', '21')
            ->get(['treat_date'])
            ->toArray();

        if($wellTreatmentSko){
            return $wellTreatmentSko[0];
        }
        return "";
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
        $gdisCurrentRzatr = $well->gdisCurrentValue()
            ->join('dict.metric', 'gdis_current_value.metric', '=', 'dict.metric.id')
            ->where('dict.metric.code', '=', $method)
            ->get()
            ->toArray();

        if($gdisCurrentRzatr){
            return $gdisCurrentRzatr[0];
        }

        return "";
    }

    private function gdisComplex(Well $well, $method, $mainOrgCode)
    {
        $gdisComplex = $well->gdisComplex()
            ->join('dict.metric', 'prod.gdis_complex_value.metric', '=', 'dict.metric.id')
            ->withPivot('dbeg')
            ->where('metric.code', '=', $method)
            ->orderBy('dbeg', 'desc')
            ->get(['value_string', 'dbeg'])
            ->toArray();

        if ($gdisComplex && $method == 'BHP' && $mainOrgCode == 'KGM') {
            $gdisComplex[0]['value_string'] *= 0.987;
            return $gdisComplex[0];
        }
        if ($gdisComplex) {
            return $gdisComplex[0];
        }
        return "";
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
            ->get(['dbeg'])
            ->toArray();
        if ($gtm) {
            return $gtm[0];
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
        $result = [];
        if (Cache::has('well_' . $wellId . '_history_chart_' . $request->type . 'period_' .$period)) {
            return response()->json(Cache::get('well_' . $wellId . '_history_chart_' . $request->type . 'period_' .$period));
        }
        if ($request->type === 'Нефтяная') {
            $result = $this->wellCardGraphRepo->wellItems($wellId,$period);
        } else if ($request->type === 'Нагнетательная') {
            $result = $this->wellCardGraphRepo->getInjectionData($wellId,$period);
        }
        Cache::put('well_' . $wellId . '_history_chart_' . $request->type . 'period_' .$period, $result, now()->addDay());

        return  response()->json($result);
    }

    public function getActivityByWell(Request $request, $wellId)
    {
        $activity = [];
        $wellWorkover = WellWorkover::query()
            ->select(['dbeg', 'well', 'repair_type', 'work_plan', 'well_status'])
            ->whereIn('repair_type', [1, 3])
            ->whereYear('dbeg', $request->year)
            ->where('well', $wellId)
            ->with('repairType')
            ->get();
        $activity = array_merge($activity,$this->getFormattedWorkover($wellWorkover,'dbeg'));
        $wellWorkoverEnd = WellWorkover::query()
            ->select(['dend', 'well', 'repair_type', 'well_status', 'work_list'])
            ->whereIn('repair_type', [1, 3])
            ->whereYear('dend', $request->year)
            ->where('well', $wellId)
            ->with('repairType')
            ->get();
        $activity = array_merge($activity,$this->getFormattedWorkover($wellWorkoverEnd,'dend'));
        $gtms = Gtm::query()
            ->select(['param_result', 'gtm_type', 'dbeg'])
            ->where('well', $wellId)
            ->whereYear('dbeg', $request->year)
            ->with('GtmType')
            ->get();
        foreach ($gtms as $gtm) {
            array_push($activity,
                array(
                    'dbeg' => $gtm->dbeg,
                    'repair_type' => $gtm->GtmType[0]->name_ru,
                    'work_plan' => null,
                    'well_status' => null,
                    'work_list' => null
                )
            );
        }
        return $activity;
    }

    private function getFormattedWorkover($workovers,$dateField)
    {
        $result = [];
        foreach ($workovers as $workover) {
            array_push($result,
                array(
                    $dateField => $workover->$dateField,
                    'work_plan' => $workover->work_plan,
                    'well_status' => $workover->well_status,
                    'repair_type' => $workover->repairType->name_ru,
                    'work_list' => $workover->work_list
                )
            );
        }
        return $result;
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
