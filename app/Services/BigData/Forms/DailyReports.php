<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\ReportOrgDailyCits;
use App\Services\BigData\FieldLimitsService;
use Carbon\Carbon;

abstract class DailyReports extends TableForm
{
    const DAY = 0;
    const MONTH = 1;
    const YEAR = 2;

    protected $metricCode = '';

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
            $result['org_name'] = ['value' => $org->name_ru];
        }
        $filter->period = self::DAY;
        $filter->optionId = $filter->optionId ?? 0;
        $dateRows = $this->getData($filter);
        if ($dateRows) {
            $result['plan'] = ['value' => $dateRows['plan']];
            $result['fact'] = ['value' => $dateRows['fact']];
            $result['daily_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }

        $filter->period = self::MONTH;
        $monthRows = $this->getData($filter);
        if ($monthRows) {
            $result['month_plan'] = ['value' => $dateRows['plan']];
            $result['month_fact'] = ['value' => $dateRows['fact']];
            $result['month_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }

        $filter->period = self::YEAR;
        $yearRows = $this->getData($filter);
        if ($yearRows) {
            $result['year_plan'] = ['value' => $dateRows['plan']];
            $result['year_fact'] = ['value' => $dateRows['fact']];
            $result['year_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }
        return ['rows' => [$result]];
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

    protected function getData($filter)
    {
        $dateTimeObj = new \DateTime($filter->date);
        if ($filter->period == self::MONTH) {
            $dateTimeObj->modify('first day of this month');
        } elseif ($filter->period == self::YEAR) {
            $dateTimeObj->modify('first day of january ' . $dateTimeObj->format('Y'));
        }
        $startDate = $dateTimeObj->format('Y-m-d\TH:i:s');
        $endDate = $filter->date;

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

    protected function getCustomValidationErrors(): array
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

    private function isValidFactLimits(array $limits)
    {
        if (empty($limits)) {
            return true;
        }

        if ($limits['min'] <= $this->request->get('fact') && $limits['max'] >= $this->request->get('fact')) {
            return true;
        }
        return false;
    }

    private function calculateLimits()
    {
        $reports = ReportOrgDailyCits::where('org', $this->request->get('well_id'))
            ->whereDate('report_date', '<', $this->request->get('date'))
            ->whereDate('report_date', '>=', Carbon::parse($this->request->get('date'))->subMonth())
            ->whereHas(
                'metric',
                function ($query) {
                    return $query->where('code', $this->metricCode);
                }
            )
            ->get();

        $fieldLimitsService = app()->make(FieldLimitsService::class);
        return $fieldLimitsService->calculateColumnLimits('fact', $reports);
    }
}