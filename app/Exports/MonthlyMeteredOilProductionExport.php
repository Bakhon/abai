<?php

namespace App\Exports;

use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MonthlyMeteredOilProductionExport implements FromView
{
    public function view(): View
    {

        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        $response = $client->query('month_meter_prod_oil', Granularity::ALL)
            ->interval('1901-01-01T00:00:00+00:00/2020-07-31T18:02:55+00:00')
            ->where('dzo_short','=','АО ОМГ')
            ->where('year','=','2020')
            ->where('month_sorted','=','03 Март')
            ->execute(5);

        return view('exports.mmop', [
            'mmop' => $response->data()
        ]);
    }
}
