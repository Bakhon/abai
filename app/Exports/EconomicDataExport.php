<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EconomicDataExport implements FromView
{
    protected $data;

    const COLUMNS_SELECT = [
        'uwi',
        'status',
        'profitability',
        'profitability_kbm',
        'profitability_kbm_date',
        'profitability_v_prostoe',
        'profitability_kbm_v_prostoe',
        'profitability_kbm_date_v_prostoe',
    ];

    const COLUMNS_SUM = [
        'oil',
        'liquid',
        'prs',
        'Revenue_total',
        'Trans_expenditures',
        'MET_payments',
        'ERT_payments',
        'ECD_payments',
        'PRS_expenditures',
        'Overall_expenditures',
        'Operating_profit',
    ];

    const COLUMN_DATE = 'dt';

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function map($row): array
    {
        $res = [];

        foreach (self::columns() as $column) {
            $res[$column] = $row[$column];
        }

        return $res;
    }

    public function view(): View
    {
        return view('exports.economic', [
            'data' => $this->data
        ]);
    }

    public static function columns(): array
    {
        return array_merge(
            self::COLUMNS_SELECT,
            self::COLUMNS_SUM,
            [self::COLUMN_DATE]
        );
    }
}
