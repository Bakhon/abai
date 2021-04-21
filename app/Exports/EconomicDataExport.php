<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EconomicDataExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $data;

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
        return [
            'sum_prs1',
            'sum_oil',
            'sum_liquid',
            'sum_Revenue_total',
            'sum_NetBack_bf_pr_exp',
            'sum_Operating_profit',
            'timeseries'
        ];
    }
}
