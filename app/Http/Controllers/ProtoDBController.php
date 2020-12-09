<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

class ProtoDBController extends Controller
{
public function getProtoOtchet1(Request $request)
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $builder = $client->query('month_meter_prod_oil_v03', Granularity::MONTH);
        if ($request->has('org') && $request->has('start_date') && $request->has('end_date')) {
            $builder
                ->interval(''.$request->start_date.'T00:00:00+00:00/'.$request->end_date.'T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM');
                })
                ->select('field')
                ->select('ngdu')
                ->select('cndg')
                ->select('gu')
                ->select('tap')
                ->select('zu')
                ->select('uwi')
                ->select('drill_year')
                ->select('grzs')
                ->select('block2')
                ->select('perf_intr')
                ->select('tm_liquid')
                ->select('tm_bsw')
                ->select('tm_oil')
                ->sum('liq_avg')
                ->sum('oil_avg')
                ->sum('bsw_avg')
                ->select('gdis_date')
                ->select('gdis_conclusion')
                ->select('gdis_hdyn')
                ->select('gdis_pzatr')
                ->select('gdis_pzab')
                ->select('gdis_pbuf')
                ->select('gdis_pmaxload')
                ->select('work_day')
                ->sum("oil")
                ->sum("liquid_val")
                ->select('bsws')
                ->select('repairs_text')
                ->select('prs_count')
                ->sum('liq_cumm_avg')
                ->sum("oil_cumm_avg")
                ->sum("bsw_cumm_avg")
                ->select("work_day_cumm")
                ->sum("oil_cumm")
                ->sum("liq_cumm")
                ->select('dzo')
                ->where('dzo_short','=',$request->org);
        }
        $result = $builder->groupBy();
        $array = $result->data();

        $result = array();
        foreach($array as $row){
            $result[$row['uwi']][] = $row;
        }

        return response()->json($result);
    }
}
