<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

class DBdobController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dob1(Request $request)
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        $builder = $client->query('date_by_prod_dob_v01', Granularity::ALL);

        if  ($request->has('field')) {
            $builder
                ->interval('2020-08-01T00:00:00+00/2020-08-24T00:00:00+00:00')
                ->select('field')
                ->select('dzo_short')
                ->select('uwi')
                ->select('ngdu')
                ->select('cndg')
                ->select('block')
                ->select('zu')
                ->select('gu')
                ->select('grzs')
                ->select('status')
                ->select('tm_oil')
                ->select('tm_bsw')
                ->select('tm_liquid')
                ->select('2020-08-01_oil')
                ->select('2020-08-01_bsw_val')
                ->select('2020-08-01_liquid_val')
                ->select('2020-08-02_oil')
                ->select('2020-08-02_bsw_val')
                ->select('2020-08-02_liquid_val')
                ->select('2020-08-03_oil')
                ->select('2020-08-03_bsw_val')
                ->select('2020-08-03_liquid_val')
                ->select('2020-08-04_oil')
                ->select('2020-08-04_bsw_val')
                ->select('2020-08-04_liquid_val')
                ->select('2020-08-05_oil')
                ->select('2020-08-05_bsw_val')
                ->select('2020-08-05_liquid_val')
                ->select('2020-08-06_oil')
                ->select('2020-08-06_bsw_val')
                ->select('2020-08-06_liquid_val')
                ->select('2020-08-07_oil')
                ->select('2020-08-07_bsw_val')
                ->select('2020-08-07_liquid_val')
                ->select('2020-08-08_oil')
                ->select('2020-08-08_bsw_val')
                ->select('2020-08-08_liquid_val')
                ->select('2020-08-09_oil')
                ->select('2020-08-09_bsw_val')
                ->select('2020-08-09_liquid_val')
                ->select('2020-08-10_oil')
                ->select('2020-08-10_bsw_val')
                ->select('2020-08-10_liquid_val')
                ->select('2020-08-11_oil')
                ->select('2020-08-11_bsw_val')
                ->select('2020-08-11_liquid_val')
                ->select('2020-08-12_oil')
                ->select('2020-08-12_bsw_val')
                ->select('2020-08-12_liquid_val')
                ->select('2020-08-13_oil')
                ->select('2020-08-13_bsw_val')
                ->select('2020-08-13_liquid_val')
                ->select('2020-08-14_oil')
                ->select('2020-08-14_bsw_val')
                ->select('2020-08-14_liquid_val')
                ->select('2020-08-15_oil')
                ->select('2020-08-15_bsw_val')
                ->select('2020-08-15_liquid_val')
                ->select('2020-08-16_oil')
                ->select('2020-08-16_bsw_val')
                ->select('2020-08-16_liquid_val')
                ->select('2020-08-17_oil')
                ->select('2020-08-17_bsw_val')
                ->select('2020-08-17_liquid_val')
                ->select('2020-08-18_oil')
                ->select('2020-08-18_bsw_val')
                ->select('2020-08-18_liquid_val')
                ->select('2020-08-19_oil')
                ->select('2020-08-19_bsw_val')
                ->select('2020-08-19_liquid_val')
                ->select('2020-08-20_oil')
                ->select('2020-08-20_bsw_val')
                ->select('2020-08-20_liquid_val')
                ->select('2020-08-21_oil')
                ->select('2020-08-21_bsw_val')
                ->select('2020-08-21_liquid_val')
                ->select('2020-08-22_oil')
                ->select('2020-08-22_bsw_val')
                ->select('2020-08-22_liquid_val')
                ->select('2020-08-23_oil')
                ->select('2020-08-23_bsw_val')
                ->select('2020-08-23_liquid_val')
                ->select('2020-08-24_oil')
                ->select('2020-08-24_bsw_val')
                ->select('2020-08-24_liquid_val')
                ->select('avgOil')
                ->select('avgbsw_val')
                ->select('avglliquid_val')
                ->where('dzo_short', '=', $request->dzo)
                ->where('field', '=', $request->field);
                
        }

        else {
            $builder
                ->interval('2020-08-01T00:00:00+00:00/2020-08-24T00:00:00+00:00')
                ->select('ngdu')
                ->select('cndg');
        }
        $result = $builder->groupBy();
        $array = $result->data();
        $data['wellsList3'] =  [];

        foreach ($array as $item) {
            $well = [];
            array_push($well, $item['field']);
            array_push($well, $item['dzo_short']);
            array_push($well, $item['uwi']);
            array_push($well, $item['ngdu']);
            array_push($well, $item['cndg']);
            array_push($well, $item['block']);
            array_push($well, $item['zu']);
            array_push($well, $item['gu']);
            array_push($well, $item['grzs']);
            array_push($well, $item['status']);
            array_push($well, $item['tm_oil']);
            array_push($well, $item['tm_bsw']);
            array_push($well, $item['tm_liquid']);
            array_push($well, round(($item['2020-08-01_oil']), 1));
            array_push($well, round(($item['2020-08-01_bsw_val']), 1));
            array_push($well, round(($item['2020-08-01_liquid_val']), 1));
            array_push($well, round(($item['2020-08-02_oil']), 1));
            array_push($well, round(($item['2020-08-02_bsw_val']), 1));
            array_push($well, round(($item['2020-08-02_liquid_val']), 1));
            array_push($well, round(($item['2020-08-03_oil']), 1));
            array_push($well, round(($item['2020-08-03_bsw_val']), 1));
            array_push($well, round(($item['2020-08-03_liquid_val']), 1));
            array_push($well, round(($item['2020-08-04_oil']), 1));
            array_push($well, round(($item['2020-08-04_bsw_val']), 1));
            array_push($well, round(($item['2020-08-04_liquid_val']), 1));
            array_push($well, round(($item['2020-08-05_oil']), 1));
            array_push($well, round(($item['2020-08-05_bsw_val']), 1));
            array_push($well, round(($item['2020-08-05_liquid_val']), 1));
            array_push($well, round(($item['2020-08-06_oil']), 1));
            array_push($well, round(($item['2020-08-06_bsw_val']), 1));
            array_push($well, round(($item['2020-08-06_liquid_val']), 1));
            array_push($well, round(($item['2020-08-07_oil']), 1));
            array_push($well, round(($item['2020-08-07_bsw_val']), 1));
            array_push($well, round(($item['2020-08-07_liquid_val']), 1));
            array_push($well, round(($item['2020-08-08_oil']), 1));
            array_push($well, round(($item['2020-08-08_bsw_val']), 1));
            array_push($well, round(($item['2020-08-08_liquid_val']), 1));
            array_push($well, round(($item['2020-08-09_oil']), 1));
            array_push($well, round(($item['2020-08-09_bsw_val']), 1));
            array_push($well, round(($item['2020-08-09_liquid_val']), 1));
            array_push($well, round(($item['2020-08-10_oil']), 1));
            array_push($well, round(($item['2020-08-10_bsw_val']), 1));
            array_push($well, round(($item['2020-08-10_liquid_val']), 1));
            array_push($well, round(($item['2020-08-11_oil']), 1));
            array_push($well, round(($item['2020-08-11_bsw_val']), 1));
            array_push($well, round(($item['2020-08-11_liquid_val']), 1));
            array_push($well, round(($item['2020-08-12_oil']), 1));
            array_push($well, round(($item['2020-08-12_bsw_val']), 1));
            array_push($well, round(($item['2020-08-12_liquid_val']), 1));
            array_push($well, round(($item['2020-08-13_oil']), 1));
            array_push($well, round(($item['2020-08-13_bsw_val']), 1));
            array_push($well, round(($item['2020-08-13_liquid_val']), 1));
            array_push($well, round(($item['2020-08-14_oil']), 1));
            array_push($well, round(($item['2020-08-14_bsw_val']), 1));
            array_push($well, round(($item['2020-08-14_liquid_val']), 1));
            array_push($well, round(($item['2020-08-15_oil']), 1));
            array_push($well, round(($item['2020-08-15_bsw_val']), 1));
            array_push($well, round(($item['2020-08-15_liquid_val']), 1));
            array_push($well, round(($item['2020-08-16_oil']), 1));
            array_push($well, round(($item['2020-08-16_bsw_val']), 1));
            array_push($well, round(($item['2020-08-16_liquid_val']), 1));
            array_push($well, round(($item['2020-08-17_oil']), 1));
            array_push($well, round(($item['2020-08-17_bsw_val']), 1));
            array_push($well, round(($item['2020-08-17_liquid_val']), 1));
            array_push($well, round(($item['2020-08-18_oil']), 1));
            array_push($well, round(($item['2020-08-18_bsw_val']), 1));
            array_push($well, round(($item['2020-08-18_liquid_val']), 1));
            array_push($well, round(($item['2020-08-19_oil']), 1));
            array_push($well, round(($item['2020-08-19_bsw_val']), 1));
            array_push($well, round(($item['2020-08-19_liquid_val']), 1));
            array_push($well, round(($item['2020-08-20_oil']), 1));
            array_push($well, round(($item['2020-08-20_bsw_val']), 1));
            array_push($well, round(($item['2020-08-20_liquid_val']), 1));
            array_push($well, round(($item['2020-08-21_oil']), 1));
            array_push($well, round(($item['2020-08-21_bsw_val']), 1));
            array_push($well, round(($item['2020-08-21_liquid_val']), 1));
            array_push($well, round(($item['2020-08-22_oil']), 1));
            array_push($well, round(($item['2020-08-22_bsw_val']), 1));
            array_push($well, round(($item['2020-08-22_liquid_val']), 1));
            array_push($well, round(($item['2020-08-23_oil']), 1));
            array_push($well, round(($item['2020-08-23_bsw_val']), 1));
            array_push($well, round(($item['2020-08-23_liquid_val']), 1));
            array_push($well, round(($item['2020-08-24_oil']), 1));
            array_push($well, round(($item['2020-08-24_bsw_val']), 1));
            array_push($well, round(($item['2020-08-24_liquid_val']), 1));
            array_push($well, round(($item['avgOil']), 1));
            array_push($well, round(($item['avgbsw_val']), 1));
            array_push($well, round(($item['avglliquid_val']), 1));
            array_push($data['wellsList3'], $well);
    }
    $vdata = [
        'wellsList3' => $data['wellsList3'], 
        'excel' => $data['wellsList3']

    ];
    // echo $vdata;
    return response()->json($vdata);
    }
}
