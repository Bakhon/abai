<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\ReportOrgDailyCits;
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
            'id' => 0
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

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        // TODO: Implement saveSingleFieldInDB() method.
    }

    protected function saveHistory(string $field, $value): void
    {
        // TODO: Implement saveHistory() method.
    }


    protected function getData($filter) {
        $dateTimeObj = new \DateTime($filter->date);
        if ($filter->period == self::MONTH) {
            $dateTimeObj->modify('first day of this month');
        } elseif ($filter->period == self::YEAR) {
            $dateTimeObj->modify('first day of january ' . $dateTimeObj->format('Y'));
        }
        $startDate = $dateTimeObj->format('Y-m-d\TH:i:s');
        $endDate = $filter->date;

        return ReportOrgDailyCits::query()
            ->select('*')
            ->where('org', '=', $this->request->get('id'))
            ->whereDate('report_date', '>=', $startDate)
            ->whereDate('report_date', '<=', $endDate)
            ->distinct()
            ->whereHas('metric', function ($query) {
                return $query->where('code', '=', $this->metricCode);
            })
            ->get();
    }
}