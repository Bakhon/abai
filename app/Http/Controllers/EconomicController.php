<?php

namespace App\Http\Controllers;

use App\Http\Requests\Economic\EconomicDataRequest;
use App\Jobs\ExportEconomicDataToExcel;
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

    const DATA_SOURCE = 'economic_2020v16_test';

    const GRANULARITY_DAILY_FORMAT = 'yyyy-MM-dd';
    const GRANULARITY_MONTHLY_FORMAT = 'MM-yyyy';

    const PROFITABILITY_CAT_1 = 'profitless_cat_1';
    const PROFITABILITY_CAT_2 = 'profitless_cat_2';
    const PROFITABILITY_PROFITABLE = 'profitable';

    const STATUS_ACTIVE = 'В работе';
    const STATUS_PAUSE = 'В простое';

    const OPERATING_PROFIT_TOP_LIMIT = 10;

    const BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR = 'builder1';
    const BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS = 'builder2';
    const BUILDER_DATA_CAT_1_LAST_MONTH = 'builder3';
    const BUILDER_DATA_OPERATING_PROFIT_MONTH = 'builder4';
    const BUILDER_DATA_OPERATING_PROFIT_YEAR = 'builder5';
    const BUILDER_DATA_PRS_1_YEAR = 'builder6';
    const BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR = 'builder7';
    const BUILDER_OIL_PRODUCTION = 'builder8';
    const BUILDER_SUM_LAST_2_MONTHS = 'builder9';

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
        if (!in_array($request->org_id, auth()->user()->getOrganizationIds())) {
            abort(403);
        }

        /** @var Org $org */
        $org = Org::findOrFail($request->org_id);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $intervalYear = self::intervalYears($request->interval_start, $request->interval_end);

        $intervalMonths = self::intervalMonths($request->interval_start, $request->interval_end);

        $granularity = $request->granularity;
        $granularityFormat = self::granularityFormat($granularity);

        $builder1 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalYear)
            ->longSum("prs1")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder2 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->sum("Operating_profit")
            ->distinctCount('uwi')
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder3 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->select("uwi")
            ->sum("oil")
            ->sum("liquid")
            ->sum("Revenue_total")
            ->sum("NetBack_bf_pr_exp")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder4 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($intervalMonths)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder5 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->sum("oil")
            ->sum("liquid")
            ->sum("Operating_profit")
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder6 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalMonths)
            ->select("uwi")
            ->sum("prs1")
            ->orderBy('prs1', 'desc')
            ->where('prs1', '>', '0')
            ->where('profitability', '=', self::PROFITABILITY_CAT_1);

        $builder7 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalMonths)
            ->select("uwi")
            ->sum("Operating_profit")
            ->where('Operating_profit', '!=', '0')
            ->where('status', '=', self::STATUS_ACTIVE)
            ->orderBy('Operating_profit', 'desc');

        $builder8 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($intervalMonths)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            })
            ->select('profitability')
            ->sum('liquid')
            ->sum('bsw')
            ->sum('oil')
            ->count('uwi')
            ->where('status', '=', self::STATUS_ACTIVE);

        $builder9 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths);

        $sumKeys = [
            'Revenue_export',
            'Revenue_local',
            'Variable_expenditures',
            'Fixed_expenditures',
            'MET_payments',
            'Production_expenditures',
        ];

        foreach ($sumKeys as $sumKey) {
            $builder9->sum($sumKey);
        }

        $buildersProfitabilityCount = [];

        $statuses = [
            'profitability' => self::STATUS_ACTIVE,
            'profitability_v_prostoe' => self::STATUS_PAUSE
        ];

        foreach ($statuses as $column => $status) {
            $buildersProfitabilityCount[$status] = $this
                ->druidClient
                ->query(self::DATA_SOURCE, $granularity)
                ->interval($intervalMonths)
                ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                    $extBuilder->timeFormat($granularityFormat);
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
            self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR => $builder1,
            self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS => $builder2,
            self::BUILDER_DATA_CAT_1_LAST_MONTH => $builder3,
            self::BUILDER_DATA_OPERATING_PROFIT_MONTH => $builder4,
            self::BUILDER_DATA_OPERATING_PROFIT_YEAR => $builder5,
            self::BUILDER_DATA_PRS_1_YEAR => $builder6,
            self::BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR => $builder7,
            self::BUILDER_OIL_PRODUCTION => $builder8,
            self::BUILDER_SUM_LAST_2_MONTHS => $builder9,
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

        if ($dpz) {
            /** @var QueryBuilder $builder */
            foreach ($builders as &$builder) {
                $builder->where('dpz', '=', $dpz);
            }
        }

        $result = [];

        foreach ($builders as $key => &$builder) {
            $timeseries = [
                self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS,
                self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR,
                self::BUILDER_DATA_OPERATING_PROFIT_MONTH,
                self::BUILDER_DATA_OPERATING_PROFIT_YEAR,
                self::BUILDER_SUM_LAST_2_MONTHS
            ];

            $result[$key] = in_array($key, $timeseries)
                ? $builder->timeseries()->data()
                : $builder->groupBy()->data();
        }

        $data = [
            'cat1_month' => [[
                trans('economic_reference.well'),
                trans('economic_reference.oil_production'),
                trans('economic_reference.liquid_production'),
                'Revenue_total',
                'NetBack_bf_pr_exp',
                'Operating_profit'
            ]],
            'prs1' => [[
                trans('economic_reference.well'),
                trans('economic_reference.count_prs'),
            ]],
            'Operating_profit_month' => [[
                trans('app.date'),
                trans('economic_reference.oil_production'),
                trans('economic_reference.liquid_production'),
                'Operating_profit'
            ]]
        ];

        $data['Operating_profit_year'] = $data['Operating_profit_month'];

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

        foreach ($result[self::BUILDER_DATA_CAT_1_LAST_MONTH] as &$item) {
            $data['cat1_month'][] = [
                $item['uwi'],
                $item['oil'],
                $item['liquid'],
                $item['Revenue_total'],
                $item['NetBack_bf_pr_exp'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[self::BUILDER_DATA_OPERATING_PROFIT_MONTH] as &$item) {
            $data['Operating_profit_month'][] = [
                date('d-m-Y', strtotime($item['timestamp'])),
                $item['oil'],
                $item['liquid'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[self::BUILDER_DATA_OPERATING_PROFIT_YEAR] as &$item) {
            $data['Operating_profit_year'][] = [
                date('m-Y', strtotime($item['timestamp'])),
                $item['oil'],
                $item['liquid'],
                $item['Operating_profit']
            ];
        }

        foreach ($result[self::BUILDER_DATA_PRS_1_YEAR] as &$item) {
            $data['prs1'][] = [$item['uwi'], $item['prs1']];
        }

        $operatingProfitTopHighest = array_slice(
            $result[self::BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR],
            0,
            self::OPERATING_PROFIT_TOP_LIMIT
        );

        $operatingProfitTopLowest = array_reverse(array_slice(
            $result[self::BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR],
            -self::OPERATING_PROFIT_TOP_LIMIT,
            self::OPERATING_PROFIT_TOP_LIMIT
        ));

        $result[self::BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR] = array_merge(
            $operatingProfitTopLowest,
            $operatingProfitTopHighest
        );

        foreach ($result[self::BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR] as &$item) {
            $dataChart3['uwi'][] = $item['uwi'];

            $dataChart3['Operating_profit'][] = $item['Operating_profit'] / 1000;
        }

        foreach ($result[self::BUILDER_OIL_PRODUCTION] as &$item) {
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

        $monthsCount = count($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS]);

        $lastMonth = $result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS][$monthsCount - 1];
        $prevMonth = $result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS][$monthsCount - 2];

        $resLastMonth = [
            'Operating_profit' => [
                'data' => $data['Operating_profit_month'],
                'sum' => [
                    'value_prev' => self::moneyFormat($prevMonth["Operating_profit"]),
                    'value' => self::moneyFormat($lastMonth["Operating_profit"]),
                    'percent' => self::percentFormat($lastMonth["Operating_profit"], $prevMonth["Operating_profit"]),
                ],
            ],
            'cat1' => [
                'data' => $data['cat1_month'],
                'count' => [
                    'value_prev' => (int)$prevMonth['uwi'],
                    'value' => (int)$lastMonth['uwi'],
                    'percent' => self::percentFormat((int)$lastMonth['uwi'], (int)$prevMonth['uwi'])
                ],
            ]
        ];

        $monthsCount = count($result[self::BUILDER_SUM_LAST_2_MONTHS]);

        foreach ($sumKeys as $sumKey) {
            $lastMonth = $result[self::BUILDER_SUM_LAST_2_MONTHS][$monthsCount - 1][$sumKey];

            $prevMonth = $result[self::BUILDER_SUM_LAST_2_MONTHS][$monthsCount - 2][$sumKey];

            $resLastMonth[$sumKey] = [
                'sum' => [
                    'value' => self::moneyFormat($lastMonth),
                    'value_prev' => self::moneyFormat($prevMonth),
                    'percent' => self::percentFormat($lastMonth, $prevMonth)
                ]
            ];
        }

        return [
            'lastYear' => [
                'Operating_profit' => [
                    'data' => $data['Operating_profit_year'],
                    'sum' => [
                        'value' => self::moneyFormat($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR][0]["Operating_profit"])
                    ],
                ],
                'prs1' => [
                    'data' => $data['prs1'],
                    'count' => [
                        'value' => round($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR][0]["prs1"])
                    ]
                ]
            ],
            'lastMonth' => $resLastMonth,
            'chart1' => $dataChart1,
            'chart2' => $dataChart2,
            'chart3' => $dataChart3,
            'chart4' => $dataChart4,
            'chart5' => $dataChart5,
        ];
    }

    public function exportEconomicData(EconomicDataRequest $request)
    {
        if (!in_array($request->org_id, auth()->user()->getOrganizationIds())) {
            abort(403);
        }

        /** @var Org $org */
        $org = Org::findOrFail($request->org_id);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $params = $request->validated();

        if ($org->druid_id) {
            $params['org_id2'] = $org->druid_id;
        }

        if ($dpz) {
            $params['dpz'] = $dpz;
        }

        $job = new ExportEconomicDataToExcel($params);

        $this->dispatch($job);

        return response()->json([
            'id' => $job->getJobStatusId()
        ]);
    }

    static function percentFormat(?float $last, ?float $prev): float
    {
        $last = $last ?? 0;

        $prev = $prev ?? 0;

        if ($prev) {
            return round(($last - $prev) * 100 / $prev);
        }

        return $last ? 100 : 0;
    }

    static function granularityFormat(string $granularity): string
    {
        return $granularity === Granularity::MONTH
            ? self::GRANULARITY_MONTHLY_FORMAT
            : self::GRANULARITY_DAILY_FORMAT;
    }

    static function intervalYears(string $start = null, string $end = null, int $count = 1)
    {
        $end = Carbon::parse($end ?? now());

        $start = $start ? Carbon::parse($start) : $end->copy();

        $start->subYears($count)->setDay(1)->setMonth(1);

        return self::intervalFormat($start, $end);
    }

    static function intervalMonths(string $start = null, string $end = null, int $count = 6): string
    {
        $end = Carbon::parse($end ?? now());

        if ($start) {
            $start = Carbon::parse($start);

            $diffMonths = $start->diffInMonths($end);

            if ($diffMonths < 2) {
                $start->subMonths(2 - $diffMonths);
            }
        } else {
            $start = $end->copy()->subMonths($count)->setDay(1);
        }

        return self::intervalFormat($start, $end);
    }

    static function intervalFormat(Carbon $start, Carbon $end): string
    {
        return $start->format('Y-m-d')
            . "T00:00:00+00:00/"
            . $end->format('Y-m-d')
            . "T00:00:00+00:00";
    }

    static function profitabilityFormat(array $item): string
    {
        $bsw = round(($item['bsw'] / 1000) / ($item['uwi'] / 1000));

        $liquid = round($item['liquid'] / 1000);

        return "$liquid.$bsw";
    }

    static function moneyFormat(?float $digit): array
    {
        $digit = $digit ?? 0;

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
                trans('economic_reference.million')
            ];
        }

        return [
            number_format($digit / 1000000000, 2),
            trans('economic_reference.billion')
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
                $extractionBuilder->timeFormat(self::GRANULARITY_DAILY_FORMAT);
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
