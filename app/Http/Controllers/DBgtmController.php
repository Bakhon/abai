<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

class DBgtmController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gtm1(Request $request, DruidClient $client)
    {
        $builder = $client->query('raschet_by_gtm_month_v07', Granularity::ALL);

        if  ($request->has('ngdu')) {
            $builder
                ->interval('2020-01-01T00:00:00+00/2020-09-01T00:00:00+00:00')
                ->select('well_uwi')
                ->select('dzo_short')
                ->select('ngdu')
                ->select('tseh')
                ->select('gzu_type')
                ->select('horizon')
                ->select('block')
                ->select('dbeg')
                ->select('dend')
                ->select('long_name')
                ->select('contractor')
                ->select('liquid_avg_before')
                ->select('oil2_avg_before')
                ->select("1_calendar")
                ->select('1_dob')
                ->select('1_gdis_hdyn')
                ->select('1_gdis_pzab')
                ->select('1_liquid')
                ->select('1_obv')
                ->select('1_oil2')
                ->select('1_otrabotana') 
                ->select('1_work_time')
                ->select('2_calendar')
                ->select('2_dob')
                ->select('2_gdis_hdyn')
                ->select('2_gdis_pzab')
                ->select('2_liquid')
                ->select('2_obv')
                ->select('2_oil2')
                ->select('2_otrabotana') 
                ->select('2_work_time')
                ->select('3_calendar')
                ->select('3_dob')
                ->select('3_gdis_hdyn')
                ->select('3_gdis_pzab')
                ->select('3_liquid')
                ->select('3_obv')
                ->select('3_oil2')
                ->select('3_otrabotana') 
                ->select('3_work_time')
                ->select('4_calendar')
                ->select('4_dob')
                ->select('4_gdis_hdyn')
                ->select('4_gdis_pzab')
                ->select('4_liquid')
                ->select('4_obv')
                ->select('4_oil2')
                ->select('4_otrabotana') 
                ->select('4_work_time')
                ->select('5_calendar')
                ->select('5_dob')
                ->select('5_gdis_hdyn')
                ->select('5_gdis_pzab')
                ->select('5_liquid')
                ->select('5_obv')
                ->select('5_oil2')
                ->select('5_otrabotana') 
                ->select('5_work_time')
                ->select('6_calendar')
                ->select('6_dob')
                ->select('6_gdis_hdyn')
                ->select('6_gdis_pzab')
                ->select('6_liquid')
                ->select('6_obv')
                ->select('6_oil2')
                ->select('6_otrabotana') 
                ->select('6_work_time')
                ->select('7_calendar')
                ->select('7_dob')
                ->select('7_gdis_hdyn')
                ->select('7_gdis_pzab')
                ->select('7_liquid')
                ->select('7_obv')
                ->select('7_oil2')
                ->select('7_otrabotana') 
                ->select('7_work_time')
                ->select('8_calendar')
                ->select('8_dob')
                ->select('8_gdis_hdyn')
                ->select('8_gdis_pzab')
                ->select('8_liquid')
                ->select('8_obv')
                ->select('8_oil2')
                ->select('8_otrabotana') 
                ->select('8_work_time')
                ->select('9_calendar')
                ->select('9_dob')
                ->select('9_gdis_hdyn')
                ->select('9_gdis_pzab')
                ->select('9_liquid')
                ->select('9_obv')
                ->select('9_oil2')
                ->select('9_otrabotana') 
                ->select('9_work_time')
                ->select('totalcalendar')
                ->select('totaldob')
                ->select('totalgdis_hdyn')
                ->select('totalgdis_pzab')
                ->select('totalliquid')
                ->select('totalobv')
                ->select('totaloil2')
                ->select('totalotrabotana') 
                ->select('totalwork_time')
                ->select('year')
                ->where('dzo_short', '=', $request->dzo)
                ->where('ngdu', '=', $request->ngdu)
                ->where('block', '=', $request->block)
                ->where('horizon', '=', $request->horizon)
                ->where('year', '=', $request->year)
                ->where('long_name', '=', $request->long_name)
                ->where('tseh', '=', $request->tseh);
                // ->where('gzu_type', '=', $request->zu);
                // ->subtotals([['dt']]);

        } 
        else {
            $builder
                ->interval('2020-01-01T00:00:00+00:00/2020-09-01T00:00:00+00:00')
                ->select('well_uwi')
                ->select('contractor');
        }
        $result = $builder->groupBy();
        $array = $result->data();
        $data['wellsList1'] =  [];
        // return $array;
        // $data['wellsList1']
        // [['Номер скаважины', 
        // 'ДЗО',
        // 'НГДУ',
        // 'ЦДНГ',
        // 'ЗУ/ГЗУ',
        // 'Горизонт',
        // 'Блок',
        // 'Дата проведения мероприятия',
        // 'Дата пропуска',
        // 'Вид мероприятия',
        // 'Подрядчик',
        // 'Жидкость после ГТМ',
        // 'Нефть после ГТМ',
        // 'Календарные дни',
        // 'Доп добыча Qн, т',
        // 'Hдин',
        // 'Pзаб',
        // 'Жидкосить',
        // '% Обв',
        // 'Нефть',
        // 'Отработанные дни',
        // 'Время работы',
        // ]];
        

        foreach ($array as $item) {
            $well = [];
            array_push($well, $item['well_uwi']);
            array_push($well, $item['dzo_short']);
            array_push($well, $item['ngdu']);
            array_push($well, $item['tseh']);
            array_push($well, $item['gzu_type']);
            array_push($well, $item['horizon']);
            array_push($well, $item['block']);
            array_push($well, date("Y.m.d", strtotime($item['dbeg'])));
            array_push($well, date("Y.m.d", strtotime($item['dend'])));
            array_push($well, $item['long_name']);
            array_push($well, $item['contractor']);
            array_push($well, round(($item['liquid_avg_before']), 1));
            array_push($well, round(($item['oil2_avg_before']), 1));
            array_push($well, $item['1_calendar']);
            array_push($well, round(($item['1_dob']), 1));
            array_push($well, round(($item['1_gdis_hdyn']), 1));
            array_push($well, round(($item['1_gdis_pzab']), 1));
            array_push($well, round(($item['1_liquid']), 1));
            array_push($well, round(($item['1_obv']), 1));
            array_push($well, round(($item['1_oil2']), 1));
            array_push($well, round(($item['1_otrabotana']), 1));
            array_push($well, round(($item['1_work_time']), 3));
            array_push($well, $item['2_calendar']);
            array_push($well, round(($item['2_dob']), 1));
            array_push($well, round(($item['2_gdis_hdyn']), 1));
            array_push($well, round(($item['2_gdis_pzab']), 1));
            array_push($well, round(($item['2_liquid']), 1));
            array_push($well, round(($item['2_obv']), 1));
            array_push($well, round(($item['2_oil2']), 1));
            array_push($well, round(($item['2_otrabotana']), 1));
            array_push($well, round(($item['2_work_time']), 3));
            array_push($well, $item['3_calendar']);
            array_push($well, round(($item['3_dob']), 1));
            array_push($well, round(($item['3_gdis_hdyn']), 1));
            array_push($well, round(($item['3_gdis_pzab']), 1));
            array_push($well, round(($item['3_liquid']), 1));
            array_push($well, round(($item['3_obv']), 1));
            array_push($well, round(($item['3_oil2']), 1));
            array_push($well, round(($item['3_otrabotana']), 1));
            array_push($well, round(($item['3_work_time']), 3));
            array_push($well, $item['4_calendar']);
            array_push($well, round(($item['4_dob']), 1));
            array_push($well, round(($item['4_gdis_hdyn']), 1));
            array_push($well, round(($item['4_gdis_pzab']), 1));
            array_push($well, round(($item['4_liquid']), 1));
            array_push($well, round(($item['4_obv']), 1));
            array_push($well, round(($item['4_oil2']), 1));
            array_push($well, round(($item['4_otrabotana']), 1));
            array_push($well, round(($item['4_work_time']), 3));
            array_push($well, $item['5_calendar']);
            array_push($well, round(($item['5_dob']), 1));
            array_push($well, round(($item['5_gdis_hdyn']), 1));
            array_push($well, round(($item['5_gdis_pzab']), 1));
            array_push($well, round(($item['5_liquid']), 1));
            array_push($well, round(($item['5_obv']), 1));
            array_push($well, round(($item['5_oil2']), 1));
            array_push($well, round(($item['5_otrabotana']), 1));
            array_push($well, round(($item['5_work_time']), 3));
            array_push($well, $item['6_calendar']);
            array_push($well, round(($item['6_dob']), 1));
            array_push($well, round(($item['6_gdis_hdyn']), 1));
            array_push($well, round(($item['6_gdis_pzab']), 1));
            array_push($well, round(($item['6_liquid']), 1));
            array_push($well, round(($item['6_obv']), 1));
            array_push($well, round(($item['6_oil2']), 1));
            array_push($well, round(($item['6_otrabotana']), 1));
            array_push($well, round(($item['6_work_time']), 3));
            array_push($well, $item['7_calendar']);
            array_push($well, round(($item['7_dob']), 1));
            array_push($well, round(($item['7_gdis_hdyn']), 1));
            array_push($well, round(($item['7_gdis_pzab']), 1));
            array_push($well, round(($item['7_liquid']), 1));
            array_push($well, round(($item['7_obv']), 1));
            array_push($well, round(($item['7_oil2']), 1));
            array_push($well, round(($item['7_otrabotana']), 1));
            array_push($well, round(($item['7_work_time']), 3));
            array_push($well, $item['8_calendar']);
            array_push($well, round(($item['8_dob']), 1));
            array_push($well, round(($item['8_gdis_hdyn']), 1));
            array_push($well, round(($item['8_gdis_pzab']), 1));
            array_push($well, round(($item['8_liquid']), 1));
            array_push($well, round(($item['8_obv']), 1));
            array_push($well, round(($item['8_oil2']), 1));
            array_push($well, round(($item['8_otrabotana']), 1));
            array_push($well, round(($item['8_work_time']), 3));
            array_push($well, $item['9_calendar']);
            array_push($well, round(($item['9_dob']), 1));
            array_push($well, round(($item['9_gdis_hdyn']), 1));
            array_push($well, round(($item['9_gdis_pzab']), 1));
            array_push($well, round(($item['9_liquid']), 1));
            array_push($well, round(($item['9_obv']), 1));
            array_push($well, round(($item['9_oil2']), 1));
            array_push($well, round(($item['9_otrabotana']), 1));
            array_push($well, round(($item['9_work_time']), 3));

            array_push($well, $item['totalcalendar']);
            array_push($well, round(($item['totaldob']), 1));
            array_push($well, round(($item['totalgdis_hdyn']), 1));
            array_push($well, round(($item['totalgdis_pzab']), 1));
            array_push($well, round(($item['totalliquid']), 1));
            array_push($well, round(($item['totalobv']), 1));
            array_push($well, round(($item['totaloil2']), 1));
            array_push($well, round(($item['9_otrabotana']), 1));
            array_push($well, round(($item['9_work_time']), 3));

            array_push($well, $item['totalcalendar']);
            array_push($well, $item['totaldob']);
            array_push($well, $item['totalgdis_hdyn']);
            array_push($well, $item['totalgdis_pzab']);
            array_push($well, $item['totalliquid']);
            array_push($well, $item['totalobv']);
            array_push($well, $item['totaloil2']);
            array_push($well, $item['totalotrabotana']);
            array_push($well, $item['totalwork_time']);
            array_push($well, $item['year']);
            array_push($data['wellsList1'], $well);
        }
    

        // $start = $month = strtotime('1');
        // $end = strtotime('12');
        // while($month < $end)
        //                      { 
        //     foreach ($array as $item) {

        //         if ($item['dt']==$month){
        //             $well = [];
        //             array_push($well, $item['well_uwi']);
        //             array_push($well, $item['dzo_short']);
        //             array_push($well, $item['ngdu']);
        //             array_push($well, $item['tseh']);
        //             array_push($well, $item['gzu_type']);
        //             array_push($well, $item['horizon']);
        //             array_push($well, $item['block']);
        //             array_push($well, date("Y.m.d", strtotime($item['dbeg'])));
        //             array_push($well, date("Y.m.d", strtotime($item['dend'])));
        //             array_push($well, $item['long_name']);
        //             array_push($well, $item['contractor']);
        //             array_push($well, $item['liquid_avg_before']);
        //             array_push($well, $item['oil2_avg_before']);
        //             array_push($well, $item['calendar']);
        //             array_push($well, $item['dob']);
        //             array_push($well, $item['gdis_hdyn']);
        //             array_push($well, $item['gdis_pzab']);
        //             array_push($well, $item['liquid']);
        //             array_push($well, $item['obv']);
        //             array_push($well, $item['oil2']);
        //             array_push($well, $item['otrabotana']);
        //             array_push($well, $item['work_time']);
        //             array_push($data['wellsList1'], $well);
        //         }
                
        //     }
        //     echo date('Y F', $month), PHP_EOL;
        //     $month = strtotime("+1 month", $month);
        // }
      
        $vdata = [
            'wellsList1' => $data['wellsList1'], 
            'excel' => $data['wellsList1']

        ];
        // echo $vdata;
        return response()->json($vdata);
    }
}