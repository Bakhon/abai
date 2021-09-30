<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\ReportOrgDailyCits;
use App\Services\BigData\FieldLimitsService;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class DailyReports extends TableForm
{
    const DAY = 0;
    const MONTH = 1;
    const YEAR = 2;

    const CITS = 'ЦИТС';
    const GS = 'ГС';
    const ALL = 'ЦИТС/ГС';

    protected $metricCode = '';

    public function getResults(): array
    {
        $result = [
            'id' => $this->request->get('id')
        ];
        $filter = json_decode($this->request->get('filter'));
        if (!$this->request->get('id')) {
            return ['rows' => []];
        }

        $org = Org::find($this->request->get('id'));
        if (!$org) {
            return ['rows' => []];
        }
        $result['org_name'] = ['value' => $org->name_ru];


        foreach ([self::DAY, self::MONTH, self::YEAR] as $period) {
            $filter->period = $period;
            $data = $this->getData($org, $filter);
            $result += $data;
        }

        $columns = $this->getColumns($filter);

        return [
            'columns' => $columns,
            'rows' => [$result]
        ];
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $column = $this->getFieldByCode($params['field']);
        $metric = Metric::query()
            ->select('id')
            ->where('code', $this->metricCode)
            ->first();
        if (!$metric) {
            return;
        }
        $item = ReportOrgDailyCits::where('org', $params['wellId'])
            ->where('metric', $metric->id)
            ->whereDate('report_date', '>=', $params['date']->toDateTimeString())
            ->whereDate('report_date', '<=', $params['date']->toDateTimeString())
            ->distinct()
            ->first();
        if (!$item) {
            ReportOrgDailyCits::insert(
                [
                    'org' => $params['wellId'],
                    'metric' => $metric->id,
                    'report_date' => $params['date']->toDateTimeString(),
                    'plan' => 0,
                    $column['code'] => $params['value'],
                ]
            );
        } else {
            $field = $column['code'];
            $item->$field = $params['value'];
            $item->save();
        }
    }

    protected function getReports(\stdClass $filter): Collection
    {
        $startDate = self::getStartDate($filter->date, $filter->period);
        $endDate = Carbon::parse($filter->date);

        return ReportOrgDailyCits::where('org', $this->request->get('id'))
            ->whereDate('report_date', '>=', $startDate)
            ->whereDate('report_date', '<=', $endDate)
            ->distinct()
            ->whereHas(
                'metric',
                function ($query) {
                    return $query->where('code', $this->metricCode);
                }
            )
            ->get();
    }

    protected static function getStartDate(string $date, string $period): Carbon
    {
        $startDate = Carbon::parse($date);
        if ($period == self::MONTH) {
            $startDate = $startDate->firstOfMonth();
        } elseif ($period == self::YEAR) {
            $startDate = $startDate->firstOfYear();
        }

        return $startDate;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if ($this->request->get('fact')) {
            $limits = $this->calculateLimits();
            if (!$this->isValidFactLimits($limits)) {
                $errors['fact'][] = trans('bd.value_outside') . " ({$limits['min']}, {$limits['max']})";
            }
        }

        return $errors;
    }

    private function isValidFactLimits(array $limits): bool
    {
        if (empty($limits)) {
            return true;
        }

        if ($limits['min'] === $limits['max']) {
            return true;
        }

        if ($limits['min'] <= $this->request->get('fact') && $limits['max'] >= $this->request->get('fact')) {
            return true;
        }
        return false;
    }

    private function calculateLimits(): array
    {
        $reports = ReportOrgDailyCits::where('org', $this->request->get('well_id'))
            ->whereDate('report_date', '<', $this->request->get('date'))
            ->whereHas(
                'metric',
                function ($query) {
                    return $query->where('code', $this->metricCode);
                }
            )
            ->orderBy('report_date', 'desc')
            ->limit(30)
            ->get();

        $fieldLimitsService = app()->make(FieldLimitsService::class);
        return $fieldLimitsService->calculateColumnLimits('fact', $reports);
    }

    protected function getColumns(\stdClass $filter): Collection
    {
        $type = $filter->type ?? self::CITS;

        $columns = $this->getFields()
            ->filter(function ($column) use ($type) {
                if (empty($column['show_if'])) {
                    return true;
                }

                return in_array($type, $column['show_if']['type']);
            })
            ->map(function ($column) use ($type) {
                if ($type === self::GS && $column['code'] === 'fact') {
                    $column['is_editable'] = false;
                }
                return $column;
            })
            ->values();

        return $columns;
    }


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
        $type = $filter->type ?? self::CITS;

        if (!in_array($type, [self::GS, self::ALL])) {
            return $result;
        }

        $date = Carbon::parse($filter->date)->toImmutable();

        $measuredFieldValues = $this->getMeasuredFieldValues($org, $date);
        $now = Carbon::now('Asia/Almaty')->toImmutable();
        $today = $measuredFieldValues->where('date', $now)->first();
        $month = round(
            $measuredFieldValues
                ->where('date', '>=', $now->startOfMonth())
                ->where('date', '<=', $now)->sum('value'),
            2
        );
        $year = round($measuredFieldValues->sum('value'), 2);


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

    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        return collect();
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
                    ) / 24;
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