<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EconomicDataExport implements FromView
{
    protected $data;

    const COLUMNS = [
        'uwi',
        'oil',
//        'liquid',
//        'prs',
//        'status',
//        'Revenue_total',
//        'Trans_expenditures',
//        'MET_payments',
//        'ERT_payments',
//        'ECD_payments',
//        'PRS_expenditures',
//        'Overall_expenditures',
//        'Operating_profit',
//        'profitability',
//        'profitability_v_prostoe',
    ];

    public function __construct(array $data)
    {
        $this->data = $data;
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

    public function view(): View
    {
        return view('exports.economic', [
            'data' => $this->data
        ]);
    }
}
