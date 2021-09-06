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

    protected function saveSingleFieldInDB(array $params): void
    {
        $reportId = $params['wellId'];

        DB::connection('tbd')
            ->table('prod.report_org_daily_repair')
            ->where('id', $reportId)
            ->update(
                [
                    $params['field'] => $params['value']
                ]
            );
    }


    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date)) {
            return ['rows' => []];
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $rows = DB::connection('tbd')
            ->table('prod.report_org_daily_repair as rodr')
            ->select(
                'rodr.id',
                'org.name_ru as org',
                'ww.well',
                'ww.contractor',
                'ww.repair_work_type',
                'rodr.machine_type',
                'rodr.work_done'
            )
            ->join('prod.well_workover as ww', 'rodr.workover', 'ww.id')
            ->join('dict.org as org', 'rodr.org', 'org.id')
            ->where('rodr.org', $this->request->get('id'))
            ->where('rodr.report_date', $filter->date)
            ->get()
            ->map(function ($item) {
                $result = [];
                foreach ($item as $key => $value) {
                    if ($key === 'id') {
                        $result[$key] = $value;
                        continue;
                    }
                    $result[$key] = [
                        'value' => $value
                    ];
                }
                $result['geo'] = [
                    'value' => 12
                ];
                return $result;
            });

        return ['rows' => $rows];
    }   

    
    
}