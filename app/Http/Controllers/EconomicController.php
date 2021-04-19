<?php

namespace App\Http\Controllers;

use App\Http\Requests\Economic\EconomicDataRequest;
use App\Models\Refs\Org;
use Carbon\Carbon;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Queries\QueryBuilder;
use Level23\Druid\Types\Granularity;

class EconomicController extends Controller
{
    protected $druidClient;

    const INTERVAL_LAST_YEAR = '2020-01-01T00:00:00/2021-01-01T00:00:00';
    const INTERVAL_LAST_MONTH = '2020-12-01T00:00:00/2021-01-01T00:00:00';
    const INTERVAL_LAST_2_MONTHS = '2020-11-01T00:00:00/2021-01-01T00:00:00';

    const INTERVAL_PIVOT = '2020-01-01T00:00:00/2020-08-01T00:00:00';

//    const DATA_SOURCE = 'economic_2020v4';
    const DATA_SOURCE = 'economic_2020v16_test';

    const TIME_FORMAT = 'yyyy-MM-dd';

    const PROFITABILITY_CAT_1 = 'profitless_cat_1';
    const PROFITABILITY_CAT_2 = 'profitless_cat_2';
    const PROFITABILITY_PROFITABLE = 'profitable';

    const STATUS_ACTIVE = 'В работе';
    const STATUS_PAUSE = 'В простое';

    const LIMIT_TOP = 10;

    const BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR = 'BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR';
    const BUILDER_OPERATING_PROFIT_AND_UWI_LAST_2_MONTHS = 'BUILDER_OPERATING_PROFIT_LAST_2_MONTHS';

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

        $interval = $request->interval
            ? self::intervalFormat($request->interval)
            : null;

