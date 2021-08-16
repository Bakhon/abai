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

        $mergeColumns = [];
        $columns = [
            [
                'code' => 'value',
                'title' => 'Показатель',
                'type' => 'text'
            ]
        ];
        $date = Carbon::parse($filter->date);
        $dateTo = Carbon::parse($filter->date_to);
        while (true) {
            $mergeColumns['date_' . $date->format('m_Y')] = [
                'code' => 'date_' . $date->format('m_Y'),
                'title' => $date->format('F Y')
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_well_count",
                'title' => 'скваж.',
                'parent_column' => 'date_' . $date->format('m_Y'),
                'type' => 'integer',
                'is_editable' => true
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_fact",
                'title' => 'замер.',
                'parent_column' => 'date_' . $date->format('m_Y'),
                'type' => 'integer',
                'is_editable' => true
            ];

            $date->addMonth();
            if ($date >= $dateTo) {
                break;
            }
        }

        return [
            'columns' => $columns,
            'merge_columns' => $mergeColumns,
            'complicated_header' => $this->tableHeaderService->getHeader($columns, $mergeColumns),
            'rows' => [
                [
                    'value' => ['value' => 'd11'],
                    'date_08_2021_well_count' => ['value' => 'dd'],
                    'date_08_2021_fact' => ['value' => 'dd'],
                    'is_editable' => true
                ]
            ]
        ];
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }

}