<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Dictionaries\Org;
use Illuminate\Support\Facades\DB;

class DailyReportsPrs extends TableForm
{
    protected $configurationFileName = 'daily_reports_prs';

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $prs = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'CWO')
            ->first();

        $data['repair_type'] = $prs->id;
        return $data;
    }

    
    protected function saveSingleFieldInDB(array $params): void
    {
        list($company, $machine_type, $well , $geo , $repair_work_type , $work_done) = explode('_', $params['field']);
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
                $result['contractor'] = ['value' => $company->contractor];
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
        $result = [
            'id' => $this->request->get('id')
        ];
        $filter = json_decode($this->request->get('filter'));
        if ($this->request->get('id')) {
            $org = Org::find($this->request->get('id'));
            if (!$org) {
                return ['rows' => []];
            }
            $result['org'] = ['value' => $org->name_ru];
        }
        $filter->optionId = $filter->optionId ?? 0;
        $company = DB::connection('tbd')
            ->table('prod.well_workover as pw')
            ->select('pw.contractor')
            ->leftJoin('prod.report_org_daily_repair as pp', 'pw.id', 'pp.workover')
            ->leftJoin('dict.company as dc', 'pw.contractor', 'dc.id')           
            ->first();
            $result['contractor'] = ['value' => $company->contractor];
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
        return ['rows' => [$result]];
    }   
   
}
