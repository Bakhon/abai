<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Services\BigData\StructureService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class DailyReportsPrs extends TableForm
{
    protected $configurationFileName = 'daily_reports_prs';
    protected $repairType = 'WLO';

    public function submitForm(array $rows, array $filter = []): array
    {
        foreach ($rows as $workoverId => $row) {
            $report = DB::connection('tbd')
                ->table('prod.report_org_daily_repair')
                ->where('workover', $workoverId)
                ->first();

            $fields = [];
            foreach ($row as $fieldCode => $field) {
                $fields[$fieldCode] = $field['value'];
            }

            if (empty($report)) {
                DB::connection('tbd')
                    ->table('prod.report_org_daily_repair')
                    ->insert(
                        array_merge(
                            [
                                'workover' => $workoverId
                            ],
                            $fields
                        )
                    );
                continue;
            }

            DB::connection('tbd')
                ->table('prod.report_org_daily_repair')
                ->where('id', $report->id)
                ->update($fields);
        }
        return [];
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date)) {
            return ['rows' => []];
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, []);

        $rows = DB::connection('tbd')
            ->table('prod.well_workover as ww')
            ->select(
                'ww.id',
                'ww.well',
                'ww.contractor',
                'ww.repair_work_type',
                'rodr.machine_type',
                'rodr.work_done',
                'rodr.comment',
                't.name_ru as tech',
            )
            ->leftJoin('dict.well_repair_type as wrt', 'ww.repair_type', 'wrt.id')
            ->join('dict.well as w', 'ww.well', 'w.id')
            ->leftJoin('prod.report_org_daily_repair as rodr', 'ww.id', 'rodr.workover')
            ->leftJoin('prod.well_tech as wt', 'w.id', 'wt.well')
            ->leftJoin('dict.tech as t', 'wt.tech', 't.id')
            ->whereIn('w.id', $wells->pluck('id')->toArray())
            ->where('ww.dbeg', '<=', $filter->date)
            ->where(function ($query) use ($filter) {
                $query->where('ww.dend', '>=', $filter->date)
                    ->orWhereNull('ww.dend');
            })
            ->where('wrt.code', $this->repairType)
            ->where('wt.dbeg', '<=', $filter->date)
            ->where('wt.dend', '>', $filter->date)
            ->get()
            ->map(function ($item) {
                $result = [];
                foreach ($item as $key => $value) {
                    if (in_array($key, ['geo_id'])) {
                        continue;
                    }
                    if ($key === 'id') {
                        $result[$key] = $value;
                        continue;
                    }
                    $result[$key] = [
                        'value' => $value
                    ];
                }

                return $result;
            });

        return ['rows' => $rows];
    }

    private function getHorizon($geoId)
    {
        $geo = DB::connection('tbd')
            ->table('dict.geo as g')
            ->select('g.id', 'gt.code', 'gp.parent')
            ->join('dict.geo_type as gt', 'g.geo_type', 'gt.id')
            ->join('dict.geo_parent as gp', 'g.id', 'gp.geo')
            ->where('g.id', $geoId)
            ->first();

        if ($geo->code === 'HRZ') {
            return $geo->id;
        }

        return $this->getHorizon($geo->parent);
    }

    protected function getOrgWells(Org $org, CarbonImmutable $date)
    {
        $structureService = app()->make(StructureService::class);
        $techIds = $structureService->getTechIds($org->id, 'org');
        return DB::connection('tbd')
            ->table('prod.well_tech')
            ->select('well')
            ->whereIn('tech', $techIds)
            ->where('dbeg', '<=', $date)
            ->where('dend', '>=', $date)
            ->get()
            ->pluck('well')
            ->toArray();
    }

}