        $builder1 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL_LAST_YEAR)
            ->longSum("prs1")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder2 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL_LAST_2_MONTHS)
            ->sum("Operating_profit")
            ->distinctCount('uwi')
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder5 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL_LAST_MONTH)
            ->select("uwi")
            ->sum("oil")
            ->sum("liquid")
            ->sum("Revenue_total")
            ->sum("NetBack_bf_pr_exp")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder6 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_LAST_MONTH)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder7 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval(self::INTERVAL_LAST_MONTH)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder8 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL_LAST_MONTH)
            ->select("uwi")
            ->sum("prs1")
            ->orderBy('prs1', 'desc')
            ->where('prs1', '>', '0')
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder13 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(self::INTERVAL_LAST_YEAR)
            ->select("uwi")
            ->sum("Operating_profit")
            ->where('Operating_profit', '!=', '0')
            ->where('status', '=', self::STATUS_ACTIVE)
            ->orderBy('Operating_profit', 'desc');

        $builder14 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval(self::INTERVAL_LAST_YEAR)
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat(self::TIME_FORMAT);
            })
            ->select('profitability')
            ->sum('liquid')
            ->sum('bsw')
            ->sum('oil')
            ->count('uwi')
            ->where('status', '=', self::STATUS_ACTIVE);

        $builder16 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($interval ?? self::INTERVAL_LAST_2_MONTHS);

        $sumKeys = [
            'Revenue_export',
            'Revenue_local',
            'Variable_expenditures',
            'Fixed_expenditures',
            'MET_payments',
            'Production_expenditures',
        ];

        foreach ($sumKeys as $sumKey) {
            $builder16->sum($sumKey);
        }

        $buildersProfitabilityCount = [];

        $statuses = [
            'profitability' => self::STATUS_ACTIVE,
            'profitability_v_prostoe' => self::STATUS_PAUSE
        ];

        foreach ($statuses as $column => $status) {
            $buildersProfitabilityCount[$status] = $this
                ->druidClient
                ->query(self::DATA_SOURCE, Granularity::DAY)
                ->interval(self::INTERVAL_LAST_YEAR)
                ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                    $extractionBuilder->timeFormat(self::TIME_FORMAT);
                })
                ->select($column)
                ->count('count')
                ->where('status', '=', $status)
                ->whereIn($column, [
                    self::PROFITABILITY_PROFITABLE,
                    self::PROFITABILITY_CAT_1,
                    self::PROFITABILITY_CAT_2,
                ]);
        }


        $builders = [
            self::BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR => $builder1,
            self::BUILDER_OPERATING_PROFIT_AND_UWI_LAST_2_MONTHS => $builder2,
            5 => $builder5,
            6 => $builder6,
            7 => $builder7,
            8 => $builder8,
            13 => $builder13,
            14 => $builder14,
            16 => $builder16,
        ];

        foreach ($buildersProfitabilityCount as $key => $builder) {
            $builders[$key] = $builder;
        }

        if ($org->druid_id) {
            /** @var QueryBuilder $builder */
            foreach ($builders as &$builder) {
                $builder->where('org_id2', '=', $org->druid_id);
            }
        }

        if ($request->dpz) {
            /** @var QueryBuilder $builder */
            foreach ($builders as &$builder) {
                $builder->where('dpz', '=', $request->dpz);
            }
        }

        $result = [];

        foreach ($builders as $key => $builder) {
            $timeseries = [
                self::BUILDER_OPERATING_PROFIT_AND_UWI_LAST_2_MONTHS,
                self::BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR,
                6,
                7,
                16
            ];

            $result[$key] = in_array($key, $timeseries)
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

        $dataChart1 = [
            'dt' => [],
            self::PROFITABILITY_PROFITABLE => [],
            self::PROFITABILITY_CAT_1 => [],
            self::PROFITABILITY_CAT_2 => [],
        ];

        $dataChart2 = $dataChart1;
        $dataChart4 = $dataChart1;
        $dataChart5 = $dataChart1;

        $dataChart3 = [
            'uwi' => [],
            'Operating_profit' => []
        ];

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
            $data['prs1'][] = [$item['uwi'], $item['prs1']];
        }

        $result[13] = array_merge(
            array_reverse(array_slice($result[13], -self::LIMIT_TOP, self::LIMIT_TOP)),
            array_slice($result[13], 0, self::LIMIT_TOP)
        );

        foreach ($result[13] as &$item) {
            $dataChart3['uwi'][] = $item['uwi'];

            $dataChart3['Operating_profit'][] = $item['Operating_profit'] / 1000;
        }

        foreach ($result[14] as &$item) {
            $dataChart2['dt'][$item['dt']] = 1;

            $dataChart2[$item['profitability']][] = $item['oil'] / 1000;

            $dataChart4[$item['profitability']][] = self::profitabilityFormat($item);
        }

        $dataChart2['dt'] = array_keys($dataChart2['dt']);
        $dataChart4['dt'] = $dataChart2['dt'];

        foreach ($result[self::STATUS_ACTIVE] as &$item) {
            $dataChart1['dt'][$item['dt']] = 1;

            $dataChart1[$item['profitability']][] = $item['count'];
        }

        $dataChart1['dt'] = array_keys($dataChart1['dt']);

        foreach ($result[self::STATUS_PAUSE] as &$item) {
            $dataChart5['dt'][$item['dt']] = 1;

            $dataChart5[$item['profitability_v_prostoe']][] = $item['count'];
        }

        $dataChart5['dt'] = array_keys($dataChart5['dt']);

        list($prevMonth, $lastMonth) = $result[self::BUILDER_OPERATING_PROFIT_AND_UWI_LAST_2_MONTHS];

        $prevMonthCat1Count = (int)$prevMonth['uwi'];
        $lastMonthCat1Count = (int)$lastMonth['uwi'];

        $percent = self::percentFormat($lastMonth["Operating_profit"], $prevMonth["Operating_profit"]);
        $percentCount = self::percentFormat($lastMonthCat1Count, $prevMonthCat1Count);

        foreach ($sumKeys as $sumKey) {
            $sumKeyPercent = self::percentFormat($result[16][1][$sumKey], $result[16][0][$sumKey]);

            $result[16][1][$sumKey] = self::moneyFormat($result[16][1][$sumKey]);

            $result[16][1][$sumKey][] = $sumKeyPercent;
        }

        unset($result[16][1]['timestamp']);

        return [
            'year' => self::moneyFormat(end($result[self::BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR])["Operating_profit"]),
            'month' => self::moneyFormat($lastMonth["Operating_profit"]),
            'percent' => $percent,
            'percentCount' => $percentCount,
            'lastMonthCat1Count' => $lastMonthCat1Count,
            'prs' => round($result[self::BUILDER_OPERATING_PROFIT_AND_PRS1_LAST_YEAR][0]["prs1"]),
            'wellsList' => $data['wellsList'],
            'OperatingProfitMonth' => $data['OperatingProfitMonth'],
            'OperatingProfitYear' => $data['OperatingProfitYear'],
            'prs1' => $data['prs1'],
            'chart1' => $dataChart1,
            'chart2' => $dataChart2,
            'chart3' => $dataChart3,
            'chart4' => $dataChart4,
            'chart5' => $dataChart5,
            'sum' => $result[16][1]
        ];
    }

    static function percentFormat(float $last, float $prev): float
    {
        return round(($prev - $last) * 100 / $prev);
    }

    static function intervalFormat(array $interval): string
    {
        return Carbon::createFromFormat('d/m/Y', $interval[0])->format('Y-m-d')
            . "T00:00:00+00:00/"
            . Carbon::createFromFormat('d/m/Y', $interval[1])->format('Y-m-d')
            . "T00:00:00+00:00";
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
            ->interval(self::INTERVAL_LAST_MONTH)
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
