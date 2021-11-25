<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\LabResearchType;
use App\Models\BigData\Dictionaries\Metric;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MeasLabResearch extends TableForm
{
    protected $configurationFileName = 'meas_lab_research';

    public function getResults(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->research_type)) {
            throw new \Exception('Выберите вид исследования');
        }

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $columns = $this->getColumns($filter->research_type);

        $researches = DB::connection('tbd')
            ->table('prod.lab_research')
            ->select('id', 'well', 'research_date')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->whereDate('research_date', '<=', $filter->date)
            ->where('research_type', $filter->research_type)
            ->orderBy('well')
            ->orderBy('research_date', 'desc')
            ->get();

        $researchValues = DB::connection('tbd')
            ->table('prod.lab_research_value as lrv')
            ->whereIn('lrv.research', $researches->pluck('id'))
            ->leftJoin('dict.metric as m', 'm.id', 'lrv.param')
            ->get();

        $rows = $wells
            ->map(
                function ($item) use ($filter, $researches, $researchValues, $columns) {
                    $research = $researches->where('well', $item->id)->first();
                    if ($research) {
                        $rowData = $researchValues->where('research', $research->id);
                    }

                    $result = [
                        'id' => $item->id
                    ];

                    foreach ($columns as $column) {
                        $cellData = !empty($rowData) ? $rowData->where('code', $column['code'])->first() : null;
                        if ($column['type'] === 'link') {
                            $cellValue = [
                                'id' => $item->id,
                                'name' => $item->uwi,
                                'href' => route('bigdata.well_card', ['wellId' => $item->id, 'wellName' => $item->uwi])
                            ];
                        } else {
                            $value = $cellData ? $cellData->{$column['column']} : null;
                            $isSameDay = $cellData && Carbon::parse($filter->date, 'Asia/Almaty')
                                    ->diffInDays(Carbon::parse($research->research_date, 'Asia/Almaty')) === 0;

                            if ($isSameDay) {
                                $cellValue = ['value' => $value];
                            } else {
                                $cellValue = [
                                    'date' => $cellData ? $research->research_date : null,
                                    'old_value' => $value
                                ];
                            }
                        }
                        $result[$column['code']] = $cellValue;
                    }
                    return $result;
                }
            )
            ->filter()
            ->values()
            ->toArray();

        return [
            'rows' => $rows,
            'columns' => $columns
        ];
    }

    protected function getColumns(int $researchTypeId): Collection
    {
        $researchType = LabResearchType::find($researchTypeId);
        return $this->getFields()
            ->filter(function ($field) use ($researchType) {
                if (!isset($field['depends_on'])) {
                    return true;
                }
                foreach ($field['depends_on'] as $dependency) {
                    if ($dependency['field'] === 'research_type') {
                        return $dependency['value']['code'] === $researchType->code;
                    }
                }
                return false;
            })->values();
    }

    public function submitForm(array $fields, array $filter = [])
    {
        $researchIds = $this->getResearchIds(array_keys($fields), $filter);
        $columns = $this->getColumns($filter['research_type']);

        foreach ($fields as $wellId => $values) {
            $researchId = $researchIds[$wellId];
            foreach ($values as $code => $val) {
                $researchValueId = $this->getResearchValueId($code, $researchId);
                $column = $columns->where('code', $code)->first();

                DB::connection('tbd')
                    ->table('prod.lab_research_value')
                    ->where('id', $researchValueId)
                    ->update(
                        [
                            $column['column'] => $val['value']
                        ]
                    );
            }
        }
        return [];
    }

    protected function getResearchIds(array $wellIds, array $filter)
    {
        $researchIds = [];

        $researches = DB::connection('tbd')
            ->table('prod.lab_research')
            ->select('id', 'well')
            ->whereIn('well', $wellIds)
            ->whereDate('research_date', '=', $filter['date'])
            ->where('research_type', $filter['research_type'])
            ->get();

        foreach ($wellIds as $wellId) {
            $research = $researches->where('well', $wellId)->first();
            if (!$research) {
                $researchId = DB::connection('tbd')
                    ->table('prod.lab_research')
                    ->insertGetId(
                        [
                            'well' => $wellId,
                            'research_date' => $filter['date'],
                            'research_type' => $filter['research_type']
                        ]
                    );
            } else {
                $researchId = $research->id;
            }
            $researchIds[$wellId] = $researchId;
        }

        return $researchIds;
    }

    protected function getResearchValueId($field, $researchId)
    {
        $metric = Metric::where('code', $field)->first();

        $researchValue = DB::connection('tbd')
            ->table('prod.lab_research_value')
            ->where('research', $researchId)
            ->where('param', $metric->id)
            ->first();

        if (!$researchValue) {
            $researchValueId = DB::connection('tbd')
                ->table('prod.lab_research_value')
                ->insertGetId(
                    [
                        'research' => $researchId,
                        'param' => $metric->id
                    ]
                );
        } else {
            $researchValueId = $researchValue->id;
        }
        return $researchValueId;
    }
}