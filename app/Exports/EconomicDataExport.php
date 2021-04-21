<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EconomicDataExport implements FromArray, WithHeadings, WithMapping
{
    use Exportable;

    protected $data;

    const COLUMNS = [
        'uwi',
        'oil',
        'liquid',
        'prs',
        'status',
        'Revenue_total',
        'Trans_expenditures',
        'MET_payments',
        'ERT_payments',
        'ECD_payments',
        'PRS_expenditures',
        'Overall_expenditures',
        'Operating_profit',
        'profitability',
        'profitability_v_prostoe',
    ];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return array_merge(self::COLUMNS, ['date']);
    }

    public function map($row): array
    {
        $res = [];

        foreach (self::COLUMNS as $column) {
            $res[$column] = $row[$column];
        }

        $res['date'] = $row['dt'];

        return $res;
    }
}
