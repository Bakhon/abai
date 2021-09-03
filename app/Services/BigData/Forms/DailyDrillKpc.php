<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use App\Models\BigData\Dictionaries\Org;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Services\BigData\DictionaryService;
use Illuminate\Support\Collection;

class DailyDrillKpc extends TableForm
{   
    
    protected $configurationFileName = 'daily_drill_kpc';

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $kpc = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'CWO')
            ->first();

        $data['repair_type'] = $kpc->id;
        return $data;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        list($machine_type, $work_done) = explode('_', $params['field']);
        $result = [
                    'id' => $this->request->get('id')
                ];
                $filter = json_decode($this->request->get('filter'));
                if ($this->request->get('id')) {
                    $org = Org::find($this->request->get('id'));
                    if (!$org) {
                         ['rows' => []];
                    }
                    $result['org'] = ['value' => $org->name_ru];
                }
                $company = DB::connection('tbd')
                ->table('prod.well_workover as pw')
                ->select('pw.contractor')
                ->leftJoin('prod.report_org_daily_repair as pp', 'pw.id', 'pp.workover')
                ->leftJoin('dict.company as dc', 'pw.contractor', 'dc.id')           
                ->first();
               
            $well = DB::connection('tbd')
            ->table('prod.well_workover as pw')
            ->select('dw.uwi')
            ->leftJoin('dict.well as dw', 'pw.well', 'dw.id')           
            ->first();
            $result['well'] = ['value' => $well->uwi]; 
            
            $geo = DB::connection('tbd')
            ->table('prod.well_workover as pw')
            ->select('g.name_ru')
            ->leftJoin('prod.well_geo as pg', 'pw.well', 'pg.well')   
            ->leftJoin('dict.geo as g', 'pg.geo', 'g.id')                   
            ->first();
            $result['geo'] = ['value' => $geo->name_ru]; 
    
            $repair_work_type = DB::connection('tbd')
            ->table('prod.well_workover as pw')
            ->select('pw.repair_work_type')
            ->leftJoin('dict.repair_work_type as dw', 'pw.repair_work_type', 'dw.id')           
            ->first();
            $result['repair_work_type'] = ['value' => $repair_work_type->repair_work_type]; 
        
            DB::connection('tbd')
                ->table('prod.well_workover')
                ->insert(
                    [
                        'org' => $org,
                        'contractor' => $company,
                        'well' => $well,
                        'geo' => $geo,
                        'repair_work_type' => $repair_work_type
                    ]
                );
        
    }
   

    
    public function getRows(array $params = []): array
    {
        // return ['rows' => [
        //     [
        //         'org' => '123',
        //         'well' => 'well',
        //         'org_ch' => 'org',
        //     ],
        //     [
        //         'org' => '123',
        //         'well' => 'well',
        //         'org_ch' => 'org',
        //     ],
        //     [
        //         'org' => '123',
        //         'well' => 'well',
        //         'org_ch' => 'org',
        //     ]
        // ]];
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date)) {
            return ['rows' => []];
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $org = Org::find($this->request->get('id'));
        $contractor = DB::connection('tbd')
            ->table('prod.report_org_daily_repair as pp')
            ->select('pw.contractor')
            ->leftJoin('prod.well_workover as pw', 'pw.id', 'pp.workover')
            ->leftJoin('dict.company as dc', 'pw.contractor', 'dc.id')    
            ->where('pp.org','=', $org->id)     
            ->get();
            $result['contractor'] = ['value' => $contractor];
        $orgChildren = $org->children()->get();
        $wells = $org->wells()->get();
        $result['org'] = ['value' => $org->name_ru];  
        $result['well'] = ['value' => $wells->keyBy('uwi')]; 
        $result['org_ch'] = ['value' => $orgChildren];      
        
        // $company = DB::connection('tbd')
        //     ->table('prod.well_workover as pw')
        //     ->select('pw.contractor')
        //     ->leftJoin('prod.report_org_daily_repair as pp', 'pw.id', 'pp.workover')
        //     ->leftJoin('dict.company as dc', 'pw.contractor', 'dc.id')     
        //     ->first();
        //     $result['contractor'] = ['value' => $company->contractor];
          
        $well = DB::connection('tbd')
        ->table('prod.report_org_daily_repair as pp')
            ->select('pw.well')
            ->leftJoin('prod.well_workover as pw', 'pw.id', 'pp.workover')
            ->leftJoin('dict.well as dc', 'pw.well', 'dc.id')    
            ->where('pp.org','=', $org->id)     
            ->get();
        // $result['well'] = ['value' => $well->keyBy('uwi')]; 
        $geo0 = DB::connection('tbd')
        ->table('prod.report_org_daily_repair as pp')
            ->select('dc.geo')
            ->leftJoin('prod.well_workover as pw', 'pw.id', 'pp.workover')
            ->leftJoin('prod.well_geo as pg', 'pw.well', 'pg.well') 
            ->leftJoin('dict.geo as g', 'pg.geo', 'g.id')      
            ->where('pp.org','=', $org->id)     
            ->get();
        
        $geo = DB::connection('tbd')
        ->table('prod.well_workover as pw')
        ->select('g.name_ru')
        ->leftJoin('prod.well_geo as pg', 'pw.well', 'pg.well')   
        ->leftJoin('dict.geo as g', 'pg.geo', 'g.id')                   
        ->first();
        $result['geo'] = ['value' => $geo->name_ru]; 
        $repair_work_type0 = DB::connection('tbd')
        ->table('prod.report_org_daily_repair as pp')
            ->select('pw.repair_work_type')
            ->leftJoin('prod.well_workover as pw', 'pw.id', 'pp.workover')
            ->leftJoin('dict.repair_work_type', 'pw.repair_work_type', 'dw.id')      
            ->where('pp.org','=', $org->id)     
            ->get();
        $repair_work_type = DB::connection('tbd')
        ->table('prod.well_workover as pw')
        ->select('pw.repair_work_type')
        ->leftJoin('dict.repair_work_type as dw', 'pw.repair_work_type', 'dw.id')  
        ->leftJoin('prod.report_org_daily_repair as pr', 'pw.id' , 'pr.workover')           
        ->first();
        $result['repair_work_type'] = ['value' => $repair_work_type->repair_work_type]; 
        $machine_type = DB::connection('tbd')
        ->table('prod.well_workover as pw')
        ->select('pr.machine_type')
        ->leftJoin('prod.report_org_daily_repair as pr', 'pw.id' , 'pr.workover')
        ->leftJoin('dict.machine_type as dw', 'pr.machine_type', 'dw.id')           
        ->first();
        $result['machine_type'] = ['value' => $machine_type->machine_type];
        $work_done = DB::connection('tbd')
        ->table('prod.well_workover as pw')
        ->select('pr.work_done')
        ->leftJoin('prod.report_org_daily_repair as pr', 'pw.id' , 'pr.workover')          
        ->first();
        $result['work_done'] = ['value' => $work_done->work_done];
        return ['rows' => [$result]];
    }   
}