<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\BigData\DictionaryService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlanGDIS extends TableForm
{
    protected $configurationFileName = 'plan_g_d_i_s';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date) || empty($filter->date_to)) {
            return ['rows' => []];
        }

        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty');
        $dateTo = Carbon::parse($filter->date_to)->timezone('Asia/Almaty');
        $dates = [];
        while ($date < $dateTo) {
            $dates[] = clone $date;
            $date->addMonthNoOverflow();
        }

        $rows = $this->fillRows($dates);

        $mergeColumns = [];
        $columns = [
            [
                'code' => 'value',
                'title' => 'Показатель',
                'type' => 'label'
            ]
        ];

        foreach ($dates as $date) {
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
                'code' => "date_{$date->format('m_Y')}_measure",
                'title' => 'замер.',
                'parent_column' => 'date_' . $date->format('m_Y'),
                'type' => 'integer',
                'is_editable' => true
            ];
        }

        return [
            'columns' => $columns,
            'merge_columns' => $mergeColumns,
            'complicated_header' => $this->tableHeaderService->getHeader($columns, $mergeColumns),
            'rows' => $rows
        ];
    }

    private function fillRows(array $dates): ?array
    {
        $dateTo = end($dates);
        $dateFrom = reset($dates);

        $data = DB::connection('tbd')
            ->table('prod.plan_gdis')
            ->where('year', '>=', $dateFrom->year)
            ->where('year', '<=', $dateTo->year)
            ->where('well', $this->request->get('id'))
            ->get();

        $tree = $this->getExplTree();
        $rows = [];
        $this->fillRowsTree($tree, $rows, $dates, $data);
        return $rows;
    }

    private function fillRowsTree(array $tree, array &$rows, array $dates, Collection $data, $level = 0)
    {
        $num = 1;
        foreach ($tree as $item) {
            $rows[] = [
                'value' => ['name' => ($level === 0 ? $num++ . '. ' : '') . "<b>{$item['label']}</b>"]
            ];
            if (!empty($item['rows'])) {
                foreach ($item['rows'] as $treeRow) {
                    $row = [
                        'id' => $this->request->get('id'),
                        'value' => ['name' => $treeRow->name]
                    ];
                    foreach ($dates as $date) {
                        $rowData = $data
                            ->where('month', $date->month)
                            ->where('year', $date->year)
                            ->where('expl_type_proced_type_plan_gdis', $treeRow->id)
                            ->first();

                        $row["date_{$date->format('m_Y')}_well_count"] = [
                            'value' => $rowData ? $rowData->well_count : 0,
                            'params' => ['expl_proced_type' => $treeRow->id]
                        ];
                        $row["date_{$date->format('m_Y')}_measure"] = [
                            'value' => $rowData ? $rowData->measure : 0,
                            'params' => ['expl_proced_type' => $treeRow->id]
                        ];
                    }
                    $rows[] = $row;
                }
            }

            if (empty($item['children'])) {
                continue;
            }
            $this->fillRowsTree($item['children'], $rows, $dates, $data, $level + 1);
        }
    }

    private function getExplTree()
    {
        $dictionaryService = app()->make(DictionaryService::class);
        $explTypes = $dictionaryService->get('expl_type_plan_gdis');
        $procedTypes = DB::connection('tbd')
            ->table('dict.expl_type_proced_type_plan_gdis as e')
            ->join('dict.proced_type_plan_gdis as p', 'p.id', 'e.proced_type_plan_gdis')
            ->select('expl_type_plan_gdis', 'proced_type_plan_gdis', 'p.name', 'e.id')
            ->get()
            ->groupBy('expl_type_plan_gdis');
        $this->fillExplTree($explTypes, $procedTypes);
        return $explTypes;
    }

    private function fillExplTree(&$tree, $procedTypes)
    {
        foreach ($tree as $key => $item) {
            if ($procedTypes->get($item['id'])) {
                $tree[$key]['rows'] = $procedTypes->get($item['id'])->toArray();
            }
            if (!empty($item['children'])) {
                $this->fillExplTree($tree[$key]['children'], $procedTypes);
            }
        }
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        list($date, $month, $year, $field) = explode('_', $params['field'], 4);
        $explProcedType = $this->request->params['expl_proced_type'];

        $plan = DB::connection('tbd')
            ->table('prod.plan_gdis')
            ->where('well', $params['wellId'])
            ->where('expl_type_proced_type_plan_gdis', $explProcedType)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($plan) {
            DB::connection('tbd')
                ->table('prod.plan_gdis')
                ->where('id', $plan->id)
                ->update([$field => $params['value']]);
        } else {
            DB::connection('tbd')
                ->table('prod.plan_gdis')
                ->insert(
                    [
                        'well' => $params['wellId'],
                        'expl_type_proced_type_plan_gdis' => $explProcedType,
                        'month' => $month,
                        'year' => $year,
                        $field => $params['value']
                    ]
                );
        }
    }

}