<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Dictionaries\Org;
use Illuminate\Support\Facades\DB;

class Drilling extends TableForm
{
    protected $configurationFileName = 'drilling';

    protected function saveSingleFieldInDB(array $params): void
    {
    }

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date)) {
            throw new \Exception(trans('bd.select_date'));
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $orgIds = $this->getOrgIds();

        $rows = DB::connection('tbd')
            ->table('prod.report_org_daily_drill as rodd')
            ->select(
                'wdd.id',
                'w.id as well_id',
                'w.uwi',
                'wdd.daily_drill_progress',
                'bh.depth',
                'wdd.well_status_type',
                'wdd.work_name'
            )
            ->join('drill.well_daily_drill as wdd', 'rodd.drill', 'wdd.id')
            ->join('prod.bottom_hole as bh', 'wdd.well', 'bh.well')
            ->join('dict.well as w', 'wdd.well', 'w.id')
            ->whereIn('rodd.org', $orgIds)
            ->where('rodd.report_date', $filter->date)
            ->get()
            ->map(function ($item) {
                $result = [];
                foreach ($item as $key => $value) {
                    if ($key === 'id') {
                        $result[$key] = $value;
                        continue;
                    }
                    $result[$key] = ['value' => $value];
                }
                return $result;
            });

        return ['rows' => $rows];
    }

    private function getOrgIds()
    {
        $org = Org::find($this->request->get('id'));
        return array_merge([$org->id], $org->children->pluck('id')->toArray());
    }
}