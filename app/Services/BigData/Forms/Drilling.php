<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class Drilling extends TableForm
{
    protected function saveSingleFieldInDB(array $params): void
    {
        $reportId = $params['wellId'];

        DB::connection('tbd')
            ->table('prod.report_org_daily_drill')
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
            ->table('prod.report_org_daily_drill as rodr')
            ->select(
                'rodr.id',
                'org.name_ru as org',
                'ww.well',
                'ww.drill',
                'ww.daily_drill_progress',
                'bh.depth',
                'dw.name_ru',
                'ww.liquid_density',
                'ww.liquid_crust',
                'ww.liquid_viscosity',
                'ww.liquid_ph',
                'ww.luquid_water_yield',
                'ww.drill_rate',
                'ww.drill_load',
                'ww.revs_per_minute',
                'ww.drill_pump_p',
                'ww.rotating_moment',
                'ww.drill_piston_d',
                'ww.kern_roofing',
                'ww.kern_sole',
                'ww.drill_chisel',
                'ww.diameter',
                'ww.value',
            )
            ->join('drill.well_daily_drill as ww', 'rodr.drill', 'ww.id')
            ->join('dict.org as org', 'rodr.org', 'org.id')
            ->join('prod.bottom_hole as bh', 'ww.well' , 'bh.well')
            ->join('dict.well_status_type as dw', 'ww.well_status_type' , 'dw.id')
            ->join('dict.drill_pump_type as dp', 'ww.drill_pump_type' , 'dp.id')
            ->join('dict.drill_chisel as dc' , 'ww.drill_chisel' , 'dc.id')
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