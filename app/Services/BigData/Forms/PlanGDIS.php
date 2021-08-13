<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\BigData\DictionaryService;
use Carbon\Carbon;

class PlanGDIS extends TableForm
{
    protected $configurationFileName = 'plan_g_d_i_s';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date) || empty($filter->date_to)) {
            return ['rows' => []];
        }

        $result = [
            'id' => $this->request->get('id')
        ];

        $dictionaryService = app()->make(DictionaryService::class);
        $explTypes = $dictionaryService->get('expl_type_plan_gdis');

        $columns = $mergeColumns = [];
        $date = Carbon::parse($filter->date);
        $dateTo = Carbon::parse($filter->date_to);
        while (true) {
            $mergeColumns[] = [
                'code' => 'date_' . $date->format('m_Y'),
                'title' => $date->format('F Y')
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_well_count",
                'title' => 'скваж.'
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_fact",
                'title' => 'замер.'
            ];

            $date->addMonth();
            if ($date >= $dateTo) {
                break;
            }
        }

        return [
            'columns' => $columns,
            'merge_columns' => $mergeColumns,
            'rows' => [
                [
                    'date_08_2021_well_count' => ['value' => 'dd'],
                    'date_08_2021_fact' => ['value' => 'dd']
                ]
            ]
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

}