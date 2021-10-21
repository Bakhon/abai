<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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

        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

        $date = Carbon::parse($filter->date, 'Asia/Almaty')->toImmutable();
        $wellIds = $this->getOrgWells((int)$this->request->get('id'), $date);

        $bottomHoles = DB::connection('tbd')
            ->table('prod.bottom_hole')
            ->whereIn('well', $wellIds)
            ->where('data', '<=', $date->endOfDay())
            ->orderBy('data', 'desc')
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                return $items->first();
            });

        $sumbottomHoles = DB::connection('tbd')
            ->table('drill.well_daily_drill as wdd')
            ->select('wdd.daily_drill_progress')
            ->join('dict.well as w', 'wdd.well', 'w.id')
            ->whereIn('w.id', $wellIds)
            ->where('dbeg', '<=', $date->endOfDay())
            ->where('dend', '>=', $date->startOfDay())
            ->get('daily_drill_progress')
            ->sum('daily_drill_progress');
             

        $rows = DB::connection('tbd')
            ->table('drill.well_daily_drill as wdd')
            ->select(
                'wdd.id',
                'w.id as well_id',
                'w.uwi',
                'wdd.daily_drill_progress',
                'wdd.work_status',
                'wdd.work_name'
            )
            ->join('dict.well as w', 'wdd.well', 'w.id')
            ->whereIn('w.id', $wellIds)
            ->where('dbeg', '<=', $date->endOfDay())
            ->where('dend', '>=', $date->startOfDay())
            ->get()
            ->map(function ($item) use ($bottomHoles) {
                $result = [];
                foreach ($item as $key => $value) {
                    if ($key === 'id') {
                        $result[$key] = $value;
                        continue;
                    }
                    $result[$key] = ['value' => $value];
                }

                $bottomHole = $bottomHoles->get($item->well_id);
                $result['depth'] = ['value' => $sumbottomHoles ? $sumbottomHoles : ''];

                return $result;
            });

        return ['rows' => $rows];
    }

    protected function getOrgWells($orgId, CarbonImmutable $date)
    {
        $structureService = app()->make(StructureService::class);
        $techIds = $structureService->getTechIds($orgId, 'tech');
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