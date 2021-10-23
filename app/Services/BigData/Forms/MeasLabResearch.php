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

        $rowsData = DB::connection('tbd')
            ->table('prod.lab_research as lr')
            ->select('lrv.*', 'lr.id', 'lr.well', 'lr.research_date', 'm.code')
            ->leftJoin('prod.lab_research_value as lrv', 'lr.id', 'lrv.research')
            ->leftJoin('dict.metric as m', 'm.id', 'lrv.param')
            ->whereIn('lr.well', $wells->pluck('id')->toArray())
            ->whereDate('research_date', '<=', $filter->date)
            ->where('research_type', $filter->research_type)
            ->orderBy('lr.well')
            ->orderBy('lr.research_date', 'desc')
            ->distinct('lr.well')
            ->get();

        $rows = $wells
            ->map(
                function ($item) use ($filter, $rowsData, $columns) {
                    $rowData = $rowsData->where('well', $item->id);

                    $result = [
                        'id' => $item->id
                    ];

                    foreach ($columns as $column) {
                        $cellData = $rowData->where('code', $column['code'])->first();
                        if ($column['type'] === 'link') {
                            $cellValue = [
                                'id' => $item->id,
                                'name' => $item->uwi,
                                'href' => '#'
                            ];
                        } else {
                            $value = $cellData ? $cellData->{$column['column']} : null;
                            $isSameDay = $cellData && Carbon::parse($filter->date, 'Asia/Almaty')
                                    ->diffInDays(Carbon::parse($cellData->research_date, 'Asia/Almaty')) === 0;

                            if ($isSameDay) {
                                $cellValue = ['value' => $value];
                            } else {
                                $cellValue = [
                                    'date' => $cellData ? $cellData->research_date : null,
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
            });
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $columns = $this->getColumns($this->request->get('research_type'));
        $column = $columns->where('code', $params['field'])->first();

        $researchId = $this->getResearchId($params['wellId']);
        $researchValueId = $this->getResearchValueId($params['field'], $researchId);

        DB::connection('tbd')
            ->table('prod.lab_research_value')
            ->where('id', $researchValueId)
            ->update(
                [
                    $column['column'] => $params['value']
                ]
            );
    }

    protected function getResearchId($wellId)
    {
        $research = DB::connection('tbd')
            ->table('prod.lab_research')
            ->where('well', $wellId)
            ->whereDate('research_date', '=', $this->request->get('date'))
            ->where('research_type', $this->request->get('research_type'))
            ->first();

        if (!$research) {
            $researchId = DB::connection('tbd')
                ->table('prod.lab_research')
                ->insertGetId(
                    [
                        'well' => $wellId,
                        'research_date' => $this->request->get('date'),
                        'research_type' => $this->request->get('research_type')
                    ]
                );
        } else {
            $researchId = $research->id;
        }
        return $researchId;
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