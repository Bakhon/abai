<?php

namespace App\Http\Controllers;

use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

use Illuminate\Http\Request;

class EconomicController extends Controller
{
    public function index(Request $request)
    {
        return view('economic.main');
    }


    public function getEconomicData(Request $request)
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $builder = $client->query('economic_2020v4', Granularity::YEAR);
        $builder2 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder3 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder4 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder5 = $client->query('economic_2020v4', Granularity::YEAR);
        $builder6 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder7 = $client->query('economic_2020v4', Granularity::DAY);
        $builder8 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder9 = $client->query('economic_2020v4', Granularity::YEAR);
        $builder10 = $client->query('economic_2020v4', Granularity::DAY);
        $builder11 = $client->query('economic_2020v4', Granularity::DAY);
        $builder12 = $client->query('economic_2020v4', Granularity::DAY);
        $builder13 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder14 = $client->query('economic_2020v4', Granularity::YEAR);
        $builder15 = $client->query('economic_2020v4', Granularity::MONTH);

        if ($request->has('org')) {
            $builder
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder2
                ->interval('2020-06-01T00:00:00+00:00/2028-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder3
                ->interval('2020-06-01T00:00:00+00:00/2020-07-01T00:00:00+00:00')
                ->select("uwi")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder4
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder5
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->longSum("prs1")
                ->count("*")
                ->where('profitability', '=', 'profitless_cat_1')
                ->where('org_id2', '=', $request->org)
                ->divide('prs', ['prs1', '*']);

            $builder6
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->sum("oil")
                ->sum("liquid")
                ->sum("Revenue_total")
                ->sum("NetBack_bf_pr_exp")
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder7
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->sum("oil")
                ->sum("liquid")
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder8
                ->interval('2019-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->sum("oil")
                ->sum("liquid")
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder9
                ->interval('2019-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->sum("prs1")
                ->where('org_id2', '=', $request->org)
                ->where('prs1', '>', '0')
                ->orderBy('prs1', 'desc')
                ->where('profitability', '=', 'profitless_cat_1');

            $builder10
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->select('org_id2')
                ->count('uwi')
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitable');


            $builder11
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->select('org_id2')
                ->count('uwi')
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder12
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->select('org_id2')
                ->count('uwi')
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_2');

            $builder13
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM');
                })
                ->select('profitability')
                ->select('price_export_1')
                ->select('org_id2')
                ->sum('oil')
                ->where('org_id2', '=', $request->org);

            $builder14
                ->interval('2020-07-30T00:00:00+00:00/2020-07-31T00:00:00+00:00')
                ->select("uwi")
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('Operating_profit', '!=', '0')
                ->orderBy('Operating_profit', 'desc');

            $builder15
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM');
                })
                ->select('profitability')
                ->select('price_export_1')
                ->select('org_id2')
                ->sum('liquid')
                ->where('org_id2', '=', $request->org);
        } else {
            $builder
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder2
                ->interval('2020-06-01T00:00:00+00:00/2028-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder3
                ->interval('2020-06-01T00:00:00+00:00/2020-07-01T00:00:00+00:00')
                ->select("uwi")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder4
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder5
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->sum("prs1")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder6
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->sum("oil")
                ->sum("liquid")
                ->sum("Revenue_total")
                ->sum("NetBack_bf_pr_exp")
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder7
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->sum("oil")
                ->sum("liquid")
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder8
                ->interval('2019-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->sum("oil")
                ->sum("liquid")
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder9
                ->interval('2019-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select("uwi")
                ->sum("prs1")
                ->orderBy('prs1', 'desc')
                ->where('prs1', '>', '0')
                ->where('profitability', '=', 'profitless_cat_1');

            $builder10
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->count('uwi')
                ->where('profitability', '=', 'profitable');

            $builder11
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->count('uwi')
                ->where('profitability', '=', 'profitless_cat_1');

            $builder12
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM-dd');
                })
                ->select('profitability')
                ->count('uwi')
                ->where('profitability', '=', 'profitless_cat_2');

            $builder13
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM');
                })
                ->select('profitability')
                ->sum('oil');

            $builder14
                ->interval('2020-07-30T00:00:00+00:00/2020-07-31T00:00:00+00:00')
                ->select("uwi")
                ->sum("Operating_profit")
                ->where('Operating_profit', '!=', '0')
                ->orderBy('Operating_profit', 'desc');

            $builder15
                ->interval('2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat('yyyy-MM');
                })
                ->select('profitability')
                ->sum('liquid');
        }


        $result = $builder->groupBy();
        $result2 = $builder2->groupBy();
        $result3 = $builder3->groupBy();
        $result4 = $builder4->groupBy();
        $result5 = $builder5->groupBy();
        $result6 = $builder6->groupBy();
        $result7 = $builder7->timeseries();
        $result8 = $builder8->timeseries();
        $result9 = $builder9->groupBy();
        $result10 = $builder10->groupBy();
        $result11 = $builder11->groupBy();
        $result12 = $builder12->groupBy();
        $result13 = $builder13->groupBy();
        $result14 = $builder14->groupBy();
        $result15 = $builder15->groupBy();

        $array = $result->data();
        $array2 = $result2->data();
        $array3 = $result3->data();
        $array4 = $result4->data();
        $array5 = $result5->data();
        $array6 = $result6->data();
        $array7 = $result7->data();
        $array8 = $result8->data();
        $array9 = $result9->data();
        $array10 = $result10->data();
        $array11 = $result11->data();
        $array12 = $result12->data();
        $array13 = $result13->data();
        $array14 = $result14->data();
        $array15 = $result15->data();


        $data['count'] = [];
        $data['countProfitlessCat1PrevMonth'] = [];
        $data['countProfitlessCat1Month'] = [];
        $data['wellsList'] =  [['Скважина', 'Добыча нефти', 'Добыча жидкости', 'Revenue_total', 'NetBack_bf_pr_exp', 'Operating_profit']];
        $data['OperatingProfitMonth'] =  [['Дата', 'Добыча нефти', 'Добыча жидкости', 'Operating_profit']];
        $data['OperatingProfitYear'] =  [['Дата', 'Добыча нефти', 'Добыча жидкости', 'Operating_profit']];
        $data['prs1'] =  [['Скважина', 'Количесвто ПРС']];

        $dataChart['dt'] = [];
        $dataChart['profitable'] = [];
        $dataChart['profitless_cat_1'] = [];
        $dataChart['profitless_cat_2'] = [];

        $dataChart2['dt'] = [];
        $dataChart2['profitable'] = [];
        $dataChart2['profitless_cat_1'] = [];
        $dataChart2['profitless_cat_2'] = [];

        $dataChart3['uwi'] = [];
        $dataChart3['Operating_profit'] = [];

        $dataChart4['dt'] = [];
        $dataChart4['profitable'] = [];
        $dataChart4['profitless_cat_1'] = [];
        $dataChart4['profitless_cat_2'] = [];

        foreach ($array6 as $item) {
            $well = [];
            array_push($well, $item['uwi']);
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Revenue_total']);
            array_push($well, $item['NetBack_bf_pr_exp']);
            array_push($well, $item['Operating_profit']);
            array_push($data['wellsList'], $well);
        }

        foreach ($array7 as $item) {
            $well = [];
            array_push($well, date('d-m-Y', strtotime($item['timestamp'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Operating_profit']);
            array_push($data['OperatingProfitMonth'], $well);
        }

        foreach ($array8 as $item) {
            $well = [];
            array_push($well, date('m-Y', strtotime($item['timestamp'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Operating_profit']);
            array_push($data['OperatingProfitYear'], $well);
        }

        foreach ($array9 as $item) {
            $well = [];
            array_push($well, $item['uwi']);
            array_push($well, $item['prs1']);
            array_push($data['prs1'], $well);
        }

        foreach ($array10 as $item) {
            array_push($dataChart['dt'], $item['dt']);
            array_push($dataChart['profitable'], $item['uwi']);
        }

        foreach ($array11 as $item) {
            array_push($dataChart['profitless_cat_1'], $item['uwi']);
        }

        foreach ($array12 as $item) {
            array_push($dataChart['profitless_cat_2'], $item['uwi']);
        }

        foreach ($array13 as $item) {
            if (!in_array($item['dt'], $dataChart2['dt'])) {
                array_push($dataChart2['dt'], $item['dt']);
            }
            if ($item['profitability'] == 'profitable') {
                array_push($dataChart2['profitable'], $item['oil']/1000);
            } elseif ($item['profitability'] == 'profitless_cat_2') {
                array_push($dataChart2['profitless_cat_2'], $item['oil']/1000);
            } elseif ($item['profitability'] == 'profitless_cat_1') {
                array_push($dataChart2['profitless_cat_1'], $item['oil']/1000);
            }
        }

        $reversed14 = array_reverse($array14);
        for ($i = 0; $i < 10; $i++) {
            array_push($dataChart3['uwi'], $reversed14[$i]['uwi']);
            array_push($dataChart3['Operating_profit'], $reversed14[$i]['Operating_profit']/1000);
        }

        for ($i = 0; $i < 10; $i++) {
            array_push($dataChart3['uwi'], $array14[$i]['uwi']);
            array_push($dataChart3['Operating_profit'], $array14[$i]['Operating_profit']/1000);
        }

        foreach ($array15 as $item) {
            if (!in_array($item['dt'], $dataChart4['dt'])) {
                array_push($dataChart4['dt'], $item['dt']);
            }
            if ($item['profitability'] == 'profitable') {
                array_push($dataChart4['profitable'], $item['liquid']/1000);
            } elseif ($item['profitability'] == 'profitless_cat_2') {
                array_push($dataChart4['profitless_cat_2'], $item['liquid']/1000);
            } elseif ($item['profitability'] == 'profitless_cat_1') {
                array_push($dataChart4['profitless_cat_1'], $item['liquid']/1000);
            }
        }

        $averageProfitlessCat1Month = count($array4);
        $averageProfitlessCat1PrevMonth = count($array3);


        $yearIndex = count($array) - 1;
        $lastMonthIndex = count($array2) - 1;
        $prevMonthIndex = count($array2) - 2;


        $year = self::moneyFotmat($array[$yearIndex]["Operating_profit"]);
        $month = self::moneyFotmat($array2[$lastMonthIndex]["Operating_profit"]);
        $persent = ($array2[$prevMonthIndex]["Operating_profit"] - $array2[$lastMonthIndex]["Operating_profit"]) * 100 / $array2[$prevMonthIndex]["Operating_profit"];
        $persentCount = ($averageProfitlessCat1PrevMonth - $averageProfitlessCat1Month) * 100 / $averageProfitlessCat1PrevMonth;

        $vdata = [
            'year' => $year,
            'month' => $month,
            'persent' => round($persent),
            'persentCount' => round($persentCount),
            'averageProfitlessCat1MonthCount' => round($averageProfitlessCat1Month),
            'prs' => round($array5[0]["prs1"]),
            'wellsList' => $data['wellsList'],
            'OperatingProfitMonth' => $data['OperatingProfitMonth'],
            'OperatingProfitYear' => $data['OperatingProfitYear'],
            'prs1' => $data['prs1'],
            'chart1' => $dataChart,
            'chart2' => $dataChart2,
            'chart3' => $dataChart3,
            'chart4' => $dataChart4,
        ];


        return response()->json($vdata);
    }

    static function moneyFotmat($digit){
        if($digit < 0){
            $digit *= -1;
            if ($digit < 1000000) {
                $format = number_format(-1 * $digit);
            } else if ($digit < 1000000000) {
                $format = number_format(-1 * $digit / 1000000, 2) . ' млн';
            } else {
                $format = number_format(-1 * $digit / 1000000000, 2) . ' млрд';
            }
        }else{
            if ($digit < 1000000) {
                $format = number_format($digit);
            } else if ($digit < 1000000000) {
                $format = number_format($digit / 1000000, 2) . ' млн';
            } else {
                $format = number_format($digit / 1000000000, 2) . ' млрд';
            }
        }

        return $format;
    }
}
