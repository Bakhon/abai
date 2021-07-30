<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\EconomicNrsDataRequest;
use App\Jobs\ExportEconomicDataToExcel;
use App\Models\Refs\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Queries\QueryBuilder;
use Level23\Druid\Types\Granularity;

class EconomicNrsController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const INTERVAL_LAST_YEAR = '2020-01-01T00:00:00/2021-01-01T00:00:00';
    const INTERVAL_LAST_MONTH = '2020-12-01T00:00:00/2021-01-01T00:00:00';
    const INTERVAL_LAST_2_MONTHS = '2020-11-01T00:00:00/2021-01-01T00:00:00';

    const DATA_SOURCE = 'economic_2020v18_test';

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

    const BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR = 'builder1';
    const BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS = 'builder2';
    const BUILDER_SUM_OPERATING_PROFIT_TOP_LAST_YEAR = 'builder7';
    const BUILDER_OIL_PRODUCTION = 'builder8';
    const BUILDER_SUM_LAST_2_MONTHS = 'builder9';

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

        $builder1 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($intervalYear)
            ->longSum("prs1")
            ->sum("Operating_profit");

        $builder2 = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($intervalMonths)
            ->sum("Operating_profit")
            ->distinctCount('uwi');

        $buildersProfitability = [
            $builder1,
            $builder2,
        ];

        foreach ($buildersProfitability as &$builder) {
            /** @var QueryBuilder $builder */
            $builder->where($profitabilityType, '=', $profitless);
        }

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
            ->select($profitabilityType)
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
            self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR => $builder1,
            self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS => $builder2,
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
                self::BUILDER_SUM_LAST_2_MONTHS
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
            $dataWithOperatingProfitTop['uwi'][] = $item['uwi'];

            $dataWithOperatingProfitTop['Operating_profit'][] = $item['Operating_profit'] / 1000;
        }

        foreach ($result[self::BUILDER_OIL_PRODUCTION] as &$item) {
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

        $monthsCount = count($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS]);

        $lastMonth = $result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS][$monthsCount - 1];
        $prevMonth = $result[self::BUILDER_SUM_OPERATING_PROFIT_AND_COUNT_UWI_LAST_2_MONTHS][$monthsCount - 2];

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

        $monthsCount = count($result[self::BUILDER_SUM_LAST_2_MONTHS]);

        foreach ($sumKeys as $sumKey) {
            $lastMonth = $result[self::BUILDER_SUM_LAST_2_MONTHS][$monthsCount - 1][$sumKey];

            $prevMonth = $result[self::BUILDER_SUM_LAST_2_MONTHS][$monthsCount - 2][$sumKey];

            $resLastMonth[$sumKey] = [
                'sum' => [
                    'value' => self::formatMoney($lastMonth),
                    'value_prev' => self::formatMoney($prevMonth),
                    'percent' => self::calcPercent($lastMonth, $prevMonth)
                ]
            ];
        }

        return [
            'lastYear' => [
                'Operating_profit' => [
                    'sum' => [
                        'value' => self::formatMoney($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR][0]["Operating_profit"])
                    ],
                ],
                'prs1' => [
                    'count' => [
                        'value' => round($result[self::BUILDER_SUM_OPERATING_PROFIT_AND_PRS1_LAST_YEAR][0]["prs1"])
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
            ]
        ];
    }

    public function exportData(EconomicNrsDataRequest $request)
    {
        self::validateAccess($request->org_id);

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

    static function getOrg(int $orgId, StructureService $structureService): Org
    {
        $org = Org::findOrFail($orgId);

        $tbdId = $org->tbd_id
            ?? Org::query()
                ->whereParentId($org->id)
                ->whereNotNull('tbd_id')
                ->firstOrFail()
                ->tbd_id;

        $userOrgs = auth()->user()->getUserOrganizations($structureService);

        if (array_search($tbdId, array_column($userOrgs, 'id')) === false) {
            abort(403);
        }

        return $org;
    }

    static function calcPercent(?float $last, ?float $prev, int $precision = 0): float
    {
        $last = $last ?? 0;

        $prev = $prev ?? 0;

        if ($prev) {
            return round(($last - $prev) * 100 / $prev, $precision);
        }

        return $last ? 100 : 0;
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
}
