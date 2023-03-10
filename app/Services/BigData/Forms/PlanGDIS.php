<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\ResearchMethod;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlanGDIS extends TableForm
{
    protected $configurationFileName = 'plan_g_d_i_s';

    public function getResults(): array
    {
        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

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

        $rows = $this->getRows($dates);

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
                'title' => trans('app.months.' . $date->format('n')) . ' ' . $date->format('Y')
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_well_count",
                'title' => trans('bd.forms.plan_g_d_i_s.well'),
                'parent_column' => 'date_' . $date->format('m_Y'),
                'type' => 'integer',
                'validation' => 'nullable|numeric',
                'is_editable' => true
            ];
            $columns[] = [
                'code' => "date_{$date->format('m_Y')}_measure",
                'title' => trans('bd.forms.plan_g_d_i_s.measure'),
                'parent_column' => 'date_' . $date->format('m_Y'),
                'type' => 'integer',
                'validation' => 'nullable|numeric',
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

    private function getRows(array $dates): ?array
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
        return $this->generateRowsTree($tree, $dates, $data);
    }

    private function generateRowsTree(array $tree, array $dates, Collection $data, $level = 0)
    {
        $rows = [];
        $num = 1;
        foreach ($tree as $item) {
            $rows[] = [
                'value' => [
                    'name' => ($level === 0 ? $num++ . '. ' : '') . "<b>" . trans(
                            'bd.forms.plan_g_d_i_s.' . $item['name']
                        ) . "</b>"
                ]
            ];
            if (!empty($item['rows'])) {
                foreach ($item['rows'] as $treeRow) {
                    $rows[] = $this->addRow($treeRow, $dates, $data);
                }
            }

            if (empty($item['children'])) {
                continue;
            }
            $rows = array_merge($rows, $this->generateRowsTree($item['children'], $dates, $data, $level + 1));
        }
        return $rows;
    }

    private function addRow(ResearchMethod $treeRow, array $dates, Collection $data): array
    {
        $row = [
            'id' => $treeRow->id,
            'value' => ['name' => $treeRow->name_ru]
        ];
        foreach ($dates as $date) {
            $rowData = $data
                ->where('month', $date->month)
                ->where('year', $date->year)
                ->where('research_method', $treeRow->id)
                ->first();

            $row["date_{$date->format('m_Y')}_well_count"] = [
                'value' => $rowData ? $rowData->well_count : 0,
                'params' => [
                    'research_method' => $treeRow->id,
                    'org_id' => $this->request->get('id'),
                    'date' => $date->format('d.m.Y'),
                    'column' => 'well_count'
                ]
            ];
            $row["date_{$date->format('m_Y')}_measure"] = [
                'value' => $rowData ? $rowData->measure : 0,
                'params' => [
                    'research_method' => $treeRow->id,
                    'org_id' => $this->request->get('id'),
                    'date' => $date->format('d.m.Y'),
                    'column' => 'measure'
                ]
            ];
        }
        return $row;
    }

    private function getExplTree()
    {
        $researchMethods = ResearchMethod::all();

        $sections = [
            [
                'name' => 'flowing_wells'
            ],
            [
                'name' => 'depthpump_wells',
                'children' => [
                    [
                        'name' => 'pumpjack'
                    ],
                    [
                        'name' => 'evn_ecn'
                    ]
                ]
            ],
            [
                'name' => 'inj_wells'
            ],
            [
                'name' => 'obs_wells'
            ],
            [
                'name' => 'water_wells'
            ],
        ];

        $explTypes = $this->generateExplTree($sections, $researchMethods);
        return $explTypes;
    }

    private function generateExplTree($tree, $researchMethods)
    {
        $result = [];
        foreach ($tree as $key => $item) {
            $result[$key] = $item;
            if ($researchMethods->where($item['name'], true)->isNotEmpty()) {
                $result[$key]['rows'] = $researchMethods->where($item['name'], true);
            }
            if (!empty($item['children'])) {
                $result[$key]['children'] = $this->generateExplTree($tree[$key]['children'], $researchMethods);
            }
        }
        return $result;
    }

    public function submitForm(array $rows, array $filter = []): array
    {
        foreach ($rows as $row) {
            foreach ($row as $field) {
                $date = Carbon::parse($field['params']['date'], 'Asia/Almaty');
                $plan = DB::connection('tbd')
                    ->table('prod.plan_gdis')
                    ->where('well', $field['params']['org_id'])
                    ->where('research_method', $field['params']['research_method'])
                    ->where('month', $date->month)
                    ->where('year', $date->year)
                    ->first();

                if ($plan) {
                    DB::connection('tbd')
                        ->table('prod.plan_gdis')
                        ->where('id', $plan->id)
                        ->update([$field['params']['column'] => $field['value']]);
                } else {
                    DB::connection('tbd')
                        ->table('prod.plan_gdis')
                        ->insert(
                            [
                                'well' => $field['params']['org_id'],
                                'research_method' => $field['params']['research_method'],
                                'month' => $date->month,
                                'year' => $date->year,
                                $field['params']['column'] => $field['value']
                            ]
                        );
                }
            }
        }
        return [];
    }
}