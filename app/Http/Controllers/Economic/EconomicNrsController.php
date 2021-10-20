<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\EconomicNrsDataRequest;
use App\Http\Requests\Economic\EconomicNrsWellsRequest;
use App\Jobs\ExportEconomicDataToExcel;
use App\Models\BigData\Well;
use App\Models\OilRate;
use App\Models\Refs\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Queries\QueryBuilder;
use Level23\Druid\Types\Granularity;

class EconomicNrsController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const DATA_SOURCE = 'economic_nrs_total_v7';

    const GRANULARITY_DAILY_FORMAT = 'yyyy-MM-dd';
    const GRANULARITY_MONTHLY_FORMAT = 'MM-yyyy';
    const GRANULARITY_YEAR_FORMAT = 'yyyy';

    const PROFITABILITY_FULL = 'profitability';
    const PROFITABILITY_DIRECT = 'profitability_kbm';
    const PROFITABILITY_DIRECT_FROM_DATE = 'profitability_kbm_date';

    const PROFITABILITY_CAT_1 = 'profitless_cat_1';
    const PROFITABILITY_CAT_2 = 'profitless_cat_2';
    const PROFITABILITY_PROFITABLE = 'profitable';
    const PROFITABILITY_PROFITLESS = 'profitless';

    const PROFITABILITY_PAUSE = '_v_prostoe';

    const STATUS_ACTIVE = 'В работе';
    const STATUS_PAUSE = 'В простое';

    const WELL_TOP_LIMIT = 10;
    const WELL_TOP_KEYS = [
        'Operating_profit',
        'oil',
        'liquid'
    ];

    const DOLLAR_RATES_URL = 'https://www.nationalbank.kz/ru/exchangerates/ezhednevnye-oficialnye-rynochnye-kursy-valyut/report';

    public function __construct(DruidClient $druidClient, StructureService $structureService)
    {
        $this->middleware('can:economic view main');

        $this->druidClient = $druidClient;

        $this->structureService = $structureService;
    }

    public function index()
    {
        return view('economic.nrs');
    }

    public function indexWells()
    {
        return view('economic.nrs_wells');
    }

    public function indexWell(Request $request)
    {
        $orgId = $request->route('org_id');

        $wellId = $request->route('well_id');

        return view('economic.nrs_well', compact('orgId', 'wellId'));
    }

    public function getData(EconomicNrsDataRequest $request): array
    {
        $org = self::getOrg($request->org_id, $this->structureService);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $excludeUwis = self::filterUwis($request->exclude_uwis);

        $intervalYear = self::calcIntervalYears($request->interval_start, $request->interval_end);

        /** @var Carbon $intervalMonthsStart */
        /** @var Carbon $intervalMonthsEnd */
        list($intervalMonthsStart, $intervalMonthsEnd) = self::calcIntervalMonthsStartEnd(
            $request->interval_start,
            $request->interval_end
        );

        $intervalMonths = self::formatInterval(
            $intervalMonthsStart->copy(),
            $intervalMonthsEnd->copy()->addDay()
        );

        $granularity = $request->granularity;
        $granularityFormat = self::granularityFormat($granularity);

        $intervalDates = self::calcIntervalDates(
            $intervalMonthsStart,
            $intervalMonthsEnd,
            $granularity,
        );

        $profitabilityType = $request->profitability;
        list($profitabilities, $profitless) = self::getProfitabilities($profitabilityType);

        return [
            'lastYear' => $this->getYearOperatingProfitAndPrs(
                $org,
                $intervalYear,
                $profitabilityType,
                $profitless,
                $dpz,
                $excludeUwis
            ),
            'lastMonth' => array_merge(
                $this->getMonthOperatingProfitAndUwiCount(
                    $org,
                    $intervalMonths,
                    $profitabilityType,
                    $profitless,
                    $dpz,
                    $excludeUwis
                ),
                $this->getMonthProductionExpenditures(
                    $org,
                    $intervalMonths,
                    $dpz,
                    $excludeUwis
                ),
            ),
            'charts' => [
                'wellTop' => $this->getWellTop(
                    $org,
                    $intervalMonths,
                    $dpz,
                    $excludeUwis
                ),
                'production' => $this->getWellProduction(
                    $org,
                    $intervalMonths,
                    $intervalDates,
                    $profitabilities,
                    $profitabilityType,
                    $granularity,
                    $granularityFormat,
                    $dpz,
                    $excludeUwis
                ),
                'profitability' => $this->getWellsCountByProfitability(
                    $org,
                    $intervalMonths,
                    $intervalMonthsStart,
                    $intervalMonthsEnd,
                    $intervalDates,
                    $profitabilities,
                    $profitabilityType,
                    $granularity,
                    $granularityFormat,
                    $dpz,
                    $excludeUwis
                ),
                'prs' => $this->getPrsCountByProfitability(
                    $org,
                    $intervalMonths,
                    $intervalDates,
                    $profitabilities,
                    $profitabilityType,
                    $granularity,
                    $granularityFormat,
                    $dpz,
                    $excludeUwis
                ),
            ],
            'oilPrices' => self::getOilPrices($intervalMonthsStart, $intervalMonthsEnd),
            'dollarRates' => self::getDollarRates($intervalMonthsStart, $intervalMonthsEnd),
        ];
    }

    public function getWells(EconomicNrsWellsRequest $request): array
    {
        $org = self::getOrg($request->org_id, $this->structureService);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $granularity = $request->granularity;
        $granularityFormat = self::granularityFormat($granularity);

        $interval = self::formatInterval(
            Carbon::parse($request->interval_start),
            Carbon::parse($request->interval_end)->addDay(),
        );

        $wellsKeys = [
            "Operating_profit",
            "Operating_profit_variable_prs",
            "Operating_profit_variable_prs_nopayrall",
            "Overall_expenditures",
            "NetBack_bf_pr_exp",
            "oil",
            "liquid",
            "Revenue_export",
            "Revenue_local",
            "Variable_expenditures",
            "Fixed_expenditures",
            "Fixed_nopayroll_expenditures",
            "Fixed_payroll_expenditures",
            "MET_payments",
            "ECD_payments",
            "ERT_payments",
            "Trans_expenditures",
            "Gaoverheads_expenditures",
            "prs1",
            "PRS_nopayroll_expenditures",
            "PRS_expenditures",
            "Revenue_total",
        ];

        $builderWells = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($interval)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            })
            ->select("uwi");

        foreach ($wellsKeys as $key) {
            $builderWells->doubleSum($key);
        }

        $dailyKeys = array_merge(
            [
                'cost_variable',
                'cost_fix_noWRpayroll',
                'cost_fix_payroll',
                'cost_fix_nopayroll',
                'cost_fix',
                'cost_Gaoverheads',
                'cost_WR_nopayroll',
                'cost_WR_payroll',
                'cost_WR',
                'cost_WO',
            ],
            self::getDailyKeys('trans_exp'),
            self::getDailyKeys('price'),
            self::getDailyKeys('Barrel_ratio'),
            self::getDailyKeys('sale_share'),
            self::getDailyKeys('discount'),
        );

        $builderDailyParams = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($interval)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            });

        foreach ($dailyKeys as $key) {
            $builderDailyParams->select($key);
        }

        if ($request->well_id) {
            $builderWells->where('uwi', '=', $request->well_id);

            $builderDailyParams->where('uwi', '=', $request->well_id);
        }

        $wells = $this
            ->createQueryForOrg($builderWells, $org, $dpz)
            ->groupBy()
            ->data();

        $dailyParams = $this
            ->createQueryForOrg($builderDailyParams, $org, $dpz)
            ->groupBy()
            ->data();

        $wellsByDates = [
            'org' => $org,
            'dates' => [],
            'uwis' => [],
        ];

        foreach ($wells as &$well) {
            $uwi = $well['uwi'];

            $date = $well['dt'];

            $wellsByDates['dates'][$date] = 1;

            foreach ($wellsKeys as $key) {
                $wellsByDates['uwis'][$uwi][$key][$date] = $well[$key];

                if (!isset($wellsByDates['uwis'][$uwi][$key]['sum'])) {
                    $wellsByDates['uwis'][$uwi][$key]['sum'] = 0;
                }

                $wellsByDates['uwis'][$uwi][$key]['sum'] += $well[$key];
            }
        }

        foreach (array_keys($wellsByDates['dates']) as $index => $date) {
            $wellsByDates['dates'][$date] = $dailyParams[$index];
        }

        return $wellsByDates;
    }

    public function getWellsMap(EconomicNrsDataRequest $request): array
    {
        $org = self::getOrg($request->org_id, $this->structureService);

        $dpz = $request->field_id
            ? $org->fields()->whereId($request->field_id)->firstOrFail()->druid_id
            : null;

        $interval = self::formatInterval(
            Carbon::parse($request->interval_start),
            Carbon::parse($request->interval_end)->addDay()
        );

        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::DAY)
            ->interval($interval)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) {
                $extBuilder->timeFormat(self::GRANULARITY_DAILY_FORMAT);
            })
            ->select('uwi')
            ->select('profitability');

        if ($org->druid_id) {
            $builder->where('org_id2', '=', $org->druid_id);
        }

        if ($dpz) {
            $builder->where('dpz', '=', $dpz);
        }

        $wells = $builder->groupBy()->data();

        $uwis = [];

        foreach ($wells as &$well) {
            $uwis[$well['uwi']] = 1;
        }

        $uwis = array_keys($uwis);

        $coordinates = Well::query()
            ->whereIn('uwi', $uwis)
            ->whereNotNull('whc')
            ->with('spatialObject')
            ->get()
            ->groupBy('uwi');

        foreach ($wells as &$well) {
            $well['coordinates'] = $coordinates->get($well['uwi'])[0]['spatialObject'][0]['coord_point'] ?? null;
        }

        return $wells;
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
        switch ($granularity) {
            case Granularity::DAY:
                return self::GRANULARITY_DAILY_FORMAT;
            case Granularity::MONTH:
                return self::GRANULARITY_MONTHLY_FORMAT;
            case Granularity::YEAR:
                return self::GRANULARITY_YEAR_FORMAT;
        }
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

        $start->setDay(1)->setMonth(1);

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

    static function calcIntervalDates(Carbon $start, Carbon $end, string $granularity): array
    {
        $period = CarbonPeriod::create($start, "1 $granularity", $end);

        $dateFormat = $granularity === Granularity::DAY ? 'Y-m-d' : 'm-Y';

        $dates = [];

        foreach ($period as $date) {
            $dates[] = $date->format($dateFormat);
        }

        return $dates;
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

    static function calcLiquid(array $well): string
    {
        $bsw = round(($well['bsw'] / 1000) / ($well['uwi'] / 1000));

        $liquid = round($well['liquid']);

        return "$liquid.$bsw";
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

    static function calcTaxCosts(array $productionExpenditures, int $monthsCount): array
    {
        $taxCosts = [
            'last' => 0,
            'prev' => 0,
        ];

        $taxKeys = [
            'MET_payments',
            'ECD_payments',
            'ERT_payments',
        ];

        foreach ($taxKeys as $taxKey) {
            $lastMonth = $productionExpenditures[$monthsCount - 1][$taxKey];

            $prevMonth = $productionExpenditures[$monthsCount - 2][$taxKey];

            $taxCosts['last'] += $lastMonth;

            $taxCosts['prev'] += $prevMonth;
        }

        return $taxCosts;
    }

    private function fillZeroValues(array &$data, array $profitabilities)
    {
        foreach ($data['dt'] as $date) {
            foreach ($profitabilities as $profitability) {
                $data[$profitability][] = $data[$profitability][$date] ?? 0;

                unset($data[$profitability][$date]);
            }
        }
    }

    static function filterUwis(?array $uwis): ?array
    {
        if (!$uwis) {
            return null;
        }

        $uwis = array_unique($uwis);

        foreach ($uwis as &$uwi) {
            $uwi = trim($uwi);
        }

        $uwis = array_filter($uwis);

        return $uwis;
    }

    static function getDailyKeys(string $prefix): array
    {
        return [
            $prefix . "_export_AA",
            $prefix . "_export_KTK",
            $prefix . "_export_Samara",
            $prefix . "_export_Aktau",
            $prefix . "_export_other",
            $prefix . "_local_ANPZ",
            $prefix . "_local_PNHZ",
            $prefix . "_local_PKOP",
            $prefix . "_local_KBITUM",
            $prefix . "_local_other",
        ];
    }

    private function createQueryForOrg(
        QueryBuilder $builder,
        Org $org,
        ?string $dpz = null,
        array $excludeUwis = null
    ): QueryBuilder
    {
        if ($org->druid_id) {
            $builder->where('org_id2', '=', $org->druid_id);
        }

        if ($dpz) {
            $builder->where('dpz', '=', $dpz);
        }

        if ($excludeUwis) {
            $builder->whereNotIn('uwi', $excludeUwis);
        }

        return $builder;
    }

    private function getYearOperatingProfitAndPrs(
        Org $org,
        string $interval,
        string $profitabilityColumn,
        string $profitabilityValue,
        ?string $dpz = null,
        array $excludeUwis = null
    ): array
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval($interval)
            ->longSum("prs1", 'prs')
            ->doubleSum("Operating_profit", 'operatingProfit')
            ->where($profitabilityColumn, '=', $profitabilityValue);

        $years = $this
            ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
            ->timeseries()
            ->data();

        $operatingProfit = 0;

        $prs = 0;

        foreach ($years as $year) {
            $operatingProfit += $year['operatingProfit'];

            $prs += $year['prs'];
        }

        return [
            'operatingProfit' => $operatingProfit,
            'prs' => $prs
        ];
    }

    private function getMonthOperatingProfitAndUwiCount(
        Org $org,
        string $interval,
        string $profitabilityColumn,
        string $profitabilityValue,
        ?string $dpz = null,
        array $excludeUwis = null
    ): array
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($interval)
            ->doubleSum("Operating_profit", 'operatingProfit')
            ->distinctCount('uwi')
            ->where($profitabilityColumn, '=', $profitabilityValue);

        $data = $this
            ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
            ->timeseries()
            ->data();

        $monthsCount = count($data);

        $lastMonth = $data[$monthsCount - 1];
        $prevMonth = $data[$monthsCount - 2];

        return [
            'operatingProfit' => [
                'last' => $lastMonth["operatingProfit"],
                'prev' => $prevMonth["operatingProfit"],
            ],
            'uwiCount' => [
                'last' => (int)$lastMonth['uwi'],
                'prev' => (int)$prevMonth['uwi'],
            ]
        ];
    }

    private function getMonthProductionExpenditures(
        Org $org,
        string $interval,
        ?string $dpz = null,
        array $excludeUwis = null
    )
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::MONTH)
            ->interval($interval);

        $productionKeys = [
            'Revenue_export',
            'Revenue_local',
            'Variable_expenditures',
            'Fixed_expenditures',
            'Production_expenditures',
            'MET_payments',
            'ECD_payments',
            'ERT_payments',
        ];

        foreach ($productionKeys as $key) {
            $builder->doubleSum($key);
        }

        $data = $this
            ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
            ->timeseries()
            ->data();

        $monthsCount = count($data);

        $lastMonth = $data[$monthsCount - 1];
        $prevMonth = $data[$monthsCount - 2];

        $productionExpenditures = [];

        foreach ($productionKeys as $key) {
            $productionExpenditures[$key] = [
                'last' => $lastMonth[$key],
                'prev' => $prevMonth[$key],
            ];
        }

        $productionExpenditures['Tax_costs'] = self::calcTaxCosts($data, $monthsCount);

        return $productionExpenditures;
    }

    private function getWellTop(
        Org $org,
        string $interval,
        ?string $dpz = null,
        array $excludeUwis = null
    )
    {
        $builders = [];

        foreach (self::WELL_TOP_KEYS as $key) {
            $builders[$key] = $this
                ->druidClient
                ->query(self::DATA_SOURCE, Granularity::YEAR)
                ->interval($interval)
                ->select('uwi')
                ->doubleSum($key)
                ->where($key, '!=', '0')
                ->where('status', '=', self::STATUS_ACTIVE)
                ->orderBy($key, 'desc');
        }

        foreach ($builders as $key => $builder) {
            $builders[$key] = $this
                ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
                ->groupBy()
                ->data();
        }

        $wellTop = [];

        foreach (self::WELL_TOP_KEYS as $key) {
            $wellTop[$key] = [
                'highest' => array_slice(
                    $builders[$key],
                    0,
                    self::WELL_TOP_LIMIT
                ),
                'lowest' => array_reverse(array_slice(
                    $builders[$key],
                    -self::WELL_TOP_LIMIT,
                    self::WELL_TOP_LIMIT
                ))
            ];
        }

        return $wellTop;
    }

    private function getWellProduction(
        Org $org,
        string $interval,
        array $intervalDates,
        array $profitabilities,
        string $profitabilityColumn,
        string $granularity,
        string $granularityFormat,
        ?string $dpz = null,
        array $excludeUwis = null
    )
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, $granularity)
            ->interval($interval)
            ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            })
            ->select($profitabilityColumn)
            ->doubleSum('liquid')
            ->doubleSum('bsw')
            ->doubleSum('oil')
            ->count('uwi')
            ->where('status', '=', self::STATUS_ACTIVE);

        $wellProduction = $this
            ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
            ->groupBy()
            ->data();

        $oilByDate = ['dt' => $intervalDates];

        foreach ($profitabilities as $profitability) {
            $oilByDate[$profitability] = [];
        }

        $liquidByDate = $oilByDate;

        foreach ($wellProduction as $well) {
            $date = $well['dt'];

            $oilByDate[$well[$profitabilityColumn]][$date] = $well['oil'];

            $liquidByDate[$well[$profitabilityColumn]][$date] = self::calcLiquid($well);
        }

        $this->fillZeroValues($oilByDate, $profitabilities);

        $this->fillZeroValues($liquidByDate, $profitabilities);

        return [
            'oil' => $oilByDate,
            'liquid' => $liquidByDate
        ];
    }

    private function getWellsCountByProfitability(
        Org $org,
        string $interval,
        Carbon $intervalStart,
        Carbon $intervalEnd,
        array $intervalDates,
        array $profitabilities,
        string $profitabilityColumn,
        string $granularity,
        string $granularityFormat,
        ?string $dpz = null,
        array $excludeUwis = null
    )
    {
        $wells = [];

        $statuses = [
            $profitabilityColumn => self::STATUS_ACTIVE,
            $profitabilityColumn . self::PROFITABILITY_PAUSE => self::STATUS_PAUSE
        ];

        foreach ($statuses as $column => $status) {
            $builder = $this
                ->druidClient
                ->query(self::DATA_SOURCE, $granularity)
                ->interval($interval)
                ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                    $extBuilder->timeFormat($granularityFormat);
                })
                ->select($column)
                ->count('count')
                ->where('status', '=', $status)
                ->whereIn($column, $profitabilities);

            $wells[$status] = $this
                ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
                ->groupBy()
                ->data();
        }

        $profitabilityByDates = ['dt' => $intervalDates];

        foreach ($profitabilities as $profitability) {
            $profitabilityByDates[$profitability] = [];
        }

        $pausedProfitabilityByDates = $profitabilityByDates;

        foreach ($wells[self::STATUS_ACTIVE] as &$well) {
            $date = $well['dt'];

            $profitabilityByDates[$well[$profitabilityColumn]][$date] = self::calcProfitabilityCount(
                $well,
                $granularity,
                $intervalStart,
                $intervalEnd,
            );
        }

        foreach ($wells[self::STATUS_PAUSE] as &$well) {
            $date = $well['dt'];

            $key = $well[$profitabilityColumn . self::PROFITABILITY_PAUSE];

            $pausedProfitabilityByDates[$key][$date] = self::calcProfitabilityCount(
                $well,
                $granularity,
                $intervalStart,
                $intervalEnd,
            );
        }

        $this->fillZeroValues($profitabilityByDates, $profitabilities);

        $this->fillZeroValues($pausedProfitabilityByDates, $profitabilities);

        return [
            'active' => $profitabilityByDates,
            'paused' => $pausedProfitabilityByDates
        ];
    }

    private function getPrsCountByProfitability(
        Org $org,
        string $interval,
        array $intervalDates,
        array $profitabilities,
        string $profitabilityColumn,
        string $granularity,
        string $granularityFormat,
        ?string $dpz = null,
        array $excludeUwis = null
    )
    {
        $wells = [];

        $statuses = [
            $profitabilityColumn => self::STATUS_ACTIVE,
            $profitabilityColumn . self::PROFITABILITY_PAUSE => self::STATUS_PAUSE
        ];

        foreach ($statuses as $column => $status) {
            $builder = $this
                ->druidClient
                ->query(self::DATA_SOURCE, $granularity)
                ->interval($interval)
                ->select('__time', 'dt', function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                    $extBuilder->timeFormat($granularityFormat);
                })
                ->select($column)
                ->sum('prs1')
                ->where('status', '=', $status)
                ->whereIn($column, $profitabilities);

            $wells[$status] = $this
                ->createQueryForOrg($builder, $org, $dpz, $excludeUwis)
                ->groupBy()
                ->data();
        }

        $prsByDates = ['dt' => $intervalDates];

        foreach ($profitabilities as $profitability) {
            $prsByDates[$profitability] = [];
        }

        $activePrsByDates = $prsByDates;
        $pausedPrsByDates = $prsByDates;

        foreach ($wells[self::STATUS_ACTIVE] as &$well) {
            $date = $well['dt'];

            $activePrsByDates[$well[$profitabilityColumn]][$date] = $well['prs1'];
        }

        foreach ($wells[self::STATUS_PAUSE] as &$well) {
            $date = $well['dt'];

            $key = $well[$profitabilityColumn . self::PROFITABILITY_PAUSE];

            $pausedPrsByDates[$key][$date] = $well['prs1'];
        }

        $this->fillZeroValues($activePrsByDates, $profitabilities);

        $this->fillZeroValues($pausedPrsByDates, $profitabilities);

        foreach ($activePrsByDates['dt'] as $index => $date) {
            foreach ($profitabilities as $profitability) {
                $active = $activePrsByDates[$profitability][$index];

                $paused = $pausedPrsByDates[$profitability][$index];

                $prsByDates[$profitability][] = $active + $paused;
            }
        }

        return [
            'active' => $activePrsByDates,
            'paused' => $pausedPrsByDates,
            'total' => $prsByDates
        ];
    }
}
