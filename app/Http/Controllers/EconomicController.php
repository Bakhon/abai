<?php

namespace App\Http\Controllers;

use App\Http\Requests\Economic\EconomicDataRequest;
use App\Models\Refs\Org;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Types\Granularity;

class EconomicController extends Controller
{
    protected $druidClient;

    const INTERVAL1 = '2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00';
    const INTERVAL2 = '2020-06-01T00:00:00+00:00/2028-08-31T00:00:00+00:00';
    const INTERVAL3 = '2020-06-01T00:00:00+00:00/2020-07-01T00:00:00+00:00';
    const INTERVAL4 = '2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00';
    const INTERVAL8 = '2019-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00';
    const INTERVAL14 = '2020-07-30T00:00:00+00:00/2020-07-31T00:00:00+00:00';

    const INTERVAL_PIVOT = '2020-01-01T00:00:00+00:00/2020-08-01T00:00:00+00:00';

    const DATA_SOURCE = 'economic_2020v16_test';

    const TIME_FORMAT = 'yyyy-MM-dd';

    public function __construct(DruidClient $druidClient)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getEconomicData');

        $this->druidClient = $druidClient;
    }

    public function index()
    {
        return view('economic.main');
    }

    public function getEconomicData(EconomicDataRequest $request)
    {
        if (!in_array($request->org, auth()->user()->getOrganizationIds())) {
            abort(403);
        }

        $org = Org::find($request->org);

        $dpz = $request->dpz;

        $builder = $this->druidClient->query(self::DATA_SOURCE, Granularity::YEAR);
        $builder2 = $this->druidClient->query(self::DATA_SOURCE, Granularity::MONTH);
        $builder3 = $this->druidClient->query(self::DATA_SOURCE, Granularity::MONTH);
        $builder4 = $this->druidClient->query(self::DATA_SOURCE, Granularity::MONTH);
        $builder5 = $this->druidClient->query(self::DATA_SOURCE, Granularity::YEAR);
        $builder6 = $this->druidClient->query(self::DATA_SOURCE, Granularity::MONTH);
        $builder7 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);
        $builder8 = $this->druidClient->query(self::DATA_SOURCE, Granularity::MONTH);
        $builder9 = $this->druidClient->query(self::DATA_SOURCE, Granularity::YEAR);
        $builder10 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);
        $builder11 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);
        $builder12 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);
        $builder13 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);
        $builder14 = $this->druidClient->query(self::DATA_SOURCE, Granularity::YEAR);
        $builder15 = $this->druidClient->query(self::DATA_SOURCE, Granularity::DAY);

        $builder
            ->interval(self::INTERVAL1)
            ->select('profitability')
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder2
            ->interval(self::INTERVAL2)
            ->select('profitability')
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder3
            ->interval(self::INTERVAL3)
            ->select("uwi")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder4
            ->interval(self::INTERVAL4)
            ->select("uwi")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder5
            ->interval(self::INTERVAL1)
            ->longSum("prs1")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder6
            ->interval(self::INTERVAL4)
            ->select("uwi")
            ->sum("oil")
            ->sum("liquid")
            ->sum("Revenue_total")
            ->sum("NetBack_bf_pr_exp")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder7
            ->interval(self::INTERVAL4)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder8
            ->interval(self::INTERVAL8)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder9
            ->interval(self::INTERVAL8)
            ->select("uwi")
            ->sum("prs1")
            ->orderBy('prs1', 'desc')
            ->where('prs1', '>', '0')
            ->where('profitability', '=', 'profitless_cat_1');

        $builder10
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitable');

        $builder11
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitless_cat_1');

        $builder12
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitless_cat_2');

        $builder13
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->where('status', '=', 'В работе')
            ->sum('oil');

        $builder14
            ->interval(self::INTERVAL14)
            ->select("uwi")
            ->sum("Operating_profit")
            ->where('Operating_profit', '!=', '0')
            ->where('status', '=', 'В работе')
            ->orderBy('Operating_profit', 'desc');

        $builder15
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->sum('liquid')
            ->sum('bsw')
            ->count('uwi')
            ->where('status', '=', 'В работе');

        if ($org->druid_id) {
            $builder
                ->where('org_id2', '=', $org->druid_id);

            $builder2
                ->where('org_id2', '=', $org->druid_id);

            $builder3
                ->where('org_id2', '=', $org->druid_id);

            $builder4
                ->where('org_id2', '=', $org->druid_id);

            $builder5
                ->count("*")
                ->where('org_id2', '=', $org->druid_id)
                ->divide('prs', ['prs1', '*']);

            $builder6
                ->where('org_id2', '=', $org->druid_id);

            $builder7
                ->where('org_id2', '=', $org->druid_id);

            $builder8
                ->where('org_id2', '=', $org->druid_id);

            $builder9
                ->where('org_id2', '=', $org->druid_id);

            $builder10
                ->select('org_id2')
                ->where('org_id2', '=', $org->druid_id);

            $builder11
                ->select('org_id2')
                ->where('org_id2', '=', $org->druid_id);

            $builder12
                ->select('org_id2')
                ->where('org_id2', '=', $org->druid_id);

            $builder13
                ->select('price_export_1')
                ->select('org_id2')
                ->sum('oil');

            $builder14
                ->where('org_id2', '=', $org->druid_id);

            $builder15
                ->select('price_export_1')
                ->select('org_id2')
                ->where('org_id2', '=', $org->druid_id);
        }

        if ($dpz) {
            $builder
                ->where('dpz', '=', $dpz);

            $builder2
                ->where('dpz', '=', $dpz);

            $builder3
                ->where('dpz', '=', $dpz);

            $builder4
                ->where('dpz', '=', $dpz);

            $builder5
                ->where('dpz', '=', $dpz);

            $builder6
                ->where('dpz', '=', $dpz);

            $builder7
                ->where('dpz', '=', $dpz);

            $builder8
                ->where('dpz', '=', $dpz);

            $builder9
                ->where('dpz', '=', $dpz);

            $builder10
                ->where('dpz', '=', $dpz);

            $builder11
                ->where('dpz', '=', $dpz);

            $builder12
                ->where('dpz', '=', $dpz);

            $builder13
                ->where('dpz', '=', $dpz);

            $builder14
                ->where('dpz', '=', $dpz);

            $builder15
                ->where('dpz', '=', $dpz);
        }

        $result = $builder->groupBy()->data();
        $result2 = $builder2->groupBy()->data();
        $result3 = $builder3->groupBy()->data();
        $result4 = $builder4->groupBy()->data();
        $result5 = $builder5->groupBy()->data();
        $result6 = $builder6->groupBy()->data();
        $result7 = $builder7->timeseries()->data();
        $result8 = $builder8->timeseries()->data();
        $result9 = $builder9->groupBy()->data();
        $result10 = $builder10->groupBy()->data();
        $result11 = $builder11->groupBy()->data();
        $result12 = $builder12->groupBy()->data();
        $result13 = $builder13->groupBy()->data();
        $result14 = $builder14->groupBy()->data();
        $result15 = $builder15->groupBy()->data();

        $data['count'] = [];
        $data['countProfitlessCat1PrevMonth'] = [];
        $data['countProfitlessCat1Month'] = [];
        $data['wellsList'] = [[
            'Скважина',
            'Добыча нефти',
            'Добыча жидкости',
            'Revenue_total',
            'NetBack_bf_pr_exp',
            'Operating_profit'
        ]];
        $data['OperatingProfitMonth'] = [[
            'Дата',
            'Добыча нефти',
            'Добыча жидкости',
            'Operating_profit'
        ]];
        $data['OperatingProfitYear'] = [[
            'Дата',
            'Добыча нефти',
            'Добыча жидкости',
            'Operating_profit'
        ]];
        $data['prs1'] = [[
            'Скважина',
            'Количесвто ПРС'
        ]];

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

        foreach ($result6 as $item) {
            $well = [];
            array_push($well, $item['uwi']);
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Revenue_total']);
            array_push($well, $item['NetBack_bf_pr_exp']);
            array_push($well, $item['Operating_profit']);
            array_push($data['wellsList'], $well);
        }

        foreach ($result7 as $item) {
            $well = [];
            array_push($well, date('d-m-Y', strtotime($item['timestamp'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Operating_profit']);
            array_push($data['OperatingProfitMonth'], $well);
        }

        foreach ($result8 as $item) {
            $well = [];
            array_push($well, date('m-Y', strtotime($item['timestamp'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['Operating_profit']);
            array_push($data['OperatingProfitYear'], $well);
        }

        foreach ($result9 as $item) {
            $well = [];
            array_push($well, $item['uwi']);
            array_push($well, $item['prs1']);
            array_push($data['prs1'], $well);
        }

        foreach ($result10 as $item) {
            array_push($dataChart['dt'], $item['dt']);
            array_push($dataChart['profitable'], $item['uwi']);
        }

        foreach ($result11 as $item) {
            array_push($dataChart['profitless_cat_1'], $item['uwi']);
        }

        foreach ($result12 as $item) {
            array_push($dataChart['profitless_cat_2'], $item['uwi']);
        }

        foreach ($result13 as $item) {
            if (!in_array($item['dt'], $dataChart2['dt'])) {
                array_push($dataChart2['dt'], $item['dt']);
            }
            if ($item['profitability'] == 'profitable') {
                array_push($dataChart2['profitable'], $item['oil'] / 1000);
            } elseif ($item['profitability'] == 'profitless_cat_2') {
                array_push($dataChart2['profitless_cat_2'], $item['oil'] / 1000);
            } elseif ($item['profitability'] == 'profitless_cat_1') {
                array_push($dataChart2['profitless_cat_1'], $item['oil'] / 1000);
            }
        }

        $reversed14 = array_reverse($result14);
        for ($i = 0; $i < 10; $i++) {
            array_push($dataChart3['uwi'], $reversed14[$i]['uwi']);
            array_push($dataChart3['Operating_profit'], $reversed14[$i]['Operating_profit'] / 1000);
        }

        for ($i = 0; $i < 10; $i++) {
            array_push($dataChart3['uwi'], $result14[$i]['uwi']);
            array_push($dataChart3['Operating_profit'], $result14[$i]['Operating_profit'] / 1000);
        }

        foreach ($result15 as $item) {
            if (!in_array($item['dt'], $dataChart4['dt'])) {
                array_push($dataChart4['dt'], $item['dt']);
            }

            array_push($dataChart4[$item['profitability']], self::profitabilityFormat($item));
        }

        $averageProfitlessCat1Month = count($result4);
        $averageProfitlessCat1PrevMonth = count($result3);


        $yearIndex = count($result) - 1;
        $lastMonthIndex = count($result2) - 1;
        $prevMonthIndex = count($result2) - 2;


        list($year, $yearWord) = self::moneyFormat($result[$yearIndex]["Operating_profit"]);
        list($month, $monthWord) = self::moneyFormat($result2[$lastMonthIndex]["Operating_profit"]);
        $percent = ($result2[$prevMonthIndex]["Operating_profit"] - $result2[$lastMonthIndex]["Operating_profit"]) * 100 / $result2[$prevMonthIndex]["Operating_profit"];
        $percentCount = ($averageProfitlessCat1PrevMonth - $averageProfitlessCat1Month) * 100 / $averageProfitlessCat1PrevMonth;

        $vdata = [
            'year' => $year,
            'yearWord' => $yearWord,
            'month' => $month,
            'monthWord' => $monthWord,
            'percent' => round($percent),
            'percentCount' => round($percentCount),
            'averageProfitlessCat1MonthCount' => round($averageProfitlessCat1Month),
            'prs' => round($result5[0]["prs1"]),
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

    static function profitabilityFormat($item)
    {
        $bsw_round = round(($item['bsw'] / 1000) / ($item['uwi'] / 1000));

        $liquid_round = round($item['liquid'] / 1000);

        return "{$liquid_round}.{$bsw_round}";
    }

    static function moneyFormat($digit): array
    {
        $digitAbs = abs($digit);

        if ($digitAbs < 1000000) {
            return [
                number_format($digit),
                ''
            ];
        }

        if ($digitAbs < 1000000000) {
            return [
                number_format($digit / 1000000, 2),
                'млн'
            ];
        }

        return [
            number_format($digit / 1000000000, 2),
            'млрд'
        ];
    }

    public function economicPivot()
    {
        return view('economic.pivot');
    }

    public function oilPivot()
    {
        return view('economic.oilpivot');
    }

    public function getEconomicPivotData()
    {

        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY);

        // Операционные убытки по НРС за последний месяц
        $builder
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select(['profitability', 'expl_type'])
            ->select(['org', 'status'])
            ->select('uwi')
            ->sum('liquid')
            ->sum('bsw')
            ->sum('Operating_profit')
            ->sum('oil');

        $result = $builder->groupBy()->data();

        return response()->json($result);
    }

    public function getOilPivotData()
    {
        $response = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::ALL)
            ->interval('2020-07-30T18:00:00+00:00/2020-07-31T18:00:00+00:00')
            ->execute();

        return response()->json($response->data());
    }
}
