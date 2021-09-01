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

        $measurements = GdisCurrent::query()
            ->where('well', $this->request->get('id'))
            ->orderBy('meas_date', 'desc')
            ->limit(10)
            ->with('values', 'values.metric')
            ->get();

        $columns = $this->getColumns($measurements);

        dd($columns);

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