<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\LabResearchType;
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

        $table = $this->getResearchTable($filter->research_type);

        $columns = $this->getColumns($table);

        $rowsData = DB::connection('tbd')
            ->table('prod.lab_research as lr')
            ->select('t.*', 'lr.id', 'lr.well', 'lr.research_date')
            ->leftJoin($table . ' as t', 'lr.id', 't.well')
            ->whereIn('lr.well', $wells->pluck('id')->toArray())
            ->whereDate('research_date', '<=', $filter->date)
            ->where('research_type', $filter->research_type)
            ->orderBy('lr.well')
            ->orderBy('lr.research_date', 'desc')
            ->distinct('lr.well')
            ->get();

        $rows = $wells
            ->map(
                function ($item) use ($rowsData, $columns) {
                    $rowData = $rowsData->where('well', $item->id)->first();
                    if (empty($rowData)) {
                        return null;
                    }
                    $result = [
                        'id' => $rowData->id
                    ];

                    foreach ($columns as $column) {
                        if ($column['type'] === 'link') {
                            $value = [
                                'id' => $item->id,
                                'name' => $item->uwi,
                                'href' => '#'
                            ];
                        } else {
                            $value = [
                                'date' => $rowData->research_date,
                                'old_value' => $rowData->{$column['code']}
                            ];
                        }
                        $result[$column['code']] = $value;
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

    protected function getResearchTable(int $researchTypeId)
    {
        $researchType = LabResearchType::find($researchTypeId);
        try {
            return ResearchLabResearch::TABLES_BY_TYPE[$researchType->code];
        } catch (\Exception $e) {
            throw new \Exception('Нет данных по исследованию');
        }
    }

    protected function getColumns(string $table): Collection
    {
        return $this->getFields()
            ->filter(function ($field) use ($table) {
                if (!isset($field['table'])) {
                    return true;
                }
                return $field['table'] === $table;
            });
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }
}