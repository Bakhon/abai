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

        $builder = $client->query('month_meter_prod_oil_v02', Granularity::MONTH);
        if ($request->has('month')) {
            $builder
                ->interval('2014-01-01T00:00:00+00:00/2020-10-31T00:00:00+00:00')
                ->select('field')
                ->select('ngdu')
                ->select('cndg')
                ->select('gu')
                ->select('tap')
                ->select('zu')
                ->select('uwi')
                ->select('drill_year')
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
                ->where('month', '=', $request->month)
                ->where('year', '=', $request->year)
                ->where('dzo_short', '=', $request->org);
        } 
        else {
            $builder
                ->interval('2014-01-01T00:00:00+00:00/2020-10-31T00:00:00+00:00')
                ->select('uwi')
                ->sum("oil");
        }
        $result = $builder->groupBy();
        $array = $result->data();
        $data['wellsList'] =  [['Месторождение 0', 
        'НГДУ', 
        'ЦДНГ', 
        'ГУ', 
        'Отвод', 
        'ЗУ/ГЗУ',
        'Скважина', 
        'Год бурения', 
        'Блок', 
        'Действующие интервалы перфорации',
        'Техрежим - Qж, м3/сут', 
        'Техрежим - Обв, %', 
        'Техрежим - Qн, т/сут', 
        'Qж, м3/сут',
        'Qн, т/сут',
        'Обв, % 15',
        'Дата исследования', 
        'Заключение',
        'Hдин, м',
        'Pзатр, атм',
        'Pзаб, атм',
        'Pбуф, атм',
        'Pмакс.нагрузки, кг',
        'Отработанные дни',
        'Qн, т',
        'Qж, м3',
        'Пробы',
        'Простои',
        'Кол-во ПРС',
        'Факт с н.г. - Qж, м3/сут',
        'Факт с н.г. - Qн, т/сут',
        'Факт с н.г. - Обв, %',
        'Факт с н.г. - Отработанные дни',
        'Факт с н.г. - Qн, т',
        'Факт с н.г. - Qж, м3',
        'ДЗО']];
        foreach ($array as $item) {
            $well = [];
            array_push($well, $item['field']);
            array_push($well, $item['ngdu']);
            array_push($well, $item['cndg']);
            array_push($well, $item['gu']);
            array_push($well, $item['tap']);
            array_push($well, $item['zu']);
            array_push($well, $item['uwi']);
            array_push($well, date("Y", strtotime($item['drill_year'])));
            array_push($well, $item['block2']);
            array_push($well, $item['perf_intr']);
            array_push($well, $item['tm_liquid']);
            array_push($well, $item['tm_bsw']);
            array_push($well, $item['tm_oil']);
            array_push($well, $item['liq_avg']);
            array_push($well, $item['oil_avg']);
            array_push($well, $item['bsw_avg']);
            array_push($well,date("d.m.Y", strtotime($item['gdis_date'])));
            array_push($well, $item['gdis_conclusion']);
            array_push($well, $item['gdis_hdyn']);
            array_push($well, $item['gdis_pzatr']);
            array_push($well, $item['gdis_pzab']);
            array_push($well, $item['gdis_pbuf']);
            array_push($well, $item['gdis_pmaxload']);
            array_push($well, $item['work_day']);
            array_push($well, $item['oil']);
            array_push($well, $item['liquid_val']);
            array_push($well, $item['bsws']);
            array_push($well, $item['repairs_text']);
            array_push($well, $item['prs_count']);
            array_push($well, $item['liq_cumm_avg']);
            array_push($well, $item['oil_cumm_avg']);
            array_push($well, $item['bsw_cumm_avg']);
            array_push($well, $item['work_day_cumm']);
            array_push($well, $item['oil_cumm']);
            array_push($well, $item['liq_cumm']);
            array_push($well, $item['dzo']);
            array_push($data['wellsList'], $well);
        }
        $vdata = [

            'wellsList' => $data['wellsList'],
            // 'excel' => $data['excel']

        ];


        return response()->json($vdata);
    }
}