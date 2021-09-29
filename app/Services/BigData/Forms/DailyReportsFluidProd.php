<?php

namespace App\Services\BigData\Forms;


use App\Models\BigData\Dictionaries\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsFluidProd extends DailyReports
{
    protected $metricCode = 'FLR';
    protected $planField = 'liquid_production';

    protected function getData(Org $org, \stdClass $filter): array
    {
        $reports = $this->getReports($filter);

        $date = Carbon::parse($filter->date)->toImmutable();

        $plans = DB::connection('tbd')
            ->table('prod.production_plan')
            ->where('org', $org->id)
            ->whereRaw(
                "TO_DATE(CONCAT(year,'-',month,'-','01'), 'YYYY-MM-DD') >= TO_DATE('" . $date->startOfYear()->format(
                    'Y-m-d'
                ) . "', 'YYYY-MM-DD')"
            )
            ->whereRaw(
                "TO_DATE(CONCAT(year,'-',month,'-','01'), 'YYYY-MM-DD') <= TO_DATE('" . $date->format(
                    'Y-m-d'
                ) . "', 'YYYY-MM-DD')"
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyPlanRow = $plans->where('month', $date->month)->first();

        $planFromStartOfMonth = $planFromStartOfYear = $dailyPlan = 0;
        if ($monthlyPlanRow) {
            $monthlyPlan = $monthlyPlanRow->{$this->planField};
            $dailyPlan = round(1 / $date->daysInMonth * $monthlyPlan, 2);

            $planFromStartOfMonth = round($date->day / $date->daysInMonth * $monthlyPlan, 2);

            $planFromStartOfYear = $plans
                    ->where('id', '!=', $monthlyPlanRow->id)
                    ->sum($this->planField)
                + $planFromStartOfMonth;
        }

        $result = [];
        $fact = $reports->sum('fact');
        switch ($filter->period) {
            case self::DAY:
                $result['plan'] = ['value' => $dailyPlan];
                $result['fact'] = $result['daily_fact_cits'] = ['value' => $fact];
                break;
            case self::MONTH:
                $result['month_plan'] = ['value' => $planFromStartOfMonth];
                $result['month_fact'] = $result['month_fact_cits'] = ['value' => $fact];
                break;
            case self::YEAR:
                $result['year_plan'] = ['value' => $planFromStartOfYear];
                $result['year_fact'] = $result['year_fact_cits'] = ['value' => $fact];
                break;
        }

        $result = array_merge($result, $this->getGSData($filter, $org));

        return $result;
    }

    protected function getGSData($filter, Org $org): array
    {
        $result = [];

        if (!in_array($filter->type, [self::GS, self::ALL])) {
            return $result;
        }

        $date = Carbon::parse($filter->date)->toImmutable();

        $liquid = $this->getLiquid($org, $date);
        $now = Carbon::now('Asia/Almaty')->toImmutable();
        $today = $liquid->where('date', $now)->first();
        $month = round(
            $liquid
                ->where('date', '>=', $now->startOfMonth())
                ->where('date', '<=', $now)->sum('value'),
            2
        );
        $year = round($liquid->sum('value'), 2);


        if ($filter->type === self::GS) {
            $result['fact'] = ['value' => $today ? $today->value : 0];
            $result['month_fact'] = ['value' => $month];
            $result['year_fact'] = ['value' => $year];
        } else {
            $result['daily_fact_gs'] = ['value' => $today ? $today->value : 0];
            $result['month_fact_gs'] = ['value' => $month];
            $result['year_fact_gs'] = ['value' => $year];
        }

        return $result;
    }


    private function getLiquid(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        $workTime = $this->getWorkTime($wells, $date);

        return DB::connection('tbd')
            ->table('prod.meas_liq')
            ->select('dbeg', 'liquid', 'well')
            ->where('dbeg', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date)
            ->whereIn('well', $wells)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->dbeg)->format('d.m.Y');
            })
            ->map(function ($items, $key) use ($workTime) {
                $dateLiquid = $items
                    ->map(function ($item) use ($workTime) {
                        $date = Carbon::parse($item->dbeg)->format('d.m.Y');
                        if (!isset($workTime[$item->well])) {
                            return 0;
                        }
                        if (!isset($workTime[$item->well][$date])) {
                            return 0;
                        }
                        return $item->liquid * $workTime[$item->well][$date];
                    })
                    ->sum();
                return [
                    'date' => Carbon::parse($key),
                    'value' => $dateLiquid
                ];
            });
    }

    protected function getOrgWells(Org $org, CarbonImmutable $date)
    {
        $orgIds = $this->getOrgIds($org->id);
        return DB::connection('tbd')
            ->table('prod.well_org')
            ->select('id')
            ->whereIn('org', $orgIds)
            ->where('dbeg', '<=', $date)
            ->where('dend', '>=', $date)
            ->get()
            ->pluck('id')
            ->toArray();
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

    protected function getWorkTime(array $wellIds, CarbonImmutable $date): array
    {
        $result = [];

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend', 's.well')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $date->startOfYear())
            ->where('dend', '>=', $date)
            ->whereIn('well', $wellIds)
            ->whereIn('dict.well_status_type.code', MeasurementLogForm::WELL_ACTIVE_STATUSES)
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $currentDate = $date->startOfYear();
        while ($currentDate < $date) {
            $startOfDay = $currentDate->startOfDay();
            $endOfDay = $currentDate->endOfDay();
            foreach ($wellIds as $wellId) {
                $result[$wellId][$currentDate->format('d.m.Y')] = $this->getHoursForOneDay(
                    $wellStatuses,
                    $endOfDay,
                    $startOfDay,
                    $wellId
                );
            }

            $currentDate = $currentDate->addDay();
        }

        return $result;
    }

    private function getHoursForOneDay(
        Collection $wellStatuses,
        CarbonImmutable $endOfDay,
        CarbonImmutable $startOfDay,
        $wellId
    ): int {
        $hours = 0;
        $dailyStatuses = $wellStatuses
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $wellId);

        foreach ($dailyStatuses as $status) {
            if ($status->dbeg <= $startOfDay && $status->dend >= $endOfDay) {
                $hours += 24;
            } elseif ($status->dbeg > $startOfDay) {
                $hours += $status->dbeg->diffInHours($status->dend < $endOfDay ? $status->dend : $endOfDay);
            } elseif ($status->dend < $endOfDay) {
                $hours += $startOfDay->diffInHours($status->dend);
            }
        }
        return $hours;
    }
}