<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\GdisCurrent;
use Illuminate\Support\Collection;

class CurrentGDIS extends TableForm
{
    protected $configurationFileName = 'current_g_d_i_s';

    public function getRows(array $params = []): array
    {
        $gdisFields = [
            'conclusion',
            'target',
            'device',
            'transcript_dynamogram',
            'note',
            'conclusion_text',
            'file_dynamogram',
        ];

        $metricCodes = [
            'FLVL',
            'BHP',
            'MLP',
            'INJR',
            'FLRT',
            'FLRD',
            'WCUT',
            'GASR',
            'ADMCF',
            'PDCF',
            'RRP',
            'RP',
            'BP',
            'STP',
            'OTP',
            'TBP',
            'STLV',
            'RSVT',
            'RSD',
            'PRDK',
            'DBD',
            'SLHDM',
            'PSHDM',
            'PSD',
            'OTPM',
            'TPDM',
            'PLST',
            'PMPR',
            'SHDMD',
            'SHDME',
            'RPM'
        ];

        $dates = GdisCurrent::query()
            ->where('well', $this->request->get('id'))
            ->select('meas_date')
            ->orderBy('meas_date', 'desc')
            ->distinct()
            ->limit(10)
            ->get();

        if ($dates->isEmpty()) {
            return [
                'rows' => []
            ];
        }
        $oldestDate = $dates->last()->meas_date;

        $measurements = GdisCurrent::query()
            ->where('well', $this->request->get('id'))
            ->where('meas_date', '>=', $oldestDate)
            ->orderBy('meas_date', 'desc')
            ->orderBy('id', 'desc')
            ->with('values', 'values.metricItem')
            ->get()
            ->groupBy(function ($item) {
                return $item->meas_date->format('d.m.Y');
            })
            ->map(function ($items) use ($metricCodes, $gdisFields) {
                $result = [];

                foreach ($gdisFields as $field) {
                    $item = $items->whereNotNull($field)->first();
                    if (!empty($item)) {
                        $result[$field] = $item->$field;
                    }
                }

                $itemsWithMetrics = $items->filter(function ($item) use ($metricCodes) {
                    foreach ($item->values as $value) {
                        if (in_array($value->metricItem->code, $metricCodes)) {
                            return true;
                        }
                    }
                    return false;
                });

                return $result;
            });

        dd($measurements);

        $columns = $this->getColumns($measurements);

        dd($measurements, $columns);

        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    private function getColumns(Collection $measurements): array
    {
        $columns = [
            [
                'code' => 'value',
                'title' => 'Показатель',
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_date',
                'title' => 'last_measure_date',
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_value',
                'title' => 'last_measure_value',
                'type' => 'label',
                'is_editable' => true
            ],
        ];

        foreach ($measurements as $measurement) {
            $columns[] = [
                'code' => 'meas_date_' . $measurement->meas_date->format('d_m_Y'),
                'title' => $measurement->meas_date->format('d.m.Y'),
                'type' => 'label',
                'is_editable' => false
            ];
        }

        return $columns;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }
}