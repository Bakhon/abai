<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\BigData\StructureService;
use Illuminate\Support\Facades\DB;

class DailyReportsPrs extends TableForm
{
    protected $configurationFileName = 'daily_reports_prs';
    protected $repairType = 'WLO';

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


    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date)) {
            return ['rows' => []];
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $orgIds = $this->getOrgIds((int)$this->request->get('id'));

        $rows = DB::connection('tbd')
            ->table('prod.report_org_daily_repair as rodr')
            ->select(
                'rodr.id',
                'org.name_ru as org',
                'ww.well',
                'ww.contractor',
                'ww.repair_work_type',
                'rodr.machine_type',
                'rodr.work_done',
                'wg.geo as geo_id'
            )
            ->join('prod.well_workover as ww', 'rodr.workover', 'ww.id')
            ->join('dict.well_repair_type as wrt', 'ww.repair_type', 'wrt.id')
            ->join('dict.org as org', 'rodr.org', 'org.id')
            ->join('prod.well_geo as wg', 'ww.well', 'wg.well')
            ->whereIn('rodr.org', $orgIds)
            ->where('rodr.report_date', $filter->date)
            ->where('wrt.code', $this->repairType)
            ->where('wg.dbeg', '<=', $filter->date)
            ->where('wg.dend', '>=', $filter->date)
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

                $result['geo'] = [
                    'value' => $this->getHorizon($item->geo_id)
                ];

                return $result;
            });

        return ['rows' => $rows];
    }

    private function getOrgIds(int $orgId)
    {
        $structureService = app()->make(StructureService::class);
        $orgStructure = $structureService->getFlattenTreeWithPermissions();
        $org = array_filter($orgStructure, function ($item) use ($orgId) {
            return $item['type'] === 'org' && $item['id'] === $orgId;
        });
        $org = reset($org);
        return $this->getOrgWithChildren($orgStructure, $org['id']);
    }

    private function getOrgWithChildren(array $orgStructure, $orgId)
    {
        $ids = [$orgId];
        $children = array_filter($orgStructure, function ($item) use ($orgId) {
            return $item['type'] === 'org' && $item['parent_id'] === $orgId;
        });
        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getOrgWithChildren($orgStructure, $child['id']));
        }
        return $ids;
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

}
