<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Level23\Druid\DruidClient;

class MonthlyMeteredOilProductionExport implements FromView
{
    public function view(): View
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $response = $client->query('tbd_rep_dynprod_month_v3', Granularity::ALL)
        ->interval('1979-12-24 20:00:00', '2024-12-24 00:00:00')
        ->execute();

        return view('exports.mmop', [
            'mmop' => $response
        ]);
    }
}
