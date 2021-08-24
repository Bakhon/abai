<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\EconomicNrsDataRequest;
use App\Jobs\ExportEconomicDataToExcel;
use App\Models\OilRate;
use App\Models\Refs\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Queries\QueryBuilder;
use Level23\Druid\Types\Granularity;

class EconomicNrsController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const DATA_SOURCE = 'economic_nrs_total_v3';

    const GRANULARITY_DAILY_FORMAT = 'yyyy-MM-dd';
    const GRANULARITY_MONTHLY_FORMAT = 'MM-yyyy';

    const PROFITABILITY_FULL = 'profitability';
    const PROFITABILITY_DIRECT = 'profitability_kbm';
    const PROFITABILITY_DIRECT_FROM_DATE = 'profitability_kbm_date';

    const PROFITABILITY_CAT_1 = 'profitless_cat_1';
    const PROFITABILITY_CAT_2 = 'profitless_cat_2';
    const PROFITABILITY_PROFITABLE = 'profitable';
    const PROFITABILITY_PROFITLESS = 'profitless';

    const STATUS_ACTIVE = 'В работе';
    const STATUS_PAUSE = 'В простое';

    const OPERATING_PROFIT_TOP_LIMIT = 10;

    const BUILDERS = [
        'sum_year_operating_profit_and_prs' => '$builderSumYearOperatingProfitAndPrs',
        'sum_month_operating_profit_and_count_uwi' => '$builderSumMonthOperatingProfitAndCountUwi',
        'sum_year_top_by_operating_profit' => '$builderSumYearTopByOperatingProfit',
        'oil_production' => '$builderOilProduction',
        'production_expenditures' => '$builderProductionExpenditures',
        'uwi_per_month' => '$builderUwiPerMonth',
    ];

    const DOLLAR_RATES_URL = 'https://www.nationalbank.kz/ru/exchangerates/ezhednevnye-oficialnye-rynochnye-kursy-valyut/report';

    public function __construct(DruidClient $druidClient, StructureService $structureService)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData', 'exportData');

        $this->druidClient = $druidClient;

        $this->structureService = $structureService;
    }

    public function index()
    {
        return view('economic.nrs');
    }

    public function getData(EconomicNrsDataRequest $request): array
    {
        $org = self::getOrg($request->org_id, $this->structureService);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $intervalYear = self::calcIntervalYears($request->interval_start, $request->interval_end);

        /** @var Carbon $intervalMonthsStart */
        /** @var Carbon $intervalMonthsEnd */
        list($intervalMonthsStart, $intervalMonthsEnd) = self::calcIntervalMonthsStartEnd(
            $request->interval_start,
            $request->interval_end
        );

        $intervalMonths = self::formatInterval($intervalMonthsStart->copy(), $intervalMonthsEnd->copy());

        $granularity = $request->granularity;
        $granularityFormat = self::granularityFormat($granularity);

        $profitabilityType = $request->profitability;
        list($profitabilities, $profitless) = self::getProfitabilities($profitabilityType);

        $builderSumYearOperatingProfitAndPrs = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalYear)
            ->longSum("prs1")
            ->sum("Operating_profit");

        $builderSumMonthOperatingProfitAndCountUwi = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->sum("Operating_profit")
            ->distinctCount('uwi');

        $buildersProfitability = [
            $builderSumYearOperatingProfitAndPrs,
            $builderSumMonthOperatingProfitAndCountUwi,
        ];

        foreach ($buildersProfitability as &$builder) {
            /** @var QueryBuilder $builder */
            $builder->where($profitabilityType, '=', $profitless);
        }

        $builderSumYearTopByOperatingProfit = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalMonths)
            ->select("uwi")
            ->sum("Operating_profit")
            ->where('Operating_profit', '!=', '0')
            ->where('status', '=', self::STATUS_ACTIVE)
            ->orderBy('Operating_profit', 'desc');

        $builderOilProduction = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($intervalMonths)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            })
            ->select($profitabilityType)
            ->sum('liquid')
            ->sum('bsw')
            ->sum('oil')
            ->count('uwi')
            ->where('status', '=', self::STATUS_ACTIVE);

        $builderUwiPerMonth = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat(self::GRANULARITY_MONTHLY_FORMAT);
            })
            ->select("uwi")
            ->sum("Operating_profit")
            ->sum("Overall_expenditures")
            ->sum("NetBack_bf_pr_exp");

        $builderProductionExpenditures = $this
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
            $builderProductionExpenditures->sum($sumKey);
        }

        $buildersProfitabilityCount = [];

        $statuses = [
            $profitabilityType => self::STATUS_ACTIVE,
            $profitabilityType . '_v_prostoe' => self::STATUS_PAUSE
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
                ->whereIn($column, $profitabilities);
        }

        $builders = [
            self::BUILDERS['sum_month_operating_profit_and_count_uwi'] => $builderSumMonthOperatingProfitAndCountUwi,
            self::BUILDERS['sum_year_operating_profit_and_prs'] => $builderSumYearOperatingProfitAndPrs,
            self::BUILDERS['sum_year_top_by_operating_profit'] => $builderSumYearTopByOperatingProfit,
            self::BUILDERS['oil_production'] => $builderOilProduction,
            self::BUILDERS['production_expenditures'] => $builderProductionExpenditures,
            self::BUILDERS['uwi_per_month'] => $builderUwiPerMonth,
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
                self::BUILDERS['sum_month_operating_profit_and_count_uwi'],
                self::BUILDERS['sum_year_operating_profit_and_prs'],
                self::BUILDERS['production_expenditures'],
            ];

            $result[$key] = in_array($key, $timeseries)
                ? $builder->timeseries()->data()
                : $builder->groupBy()->data();
        }

        $dataWithProfitability = ['dt' => []];

        foreach ($profitabilities as $profitability) {
            $dataWithProfitability[$profitability] = [];
        }

        $dataWithOilProduction = $dataWithProfitability;
        $dataWithLiquidProduction = $dataWithProfitability;
        $dataWithPausedProfitability = $dataWithProfitability;

        $dataWithOperatingProfitTop = [
            'uwi' => [],
            'Operating_profit' => []
        ];

        $operatingProfitTopHighest = array_slice(
            $result[self::BUILDERS['sum_year_top_by_operating_profit']],
            0,
            self::OPERATING_PROFIT_TOP_LIMIT
        );

        $operatingProfitTopLowest = array_reverse(array_slice(
            $result[self::BUILDERS['sum_year_top_by_operating_profit']],
            -self::OPERATING_PROFIT_TOP_LIMIT,
            self::OPERATING_PROFIT_TOP_LIMIT
        ));

        $result[self::BUILDERS['sum_year_top_by_operating_profit']] = array_merge(
            $operatingProfitTopLowest,
            $operatingProfitTopHighest
        );

        foreach ($result[self::BUILDERS['sum_year_top_by_operating_profit']] as &$item) {
            $dataWithOperatingProfitTop['uwi'][] = $item['uwi'];

            $dataWithOperatingProfitTop['Operating_profit'][] = $item['Operating_profit'] / 1000;
        }

        foreach ($result[self::BUILDERS['oil_production']] as &$item) {
            $dataWithOilProduction['dt'][$item['dt']] = 1;

            $dataWithOilProduction[$item[$profitabilityType]][] = $item['oil'] / 1000;

            $dataWithLiquidProduction[$item[$profitabilityType]][] = self::formatProfitability($item);
        }

        $dataWithOilProduction['dt'] = array_keys($dataWithOilProduction['dt']);
        $dataWithLiquidProduction['dt'] = $dataWithOilProduction['dt'];

        foreach ($result[self::STATUS_ACTIVE] as &$item) {
            $dataWithProfitability['dt'][$item['dt']] = 1;

            $dataWithProfitability[$item[$profitabilityType]][] = self::calcProfitabilityCount(
                $item,
                $granularity,
                $intervalMonthsStart,
                $intervalMonthsEnd,
            );
        }

        $dataWithProfitability['dt'] = array_keys($dataWithProfitability['dt']);

        foreach ($result[self::STATUS_PAUSE] as &$item) {
            $dataWithPausedProfitability['dt'][$item['dt']] = 1;

            $dataWithPausedProfitability[$item[$profitabilityType . '_v_prostoe']][] = self::calcProfitabilityCount(
                $item,
                $granularity,
                $intervalMonthsStart,
                $intervalMonthsEnd,
            );
        }

        $dataWithPausedProfitability['dt'] = array_keys($dataWithPausedProfitability['dt']);

        $monthsCount = count($result[self::BUILDERS['sum_month_operating_profit_and_count_uwi']]);

        $lastMonth = $result[self::BUILDERS['sum_month_operating_profit_and_count_uwi']][$monthsCount - 1];
        $prevMonth = $result[self::BUILDERS['sum_month_operating_profit_and_count_uwi']][$monthsCount - 2];

        $resLastMonth = [
            'Operating_profit' => [
                'sum' => [
                    'value_prev' => self::formatMoney($prevMonth["Operating_profit"]),
                    'value' => self::formatMoney($lastMonth["Operating_profit"]),
                    'percent' => self::calcPercent($lastMonth["Operating_profit"], $prevMonth["Operating_profit"]),
                ],
            ],
            'cat1' => [
                'count' => [
                    'value_prev' => (int)$prevMonth['uwi'],
                    'value' => (int)$lastMonth['uwi'],
                    'percent' => self::calcPercent((int)$lastMonth['uwi'], (int)$prevMonth['uwi'])
                ],
            ]
        ];

        $monthsCount = count($result[self::BUILDERS['production_expenditures']]);

        foreach ($sumKeys as $sumKey) {
            $lastMonth = $result[self::BUILDERS['production_expenditures']][$monthsCount - 1][$sumKey];

            $prevMonth = $result[self::BUILDERS['production_expenditures']][$monthsCount - 2][$sumKey];

            $resLastMonth[$sumKey] = [
                'sum' => [
                    'value' => self::formatMoney($lastMonth),
                    'value_prev' => self::formatMoney($prevMonth),
                    'percent' => self::calcPercent($lastMonth, $prevMonth)
                ]
            ];
        }

        $dataUwiPerMonth = [
            'dates' => [],
            'uwis' => []
        ];

        foreach ($result[self::BUILDERS['uwi_per_month']] as &$item) {
            $uwi = $item['uwi'];

            $date = $item['dt'];

            $dataUwiPerMonth['dates'][$date] = 1;

            $dataUwiPerMonth['uwis'][$uwi]['NetBack_bf_pr_exp'][$date] = self::formatMoney($item['NetBack_bf_pr_exp']);

            $dataUwiPerMonth['uwis'][$uwi]['Overall_expenditures'][$date] = self::formatMoney($item['Overall_expenditures']);

            $dataUwiPerMonth['uwis'][$uwi]['Operating_profit'][$date] = self::formatMoney($item['Operating_profit']);
        }

        $dataUwiPerMonth['dates'] = array_keys($dataUwiPerMonth['dates']);

        return [
            'lastYear' => [
                'Operating_profit' => [
                    'sum' => [
                        'value' => self::formatMoney($result[self::BUILDERS['sum_year_operating_profit_and_prs']][0]["Operating_profit"])
                    ],
                ],
                'prs1' => [
                    'count' => [
                        'value' => round($result[self::BUILDERS['sum_year_operating_profit_and_prs']][0]["prs1"])
                    ]
                ]
            ],
            'lastMonth' => $resLastMonth,
            'charts' => [
                'profitability' => $dataWithProfitability,
                'oilProduction' => $dataWithOilProduction,
                'operatingProfitTop' => $dataWithOperatingProfitTop,
                'liquidProduction' => $dataWithLiquidProduction,
                'pausedProfitability' => $dataWithPausedProfitability,
                'uwiPerMonth' => $dataUwiPerMonth
            ],
            'oilPrices' => self::getOilPrices($intervalMonthsStart, $intervalMonthsEnd),
            'dollarRates' => self::getDollarRates($intervalMonthsStart, $intervalMonthsEnd),
        ];
    }

    public function exportData(EconomicNrsDataRequest $request)
    {
        $org = self::getOrg($request->org_id, $this->structureService);

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

    static function getOrg(int $orgId, StructureService $structureService): Org
    {
        $org = Org::findOrFail($orgId);

        $tbdId = $org->tbd_id
            ?? Org::query()
                ->whereParentId($org->id)
                ->whereNotNull('tbd_id')
                ->firstOrFail()
                ->tbd_id;

        $userOrgs = auth()->user()->getUserAllOrganizations($structureService);

        if (array_search($tbdId, array_column($userOrgs, 'parent_id')) === false) {
            abort(403);
        }

        return $org;
    }

    static function calcPercent(?float $last, ?float $prev, int $precision = 0): float
    {
        $last = $last ?? 0;

        $prev = $prev ?? 0;

        if (!$prev) {
            return $last ? 100 : 0;
        }

        return $prev < 0
            ? round(($prev - $last) * 100 / $prev, $precision)
            : round(($last - $prev) * 100 / $prev, $precision);
    }

    static function getProfitabilities(string $profitabilityType): array
    {
        if ($profitabilityType === self::PROFITABILITY_FULL) {
            return [
                [
                    self::PROFITABILITY_PROFITABLE,
                    self::PROFITABILITY_CAT_2,
                    self::PROFITABILITY_CAT_1,
                ],
                self::PROFITABILITY_CAT_1
            ];
        }

        return [
            [
                self::PROFITABILITY_PROFITABLE,
                self::PROFITABILITY_PROFITLESS,
            ],
            self::PROFITABILITY_PROFITLESS
        ];
    }

    static function granularityFormat(string $granularity): string
    {
        return $granularity === Granularity::MONTH
            ? self::GRANULARITY_MONTHLY_FORMAT
            : self::GRANULARITY_DAILY_FORMAT;
    }

    static function formatInterval(Carbon $start, Carbon $end): string
    {
        return $start->format('Y-m-d')
            . "T00:00:00+00:00/"
            . $end->format('Y-m-d')
            . "T00:00:00+00:00";
    }

    static function calcIntervalYears(string $start = null, string $end = null, int $count = 1): string
    {
        $end = Carbon::parse($end ?? now());

        $start = $start ? Carbon::parse($start) : $end->copy();

        $start->subYears($count)->setDay(1)->setMonth(1);

        return self::formatInterval($start, $end);
    }

    static function calcIntervalMonthsStartEnd(string $start = null, string $end = null, int $count = 6): array
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

        return [$start, $end];
    }

    static function calcProfitabilityCount(
        array $profitability,
        string $granularity,
        Carbon $intervalStart,
        Carbon $intervalEnd
    ): int
    {
        if ($granularity === Granularity::DAY) {
            return $profitability['count'];
        }

        $date = Carbon::createFromFormat('m-Y', $profitability['dt']);

        $count = $profitability['count'];

        if ($date->isSameMonth($intervalStart)) {
            $diffInDays = $date->diffInDays($intervalStart);

            return $diffInDays > 0 ? round($count / $diffInDays) : $count;
        }

        if ($date->isSameMonth($intervalEnd)) {
            $diffInDays = $date->diffInDays($intervalEnd);

            return $diffInDays > 0 ? round($count / $diffInDays) : $count;
        }

        return round($count / $date->daysInMonth);
    }

    static function formatProfitability(array $item): string
    {
        $bsw = round(($item['bsw'] / 1000) / ($item['uwi'] / 1000));

        $liquid = round($item['liquid'] / 1000);

        return "$liquid.$bsw";
    }

    static function formatMoney(?float $digit): array
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

    static function getOilPrices(Carbon $intervalStart, Carbon $intervalEnd): array
    {
        return OilRate::query()
            ->select([
                'value',
                DB::raw('DATE(date) as dt'),
                DB::raw("DATE_FORMAT(date,'%m-%Y') as dt_month"),
            ])
            ->whereBetween('date', [$intervalStart, $intervalEnd])
            ->oldest('date')
            ->get()
            ->toArray();
    }

    static function getDollarRates(Carbon $intervalStart, Carbon $intervalEnd): array
    {
        $rates = [];

        $url = self::DOLLAR_RATES_URL
            . "?rates%5B%5D=5"
            . "&beginDate=" . $intervalStart->format('d.m.Y')
            . "&endDate=" . $intervalEnd->format('d.m.Y');

        try {
            libxml_use_internal_errors(TRUE);

            $dom = new \DOMDocument();

            $dom->loadHTMLFile($url);

            $xpath = new \DOMXpath($dom);

            $elements = $xpath->query("//table//tbody//tr");

            /** @var \DOMElement $element */
            foreach ($elements as $element) {
                $tds = $element->getElementsByTagName('td');

                $dt = Carbon::parse($tds[0]->nodeValue);

                $rates[] = [
                    'dt' => $dt->format('Y-m-d'),
                    'dt_month' => $dt->format('Y-m'),
                    'value' => $tds[2]->nodeValue,
                ];
            }

            return $rates;
        } catch (\Throwable $e) {
            return [];
        }
    }
}
