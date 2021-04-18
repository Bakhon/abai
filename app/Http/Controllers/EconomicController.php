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

    public function getEconomicData(EconomicDataRequest $request): array
    {
        if (!in_array($request->org, auth()->user()->getOrganizationIds())) {
            abort(403);
        }

        $org = Org::findOrFail($request->org);

        $builder0 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL1)
            ->select('profitability')
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder1 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL2)
            ->select('profitability')
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder2 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL3)
            ->select("uwi")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder3 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL4)
            ->select("uwi")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder4 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL1)
            ->longSum("prs1")
            ->where('profitability', '=', 'profitless_cat_1')
            ->count("*")
            ->divide('prs', ['prs1', '*']);

        $builder5 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL4)
            ->select("uwi")
            ->sum("oil")
            ->sum("liquid")
            ->sum("Revenue_total")
            ->sum("NetBack_bf_pr_exp")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder6 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL4)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder7 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL8)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

        $builder8 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL8)
            ->select("uwi")
            ->sum("prs1")
            ->orderBy('prs1', 'desc')
            ->where('prs1', '>', '0')
            ->where('profitability', '=', 'profitless_cat_1');

        $builder9 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitable');

        $builder10 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitless_cat_1');

        $builder11 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->count('uwi')
            ->where('status', '=', 'В работе')
            ->where('profitability', '=', 'profitless_cat_2');

        $builder12 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select(['profitability', 'price_export_1'])
            ->where('status', '=', 'В работе')
            ->sum('oil');

        $builder13 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL14)
            ->select("uwi")
            ->sum("Operating_profit")
            ->where('Operating_profit', '!=', '0')
            ->where('status', '=', 'В работе')
            ->orderBy('Operating_profit', 'desc');

        $builder14 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_PIVOT)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select(['profitability', 'price_export_1'])
            ->sum('liquid')
            ->sum('bsw')
            ->count('uwi')
            ->where('status', '=', 'В работе');

        $builders = [
            $builder0,
            $builder1,
            $builder2,
            $builder3,
            $builder4,
            $builder5,
            $builder6,
            $builder7,
            $builder8,
            $builder9,
            $builder10,
            $builder11,
            $builder12,
            $builder13,
            $builder14,
        ];

        if ($org->druid_id) {
            foreach ($builders as &$builder) {
                $builder->where('org_id2', '=', $org->druid_id);
            }
        }

        if ($request->dpz) {
            foreach ($builders as &$builder) {
                $builder->where('dpz', '=', $request->dpz);
            }
        }

        $result = [];

        foreach ($builders as $index => $builder) {
            $result[$index] = in_array($index, [6, 7])
                ? $builder->timeseries()->data()
                : $builder->groupBy()->data();
        }

        $data = [
            'count' => [],
            'countProfitlessCat1PrevMonth' => [],
            'countProfitlessCat1Month' => [],
            'wellsList' => [[
                'Скважина',
                'Добыча нефти',
                'Добыча жидкости',
                'Revenue_total',
                'NetBack_bf_pr_exp',
                'Operating_profit'
            ]],
            'prs1' => [[
                'Скважина',
                'Количесвто ПРС'
            ]]
        ];

        $data['OperatingProfitMonth'] = [[
            'Дата',
            'Добыча нефти',
            'Добыча жидкости',
            'Operating_profit'
        ]];

        $data['OperatingProfitYear'] = $data['OperatingProfitMonth'];

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

        foreach ($result[5] as &$item) {
            $data['wellsList'][] = [
                $item['uwi'],
                $item['oil'],
                $item['liquid'],
                $item['Revenue_total'],
                $item['NetBack_bf_pr_exp'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[6] as &$item) {
            $data['OperatingProfitMonth'][] = [
                date('d-m-Y', strtotime($item['timestamp'])),
                $item['oil'],
                $item['liquid'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[7] as &$item) {
            $data['OperatingProfitYear'][] = [
                date('m-Y', strtotime($item['timestamp'])),
                $item['oil'],
                $item['liquid'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[8] as &$item) {
            $data['prs1'][] = [
                $item['uwi'],
                $item['prs1']
            ];
        }

        foreach ($result[9] as &$item) {
            $dataChart['dt'][] = $item['dt'];

            $dataChart['profitable'][] = $item['uwi'];
        }

        foreach ($result[10] as &$item) {
            $dataChart['profitless_cat_1'][] = $item['uwi'];
        }

        foreach ($result[11] as $item) {
            $dataChart['profitless_cat_2'][] = $item['uwi'];
        }

        foreach ($result[12] as &$item) {
            $dataChart2['dt'][] = $item['dt'];

            $oil = $item['oil'] / 1000;

            switch ($item['profitability']) {
                case 'profitable':
                    $dataChart2['profitable'][] = $oil;
                    break;
                case 'profitless_cat_2':
                    $dataChart2['profitless_cat_2'][] = $oil;
                    break;
                case 'profitless_cat_1':
                    $dataChart2['profitless_cat_1'][] = $oil;
                    break;
            }
        }

        $dataChart2['dt'] = array_unique($dataChart2['dt']);

        foreach (array_reverse($result[13]) as &$item) {
            $dataChart3['uwi'][] = $item['uwi'];

            $dataChart3['Operating_profit'][] = $item['Operating_profit'];
        }

        foreach ($result[13] as &$item) {
            $dataChart3['uwi'][] = $item['uwi'];

            $dataChart3['Operating_profit'][] = $item['Operating_profit'] / 1000;
        }

        foreach ($result[14] as &$item) {
            $dataChart4['dt'][] = $item['dt'];

            $dataChart4[$item['profitability']] = self::profitabilityFormat($item);
        }

        $dataChart4['dt'] = array_unique($dataChart4['dt']);

        $averageProfitlessCat1Month = count($result[3]);
        $averageProfitlessCat1PrevMonth = count($result[2]);


        $yearIndex = count($result[0]) - 1;
        $lastMonthIndex = count($result[1]) - 1;
        $prevMonthIndex = $lastMonthIndex - 1;


        list($year, $yearWord) = self::moneyFormat($result[0][$yearIndex]["Operating_profit"]);
        list($month, $monthWord) = self::moneyFormat($result[1][$lastMonthIndex]["Operating_profit"]);
        $percent = ($result[1][$prevMonthIndex]["Operating_profit"] - $result[1][$lastMonthIndex]["Operating_profit"]) * 100 / $result[1][$prevMonthIndex]["Operating_profit"];
        $percentCount = ($averageProfitlessCat1PrevMonth - $averageProfitlessCat1Month) * 100 / $averageProfitlessCat1PrevMonth;

        return [
            'year' => $year,
            'yearWord' => $yearWord,
            'month' => $month,
            'monthWord' => $monthWord,
            'percent' => round($percent),
            'percentCount' => round($percentCount),
            'averageProfitlessCat1MonthCount' => round($averageProfitlessCat1Month),
            'prs' => round($result[4][0]["prs1"]),
            'wellsList' => $data['wellsList'],
            'OperatingProfitMonth' => $data['OperatingProfitMonth'],
            'OperatingProfitYear' => $data['OperatingProfitYear'],
            'prs1' => $data['prs1'],
            'chart1' => $dataChart,
            'chart2' => $dataChart2,
            'chart3' => $dataChart3,
            'chart4' => $dataChart4,
        ];
    }

    static function profitabilityFormat($item): string
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
