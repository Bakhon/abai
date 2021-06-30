<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\ReportOrgDailyCits;
use Carbon\Carbon;

class DailyReportsFluidProd extends TableForm
{

    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $configurationFileName = 'daily_reports_fluid_prod';

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
        $dateRows = $this->getData($filter->date, $filter->date, $filter->optionId ?? 0);
        if ($dateRows) {
            $result['plan'] = ['value' => $dateRows['plan']];
            $result['fact'] = ['value' => $dateRows['fact']];
            $result['daily_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }
        $dateTimeObj = new \DateTime($filter->date);
        $dateTimeObj->modify('first day of this month');

        $monthRows = $this->getData($dateTimeObj->format('Y-m-d\TH:i:s'), $filter->date, $filter->optionId ?? 0);
        if ($monthRows) {
            $result['month_plan'] = ['value' => $dateRows['plan']];
            $result['month_fact'] = ['value' => $dateRows['fact']];
            $result['month_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }

        $dateTimeObj->modify('first day of january ' . $dateTimeObj->format('Y'));
        $yearRows = $this->getData($dateTimeObj->format('Y-m-d\TH:i:s'), $filter->date, $filter->optionId ?? 0);
        if ($yearRows) {
            $result['year_plan'] = ['value' => $dateRows['plan']];
            $result['year_fact'] = ['value' => $dateRows['fact']];
            $result['year_deviation'] = ['value' => $dateRows['fact'] - $dateRows['plan']];
        }
        return ['rows' => [$result]];
    }

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        /** TODO метод для сохранения значения поля */
    }

    protected function saveHistory(string $field, $value): void
    {
        /** TODO метод для сохранения истории изменений */
    }

    private function getData($startDate, $endDate, $optionId) {
        $data = ReportOrgDailyCits::query()
            ->select(['plan', 'fact'])
            ->where('org', '=', $this->request->get('id'))
            ->whereDate('report_date', '>=', $startDate)
            ->whereDate('report_date', '<=', $endDate)
            ->distinct()
            ->get();
        $result = [
            'id' => 0,
            'plan' => $data->sum('plan'),
        ];
        $result['fact'] = $data->sum('plan');
        if ($optionId == self::ALL || $optionId == self::GS) {
            $result['fact'] = 0;
        }

        return $result;
    }
}