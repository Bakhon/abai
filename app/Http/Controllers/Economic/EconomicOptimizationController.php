<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\BigData\Well;
use App\Models\EcoRefsAvgMarketPrice;
use App\Models\EcoRefsCost;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsEmpPer;
use App\Models\EcoRefsMacro;
use App\Models\EcoRefsNdoRates;
use App\Models\EcoRefsRentTax;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\EcoRefsGtmValue;
use App\Models\Refs\EcoRefsScFa;
use App\Models\Refs\Org;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalStructureSource;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use SplFixedArray;

class EconomicOptimizationController extends Controller
{
    protected $druidClient;
    protected $structureService;

    const DATA_SOURCE = 'economic_scenario_MMG_Scenario_Test_v3';
    const DATA_SOURCE_WELL_CHANGES = 'economic_well_changes_scenario_MMG_Scenario_Test_v3';
    const DATA_SOURCE_DATE = '2021/01/01';

    const SCENARIO_COLUMNS = [
        "scenario_id",
        "percent_stop_cat_1",
        "percent_stop_cat_2",
        "coef_Fixed_nopayroll",
        "coef_cost_WR_payroll",
        "dollar_rate",
        "oil_price",
        "gtm_oil",
        "gtm_liquid",
        "gtm_cost",
        "gtm_operating_profit_12m",
        "gtms",
        "Barrel_ratio_export_scenario",
        'uwi_stop'
    ];

    const OPTIMIZED_COLUMNS = [
        'Revenue_total',
        'Revenue_local',
        'Revenue_export',
        'oil',
        'liquid',
        'prs',
        'uwi_count',
        'days_worked',
        'production_export',
        'production_local',
        'Fixed_noWRpayroll_expenditures',
        'Overall_expenditures',
        'Overall_expenditures_full',
        'Operating_profit',
    ];

    const OPTIMIZED_SCENARIO_COLUMNS = [
        'Overall_expenditures',
        'Overall_expenditures_full',
        'Operating_profit',
    ];

    const WELL_COLUMNS = [
        'Revenue_total_12m',
        'Revenue_local_12m',
        'Revenue_export_12m',
        'oil_12m',
        'liquid_12m',
        'prs_12m',
        'days_worked_12m',
        'production_export_12m',
        'production_local_12m',
        'Fixed_noWRpayroll_expenditures_12m',
        'Operating_profit_12m',
        'Overall_expenditures_12m',
        'Overall_expenditures_full_12m',
        'Fixed_nopayroll_expenditures_12m',
        'Fixed_payroll_expenditures_12m',
    ];

    const SUFFIX_OPTIMIZE = '_optimize';
    const SUFFIX_SCENARIO = '_scenario';
    const SUFFIX_PROFITABLE = '_profitable';
    const SUFFIX_PROFITLESS_CAT_1 = '_profitless_cat_1';
    const SUFFIX_PROFITLESS_CAT_2 = '_profitless_cat_2';

    const DOLLAR_RATE_URL = 'https://www.nationalbank.kz/ru/exchangerates/ezhednevnye-oficialnye-rynochnye-kursy-valyut';

    const DOLLAR_RATE_KEY = 'USD / KZT';

    const OIL_PRICE_URL = 'https://ru.investing.com/commodities/brent-oil-historical-data';

    const OIL_KEY = 'last_last';

    const ORG_OZEN = 3;
    const ORG_KARAZANBAS = 4;
    const ORG_KAZ_GER = 5;
    const ORG_EMBA = 6;
    const ORG_MANGISTAU = 7;

    const COMPANY_OZEN = 5;
    const COMPANY_EMBA = 6;
    const COMPANY_MANGISTAU = 7;
    const COMPANY_KARAZANBAS = 8;
    const COMPANY_KAZ_GER = 9;

    const GTM_DENOMINATOR = 10000000;

    const ROUTES_LOCAL = [
        4 => 'local_ANPZ',
        5 => 'local_PNHZ',
        6 => 'local_PKOP',
        7 => 'local_KBITUM',
        11 => 'local_other',
    ];
    const ROUTES_EXPORT = [
        1 => 'export_AA',
        2 => 'export_KTK',
        3 => 'export_Samara',
        9 => 'export_Aktau',
        10 => 'export_other',
    ];

    const PREFIX_PRICE = 'price_';
    const PREFIX_BARREL_RATIO = 'Barrel_ratio_';
    const PREFIX_SALE_SHARE = 'sale_share_';
    const PREFIX_DISCOUNT = 'discount_';
    const PREFIX_TRANS_EXP = 'trans_exp_';
    const PREFIX_PRODUCTION = 'production_';
    const PREFIX_REVENUE = 'Revenue_';
    const PREFIX_MET_PAYMENTS = 'MET_payments_';
    const PREFIX_ERT_PAYMENTS = 'ERT_payments_';
    const PREFIX_ECD_PAYMENTS = 'ECD_payments_';
    const PREFIX_TRANS_EXPENDITURES = 'Trans_expenditures_';

    public function __construct(DruidClient $druidClient, StructureService $structureService)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData');

        $this->druidClient = $druidClient;

        $this->structureService = $structureService;
    }

    public function index()
    {
        return view('economic.optimization');
    }

    public function getData(Request $request): array
    {
        $org = EconomicNrsController::getOrg($request->org_id, $this->structureService);

        if (Cache::has(self::DATA_SOURCE)) {
            return json_decode(Cache::get(self::DATA_SOURCE), true);
        }

        $data = [
            'org' => $org,
            'scenarios' => $this->getScenarios(),
            'specificIndicator' => $this->getSpecificIndicatorData($org),
            'wells' => $this->getWells(),
            'dollarRate' => [
                'value' => $this->getDollarRate() ?? '0',
                'url' => self::DOLLAR_RATE_URL
            ],
            'oilPrice' => [
                'value' => $this->getOilPrice() ?? '0',
                'url' => self::OIL_PRICE_URL
            ],
            'gtms' => EcoRefsGtm::all()
        ];

        Cache::put(self::DATA_SOURCE, json_encode($data, true), now()->addWeek());

        return $data;
    }

    private function getScenarios(): array
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(EconomicNrsController::formatInterval(
                Carbon::parse(self::DATA_SOURCE_DATE),
                Carbon::parse(self::DATA_SOURCE_DATE)->addDay(),
            ));

        $columns = self::SCENARIO_COLUMNS;

        foreach (self::OPTIMIZED_COLUMNS as $column) {
            foreach (self::columnVariations($column) as $columnVariation) {
                $columns[] = $columnVariation;
            }
        }

        $data = $builder
            ->select($columns)
            ->groupBy(self::SCENARIO_COLUMNS)
            ->data();

        $scenarios = [];

        foreach ($data as $index => $item) {
            foreach ($columns as $column) {
                $scenarios[$index][$column] = $item[$column];
            }

            foreach (self::OPTIMIZED_COLUMNS as $column) {
                foreach (self::columnPairs($column) as $originalColumn => $optimizedColumn) {
                    $scenarios[$index][$originalColumn] = [
                        'original_value' => $item[$originalColumn],
                        'original_value_optimized' => $item[$optimizedColumn],
                    ];
                }
            }
        }

        return $scenarios;
    }

    private function getSpecificIndicatorData(Org $org, int $scenarioId = 6): array
    {
        $query = EcoRefsCost::query()
            ->select(
                DB::raw('AVG(variable) as avg_variable'),
                DB::raw('AVG(fix_payroll) as avg_fix_payroll'),
                DB::raw('AVG(wo) as avg_wo'),
                DB::raw('AVG(fix) as avg_fix'),
                DB::raw('AVG(gaoverheads) as avg_gaoverheads'),
                DB::raw('AVG(wr_nopayroll) as avg_wr_nopayroll'),
                DB::raw('AVG(wr_payroll) as avg_wr_payroll'),
            )
            ->whereScFa($scenarioId);

        if ($org->druid_id) {
            $companyId = self::orgCompanyMap()[$org->id];

            $query->whereCompanyId($companyId);
        }

        return $query->get()->first()->toArray();
    }

    private function getWells(): array
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE_WELL_CHANGES, Granularity::YEAR)
            ->interval(EconomicNrsController::formatInterval(
                Carbon::parse(self::DATA_SOURCE_DATE),
                Carbon::parse(self::DATA_SOURCE_DATE)->addDay(),
            ));

        $columns = [
            'uwi',
            "oil_price",
            "dollar_rate",
            'profitability_12m',
            "scenario_id",
        ];

        $builder->select($columns);

        foreach (self::WELL_COLUMNS as $column) {
            $builder->doubleSum($column);
        }

        $wells = $builder->groupBy($columns)->data();

        $uwis = [];

        foreach ($wells as &$well) {
            $uwis[$well['uwi']] = 1;
        }

        $coordinates = Well::query()
            ->whereIn('uwi', array_keys($uwis))
            ->whereNotNull('whc')
            ->with('spatialObject')
            ->get()
            ->groupBy('uwi');

        foreach ($wells as &$well) {
            $well['coordinates'] = $coordinates->get($well['uwi'])[0]['spatialObject'][0]['coord_point'] ?? null;
        }

        return $wells;
    }

    public static function getDollarRate(): ?string
    {
        try {
            libxml_use_internal_errors(TRUE);

            $dom = new \DOMDocument();

            $dom->loadHTMLFile(self::DOLLAR_RATE_URL);

            $xpath = new \DOMXpath($dom);

            $elements = $xpath->query("//table//tbody//tr");

            /** @var \DOMElement $element */
            foreach ($elements as $element) {
                $tds = $element->getElementsByTagName('td');

                /** @var \DOMElement $td */
                foreach ($tds as $index => $td) {
                    if ($td->nodeValue === self::DOLLAR_RATE_KEY) {
                        return $tds[$index + 1]->nodeValue;
                    }
                }
            }
        } catch (\Throwable $e) {

        }

        return null;
    }

    public static function getOilPrice(): ?string
    {
        try {
            libxml_use_internal_errors(TRUE);

            $res = (new Client())->get(self::OIL_PRICE_URL)->getBody()->getContents();

            $dom = new \DOMDocument();

            $dom->loadHTML($res);

            $element = $dom->getElementById(self::OIL_KEY);

            return str_replace(',', '.', $element->nodeValue);
        } catch (\Throwable $e) {
            return null;
        }
    }

    static function orgCompanyMap(): array
    {
        return [
            self::ORG_OZEN => self::COMPANY_OZEN,
            self::ORG_KARAZANBAS => self::COMPANY_KARAZANBAS,
            self::ORG_KAZ_GER => self::COMPANY_KAZ_GER,
            self::ORG_EMBA => self::COMPANY_EMBA,
            self::ORG_MANGISTAU => self::COMPANY_MANGISTAU,
        ];
    }

    static function columnVariations(string $column): array
    {
        $pairs = self::columnPairs($column);

        return array_merge(array_keys($pairs), array_values($pairs));
    }

    static function columnPairs(string $column): array
    {
        if (in_array($column, self::OPTIMIZED_SCENARIO_COLUMNS)) {
            return [
                $column => $column . self::SUFFIX_SCENARIO,
                $column . self::SUFFIX_PROFITABLE => $column . self::SUFFIX_SCENARIO . self::SUFFIX_PROFITABLE,
                $column . self::SUFFIX_PROFITLESS_CAT_1 => $column . self::SUFFIX_SCENARIO . self::SUFFIX_PROFITLESS_CAT_1,
                $column . self::SUFFIX_PROFITLESS_CAT_2 => $column . self::SUFFIX_SCENARIO . self::SUFFIX_PROFITLESS_CAT_2,
            ];
        }

        return [
            $column => $column . self::SUFFIX_OPTIMIZE,
            $column . self::SUFFIX_PROFITABLE => $column . self::SUFFIX_PROFITABLE . self::SUFFIX_OPTIMIZE,
            $column . self::SUFFIX_PROFITLESS_CAT_1 => $column . self::SUFFIX_PROFITLESS_CAT_1 . self::SUFFIX_OPTIMIZE,
            $column . self::SUFFIX_PROFITLESS_CAT_2 => $column . self::SUFFIX_PROFITLESS_CAT_2 . self::SUFFIX_OPTIMIZE,
        ];
    }

    public function getScenariosData(): array
    {
        $scenarioName = "MMG_Scenario_Test";

        $gtmLogId = 61;

        $oilPrice = 30;

        $dollarRate = 400;

        $fixedNoPayrolls = [0.5];

        $costWrPayrolls = [0.5];
        $time = microtime(true);

        $wellByDates = collect($this->getWellsForScenarios(
            $scenarioName,
            $oilPrice,
            $dollarRate,
            true
        ));

        $scenarios = $this->getOptimizedScenarios(
            $scenarioName,
            $oilPrice,
            $dollarRate,
            $fixedNoPayrolls,
            $costWrPayrolls
        );

        $gtms = $this->getGtms($gtmLogId);

        if ($gtms) {
            $wellByDates = collect($this->getWellsForScenarios(
                $scenarioName,
                $oilPrice,
                $dollarRate,
                true
            ));

            foreach ($scenarios as $scenario) {
                $this->addGtmsToScenario($scenario, $gtms, $wellByDates);
            }
        }

        dd(microtime(true) - $time, $scenarios);

        return $scenarios;
    }

    private function getOptimizedScenarios(
        string $scenarioName,
        int $oilPrice,
        int $dollarRate,
        array $fixedNoPayrolls,
        array $costWrPayrolls
    )
    {
        $wells = $this->getWellsForScenarios($scenarioName, $oilPrice, $dollarRate);

        $wellKeys = [
            "Revenue_total",
            "Revenue_local",
            "Revenue_export",
            "oil",
            "liquid",
            "prs",
            "days_worked",
            "production_export",
            "production_local",
            "Fixed_noWRpayroll_expenditures",
            "Fixed_nopayroll_expenditures",
            "Fixed_payroll_expenditures",
            "Overall_expenditures",
            "Overall_expenditures_full",
            "Operating_profit",
        ];

        $wellProfitability = [
            "profitable",
            "profitless_cat_1",
            "profitless_cat_2"
        ];

        $scenario = [
            "coef_Fixed_nopayroll" => 0,
            "coef_cost_WR_payroll" => 0,
            "percent_stop_cat_1" => 0,
            "percent_stop_cat_2" => 0,
            "stopped_wells" => [],
            "stopped_uwis" => [],
        ];

        foreach ($wellKeys as $wellKey) {
            $scenario[$wellKey] = 0;

            foreach ($wellProfitability as $profitability) {
                $scenario[$wellKey . "_" . $profitability] = 0;
            }
        }

        $wellsByProfitability = [];

        foreach ($wellsByProfitability as $profitability) {
            $wellsByProfitability[$profitability] = [];
        }

        foreach ($wells as $well) {
            $well = (array)$well;

            $wellsByProfitability[$well["profitability"]][] = $well;

            foreach ($wellKeys as $wellKey) {
                $scenario[$wellKey] += $well[$wellKey];

                $scenario[$wellKey . "_" . $well["profitability"]] += $well[$wellKey];
            }
        }

        foreach ($wellKeys as $wellKey) {
            $scenario[$wellKey . "_optimize"] = $scenario[$wellKey];

            foreach ($wellProfitability as $profitability) {
                $value = $scenario[$wellKey . "_" . $profitability];

                $scenario[$wellKey . "_" . $profitability . "_optimize"] = $value;
            }
        }

        $scenario["oil_price"] = $oilPrice;
        $scenario["dollar_rate"] = $dollarRate;

        $scenario["uwi_count"] = count($wells);
        $scenario["uwi_count_optimize"] = $scenario["uwi_count"];

        foreach ($wellProfitability as $profitability) {
            $scenario["uwi_count_$profitability"] = count($wellsByProfitability[$profitability]);

            $scenario["uwi_count_$profitability" . "_optimize"] = $scenario["uwi_count_$profitability"];
        }

        $scenarios = [$scenario];

        $stoppedOffset = 0;

        for ($stoppedPercent = 20; $stoppedPercent <= 100; $stoppedPercent += 20) {
            list($scenario, $stoppedOffset) = $this->calcOptimizedScenarios(
                $scenario,
                $stoppedPercent,
                $stoppedOffset,
                "profitless_cat_1",
                "percent_stop_cat_1",
                $wellsByProfitability["profitless_cat_1"],
                $wellKeys
            );

            $scenarios[] = $scenario;
        }

        $stoppedOffset = 0;

        for ($stoppedPercent = 10; $stoppedPercent <= 100; $stoppedPercent += 10) {
            list($scenario, $stoppedOffset) = $this->calcOptimizedScenarios(
                $scenario,
                $stoppedPercent,
                $stoppedOffset,
                "profitless_cat_2",
                "percent_stop_cat_2",
                $wellsByProfitability["profitless_cat_2"],
                $wellKeys
            );

            $scenarios[] = $scenario;
        }

        $optimizedScenarios = [];

        foreach ($scenarios as $scenario) {
            foreach ($fixedNoPayrolls as $fixedNoPayroll) {
                foreach ($costWrPayrolls as $costWrPayroll) {
                    $optimizedScenario = $this->addFixedExpendituresToScenario(
                        $scenario,
                        $fixedNoPayroll,
                        $costWrPayroll
                    );

                    unset($optimizedScenario["stopped_wells"]);

                    $optimizedScenarios[] = $optimizedScenario;
                }
            }
        }

        return $optimizedScenarios;
    }

    private function getWellsForScenarios(
        string $scenarioName,
        int $oilPrice,
        int $dollarRate,
        array $wellByDates = null
    ): array
    {
        $technicalData = $this->getTechnicalQuery($scenarioName, $wellByDates)->toSql();
        $economicData = $this->getEconomicQuery($scenarioName)->toSql();

        $productionLocal = $this->sqlRoutesProduction(false, true);
        $productionExport = $this->sqlRoutesProduction(true, true);

        $revenueLocal = $this->sqlRoutesRevenue(false, true);
        $revenueExport = $this->sqlRoutesRevenue(true, true, $dollarRate, $oilPrice);
        $revenueTotal = "($revenueLocal + $revenueExport)";

        $metPaymentsLocal = $this->sqlRoutesMetPayments(false, true);
        $metPaymentsExport = $this->sqlRoutesMetPayments(true, true, $dollarRate, $oilPrice);
        $metPayments = "($metPaymentsLocal + $metPaymentsExport)";

        $ert = EcoRefsRentTax::query()
            ->select('rate')
            ->whereScFa(1)
            ->where('world_price_beg', '<=', $oilPrice)
            ->where('world_price_end', '>', $oilPrice)
            ->firstOrFail()
            ->rate;

        $ertPayments = $this->sqlRoutesErtPayments(true, $ert, $dollarRate, $oilPrice);

        $ecd = EcoRefsAvgMarketPrice::query()
            ->select('exp_cust_duty_rate')
            ->whereScFa(1)
            ->where('avg_market_price_beg', '<=', $oilPrice)
            ->where('avg_market_price_end', '>', $oilPrice)
            ->firstOrFail()
            ->exp_cust_duty_rate;

        $ecdPayments = $this->sqlRoutesEcdPayments(true, $ecd, $dollarRate);

        $transExpendituresLocal = $this->sqlRoutesTransExpenditures(false, true);
        $transExpendituresExport = $this->sqlRoutesTransExpenditures(true, true);
        $transExpenditures = "($transExpendituresLocal + $transExpendituresExport)";

        $netBack = "$revenueTotal - ($metPayments) - ($ertPayments) - ($ecdPayments) - ($transExpenditures)";

        $barrelRatioExportScenario = $this->sqlAvgRoutesSum(
            self::ROUTES_EXPORT,
            'Barrel_ratio_'
        );

        $variableExpenditures = $this->sqlVariableExpenditures();

        $fixedPayrollExpenditures = $wellByDates ? 0 : $this->sqlFixedPayrollExpenditures();
        $fixedNoWrPayrollExpenditures = $wellByDates ? 0 : $this->sqlFixedNoWrPayrollExpenditures();
        $fixedNoPayrollExpenditures = $wellByDates ? 0 : $this->sqlFixedNoPayrollExpenditures();
        $fixedExpenditures = "($fixedNoPayrollExpenditures + $fixedNoWrPayrollExpenditures)";

        $prsExpenditures = $wellByDates ? 0 : $this->sqlPrsExpenditures();

        $productionExpenditures = "($fixedExpenditures + $variableExpenditures + $prsExpenditures)";
        $gaOverheadExpenditures = $wellByDates ? 0 : $this->sqlGaOverheadExpenditures();
        $overallExpenditures = "$gaOverheadExpenditures + $productionExpenditures";
        $overallExpendituresFull = "$overallExpenditures + $metPayments + $ecdPayments + $ertPayments + $transExpenditures";

        $operatingProfit = "$netBack - ($overallExpenditures)";
        $operatingProfitVariable = "$netBack - ($variableExpenditures)";
        $operatingProfitVariablePrs = "$operatingProfitVariable - $prsExpenditures";

        $profitability = $this->sqlProfitability(
            "SUM($operatingProfit)",
            "SUM($operatingProfitVariablePrs)"
        );

        return DB::table(DB::raw("($technicalData) as technical"))
            ->selectRaw(DB::raw("
                uwi,
                technical.company_id,
                technical.company_tbd_id,
                $barrelRatioExportScenario as Barrel_ratio_export_scenario,
                $profitability as profitability,
                SUM($revenueTotal) AS Revenue_total,
                SUM($revenueLocal) AS Revenue_local,
                SUM($revenueExport) AS Revenue_export,
                SUM(oil) AS oil,
                SUM(liquid) AS liquid,
                SUM(prs) as prs,
                SUM(days_worked) AS days_worked,
                SUM($productionExport) AS production_export,
                SUM($productionLocal) AS production_local,
                SUM($fixedNoWrPayrollExpenditures) AS Fixed_noWRpayroll_expenditures, 
                SUM($fixedNoPayrollExpenditures) AS Fixed_nopayroll_expenditures, 
                SUM($fixedPayrollExpenditures) AS Fixed_payroll_expenditures, 
                SUM($operatingProfit) AS Operating_profit,
                SUM($operatingProfitVariablePrs) AS Operating_profit_variable_prs,
                SUM($overallExpenditures) AS Overall_expenditures,
                SUM($overallExpendituresFull) AS Overall_expenditures_full,
                COUNT(*) AS date_count
            "))
            ->leftJoin(DB::raw("($economicData) as economic"), function ($join) {
                $join
                    ->on(DB::raw("technical.company_tbd_id"), '=', DB::raw("economic.company_tbd_id"))
                    ->on(DB::raw("technical.date"), '=', DB::raw("economic.date"))
                    ->on(DB::raw("technical.pes_id"), '=', DB::raw("economic.pes_id"));
            })
            ->groupByRaw(DB::raw("
                uwi, 
                Barrel_ratio_export_scenario, 
                company_id, 
                company_tbd_id
            "))
            ->oldest("Operating_profit")
            ->get()
            ->toArray();
    }

    private function calcOptimizedScenarios(
        array $scenario,
        int $stoppedPercent,
        int $stoppedOffset,
        string $profitability,
        string $profitabilityPercentKey,
        array $wells,
        array $wellKeys
    ): array
    {
        $percent = $stoppedPercent / 100;

        $stoppedWellsCount = ceil($scenario["uwi_count_$profitability"] * $percent);

        $stoppedWells = array_slice($wells, $stoppedOffset, $stoppedWellsCount - $stoppedOffset);

        $stoppedOffset = $stoppedWellsCount;

        $scenario[$profitabilityPercentKey] = $percent;

        foreach ($stoppedWells as $well) {
            $scenario["stopped_wells"][] = $well;
            $scenario["stopped_uwis"][] = $well["uwi"];

            foreach ($wellKeys as $wellKey) {
                $scenario[$wellKey . "_optimize"] -= $well[$wellKey];

                $scenario[$wellKey . "_$profitability" . "_optimize"] -= $well[$wellKey];
            }
        }

        return [$scenario, $stoppedOffset];
    }

    private function addFixedExpendituresToScenario(
        array $scenario,
        float $fixedNoPayroll,
        float $costWrPayroll
    ): array
    {
        $scenario["coef_Fixed_nopayroll"] = $fixedNoPayroll;

        $scenario["coef_cost_WR_payroll"] = $fixedNoPayroll;

        foreach ($scenario["stopped_wells"] as $well) {
            $profitability = $well["profitability"];

            $fixedExpenditures =
                $fixedNoPayroll * $well["Fixed_nopayroll_expenditures"] +
                $costWrPayroll * $well["Fixed_payroll_expenditures"];

            $scenario["Operating_profit_optimize"] -= $fixedExpenditures;
            $scenario["Operating_profit_" . "$profitability" . "_optimize"] -= $fixedExpenditures;

            $scenario["Overall_expenditures_optimize"] += $fixedExpenditures;
            $scenario["Overall_expenditures_" . "$profitability" . "_optimize"] += $fixedExpenditures;

            $scenario["Overall_expenditures_full_optimize"] += $fixedExpenditures;
            $scenario["Overall_expenditures_full_" . "$profitability" . "_optimize"] += $fixedExpenditures;
        }

        return $scenario;
    }

    private function addGtmsToScenario(
        array $scenario,
        array $gtms,
        Collection $wellByDates
    )
    {
        $scenario["gtm_oil"] = 0;

        $scenario["gtm_liquid"] = 0;

        $scenario["gtm_cost"] = 0;

        $scenario["gtm_operating_profit"] = 0;

        $scenario["gtms"] = [];

        $operatingDelta = $scenario["Operating_profit_optimize"] - $scenario["Operating_profit"];

        if ($operatingDelta <= 0) return;

        $gtmGrowth = 0;

        $date = Carbon::parse($gtms[0]->date);

        for ($month = 1; $month <= 12; $month++) {
            $date = $date
                ->setMonth($month)
                ->setDay(1);

            $well = (array)$wellByDates->firstWhere("date", $date->copy()->format("Y-m-d"));

            $well["days_worked"] = $date->daysInMonth;

            $well["oil"] = 0;

            $well["prs"] = 0;

            $well["liquid"] = 0;

            $gtmsByMonth = array_filter($gtms, function ($gtm) use ($month, $operatingDelta) {
                return Carbon::parse($gtm->date)->month === $month && $gtm->price <= $operatingDelta;
            });

            if (!$gtmsByMonth) continue;

            $gtmsByMonth = $this->getGtmsForCostLimitWithMaxGrowth($gtmsByMonth, $operatingDelta);

            $gtmGrowth += $gtms["growth"];

            $gtmOil = $gtmGrowth * $well["days_worked"];

            $well["oil"] = $gtmOil;

            $well["liquid"] = $gtmOil * 10;

            $scenario["gtms"] = $gtmsByMonth;

            $scenario["gtm_oil"] += $well["oil"];

            $scenario["gtm_liquid"] += $well["liquid"];

            $scenario["gtm_cost"] += $gtms["cost"];

            $scenario["gtm_operating_profit"] -= $gtms["cost"];

            $operatingDelta -= $gtms["cost"];
        }

        if ($operatingDelta > 0) {
            $scenario["gtm_operating_profit"] += $operatingDelta;
        }
    }

    private function getGtms(int $logId): array
    {
        $tableGtms = (new EcoRefsGtm())->getTable();

        $tableGtmValues = (new EcoRefsGtmValue())->getTable();

        return DB::table(DB::raw("$tableGtms as gtms"))
            ->leftJoin(DB::raw("$tableGtmValues as gtm_values"), function ($join) {
                $join
                    ->on(DB::raw("gtms.id"), '=', DB::raw("gtm_values.gtm_id"))
                    ->on(DB::raw("gtms.log_id"), '=', DB::raw("gtm_values.log_id"));
            })
            ->whereRaw(DB::raw("gtms.log_id = $logId"))
            ->get()
            ->toArray();
    }

    private function getGtmsForCostLimitWithMaxGrowth(
        array $gtms,
        float $costLimit
    ): array
    {
        $costLimit = (int)floor(abs($costLimit) / self::GTM_DENOMINATOR);

        $gtmsWithDuplicates = [];

        foreach ($gtms as $gtm) {
            $gtm = (array)$gtm;

            $gtm["weight"] = (int)floor($gtm["growth"]);

            $gtm["cost"] = (int)floor($gtm["price"] / self::GTM_DENOMINATOR);

            $gtm["amount_original"] = $gtm["amount"];

            if ($gtm["amount_original"] > 1) {
                $gtm["amount"] = 1;

                $gtmsWithDuplicates = array_merge(
                    $gtmsWithDuplicates,
                    array_fill(0, $gtm["amount_original"], $gtm)
                );
            } else {
                $gtmsWithDuplicates[] = $gtm;
            }
        }

        $selectedGtms = [
            "gtms" => [],
            "growth" => 0,
            "cost" => 0
        ];

        $gtmsCount = count($gtmsWithDuplicates);

        $table = new SplFixedArray($gtmsCount + 1);

        for ($j = 0; $j < $gtmsCount + 1; $j++) {
            $table[$j] = new SplFixedArray($costLimit + 1);
        }

        for ($j = 1; $j <= $gtmsCount; $j += 1) {
            $gtm = $gtmsWithDuplicates[$j - 1];

            for ($w = 1; $w <= $costLimit; $w += 1) {
                $table[$j][$w] = $gtm["cost"] > $w
                    ? $table[$j - 1][$w]
                    : max(
                        $table[$j - 1][$w],
                        $table[$j - 1][$w - $gtm["cost"]] + $gtm["weight"]
                    );
            }
        }

        $j = $gtmsCount;

        while ($j > 0) {
            if ($table[$j][$costLimit] !== $table[$j - 1][$costLimit]) {
                $gtm = $gtmsWithDuplicates[$j - 1];

                $selectedGtms["gtms"][] = $gtm;

                $selectedGtms["growth"] += $gtm["growth"];

                $selectedGtms["cost"] += $gtm["price"];

                $costLimit -= $gtm["cost"];
            }

            $j -= 1;
        }

        return $selectedGtms;
    }

    public function getEconomicQuery(string $scenarioName): Builder
    {
        $economicScFa = EcoRefsScFa::query()
            ->whereName($scenarioName)
            ->firstOrFail()
            ->id;

        $tableNdoRates = (new EcoRefsNdoRates())->getTable();

        $tableMacros = (new EcoRefsMacro())->getTable();

        $saleShares = EcoRefsEmpPer::query()
            ->selectRaw(DB::raw("
                company_id,
                date,
                {$this->sqlSumByRoute('emp_per', self::PREFIX_SALE_SHARE)}
            "))
            ->whereRaw(DB::raw("sc_fa = $economicScFa"))
            ->groupByRaw(DB::raw("company_id, date"))
            ->toSql();

        $saleSharesColumns = $this->sqlSumByRoute(
            'emp_per',
            self::PREFIX_SALE_SHARE,
            true,
            'sale_shares'
        );

        $discounts = EcoRefsDiscontCoefBar::query()
            ->selectRaw(DB::raw("
                company_id,
                date,
                {$this->sqlSumByRoute('discont', self::PREFIX_DISCOUNT)},
                {$this->sqlSumByRoute('macro', self::PREFIX_PRICE)},
                {$this->sqlSumByRoute('barr_coef', self::PREFIX_BARREL_RATIO)}
            "))
            ->whereRaw(DB::raw("sc_fa = $economicScFa"))
            ->groupByRaw(DB::raw("company_id, date"))
            ->toSql();

        $discountColumns = implode(',', [
            $this->sqlSumByRoute(
                'discont',
                self::PREFIX_DISCOUNT,
                true,
                'discounts'
            ),
            $this->sqlSumByRoute(
                'macro',
                self::PREFIX_PRICE,
                true,
                'discounts'
            ),
            $this->sqlSumByRoute(
                'barr_coef',
                self::PREFIX_BARREL_RATIO,
                true,
                'discounts'
            )
        ]);

        $transExp = EcoRefsTarifyTn::query()
            ->selectRaw(DB::raw("
                company_id,
                date,
                {$this->sqlSumByRoute('tn_rate', 'trans_exp_')}
            "))
            ->whereRaw(DB::raw("sc_fa = $economicScFa"))
            ->groupByRaw(DB::raw("company_id, date"))
            ->toSql();

        $transExpColumns = $this->sqlSumByRoute(
            'tn_rate',
            self::PREFIX_TRANS_EXP,
            true,
            'trans_exp'
        );

        $companyTbdId = $this->sqlMapCompanyTbd();

        $costs = DB::table((new EcoRefsCost())->getTable())
            ->selectRaw(DB::raw("
                company_id,
                $companyTbdId as company_tbd_id,
                date,
                variable,
                variable_processing,
                fix_noWRpayroll,
                fix_payroll,
                fix_nopayroll,
                pes_id,
                fix,
                gaoverheads,
                wr_nopayroll,
                wr_payroll,
                wo,
                amort
            "))
            ->whereRaw(DB::raw("sc_fa = $economicScFa"))
            ->toSql();

        return DB::table(DB::raw("($costs) as costs"))
            ->selectRaw(DB::raw("
                costs.company_id,
                costs.company_tbd_id,
                costs.date,
                costs.variable AS cost_variable,
                costs.variable_processing as cost_variable_processing,
                costs.fix_noWRpayroll AS cost_fix_noWRpayroll,
                costs.fix_payroll AS cost_fix_payroll,
                costs.fix_nopayroll AS cost_fix_nopayroll,
                costs.pes_id,
                costs.gaoverheads AS cost_Gaoverheads,
                costs.wr_nopayroll AS cost_WR_nopayroll,
                costs.wr_nopayroll + wr_payroll as cost_WR,
                ndo_rates.ndo_rates,
                macros.ex_rate_dol AS currency_ratio,
                $saleSharesColumns,
                $discountColumns,
                $transExpColumns
            "))
            ->leftJoin("$tableNdoRates as ndo_rates", function ($join) use ($economicScFa) {
                $join
                    ->on(DB::raw("costs.company_id"), '=', DB::raw("ndo_rates.company_id"))
                    ->whereRaw(DB::raw("ndo_rates.sc_fa = $economicScFa"));
            })
            ->leftJoin("$tableMacros as macros", function ($join) use ($economicScFa) {
                $join
                    ->on(DB::raw("costs.date"), '=', DB::raw("macros.date"))
                    ->whereRaw(DB::raw("macros.sc_fa = $economicScFa"));
            })
            ->leftJoin(DB::raw("($saleShares) as sale_shares"), function ($join) {
                $join
                    ->on(DB::raw("costs.company_id"), '=', DB::raw("sale_shares.company_id"))
                    ->on(DB::raw("costs.date"), '=', DB::raw("sale_shares.date"));
            })
            ->leftJoin(DB::raw("($discounts) as discounts"), function ($join) {
                $join
                    ->on(DB::raw("costs.company_id"), '=', DB::raw("discounts.company_id"))
                    ->on(DB::raw("costs.date"), '=', DB::raw("discounts.date"));
            })
            ->leftJoin(DB::raw("($transExp) as trans_exp"), function ($join) use ($economicScFa) {
                $join
                    ->on(DB::raw("costs.company_id"), '=', DB::raw("trans_exp.company_id"))
                    ->on(DB::raw("costs.date"), '=', DB::raw("trans_exp.date"));
            });
    }

    public function getTechnicalQuery(
        string $scenarioName,
        array $wellByDates = null
    ): Builder
    {
        $technicalSource = TechnicalStructureSource::query()
            ->whereName($scenarioName)
            ->firstOrFail()
            ->id;

        $tableCompanies = (new TechnicalStructureCompany())->getTable();
        $tableFields = (new TechnicalStructureField())->getTable();
        $tableNgdus = (new TechnicalStructureNgdu())->getTable();
        $tableCdngs = (new TechnicalStructureCdng())->getTable();
        $tableGus = (new TechnicalStructureGu())->getTable();

        $companies = DB::table(DB::raw("$tableCompanies as companies"))
            ->selectRaw(DB::raw("
                companies.id as company_id,
                companies.name as company_name,
                companies.tbd_id as company_tbd_id,
                fields.id as field_id,
                fields.name as field_name,
                ngdus.id as ngdu_id,
                ngdus.name as ngdu_name,
                cdngs.id as cdng_id,
                cdngs.name as cdng_name,
                gus.id as gu_id,
                gus.name as gu_name
            "))
            ->leftJoin("$tableFields as fields", function ($join) {
                $join->on(DB::raw("companies.id"), '=', DB::raw("fields.company_id"));
            })
            ->leftJoin("$tableNgdus as ngdus", function ($join) {
                $join->on(DB::raw("fields.id"), '=', DB::raw("ngdus.field_id"));
            })
            ->leftJoin("$tableCdngs as cdngs", function ($join) {
                $join->on(DB::raw("ngdus.id"), '=', DB::raw("cdngs.ngdu_id"));
            })
            ->leftJoin("$tableGus as gus", function ($join) {
                $join->on(DB::raw("cdngs.id"), '=', DB::raw("gus.cdng_id"));
            })
            ->toSql();

        $tableForecasts = (new TechnicalDataForecast())->getTable();

        $daysWorkedByDate = DB::table($tableForecasts)
            ->selectRaw(DB::raw("date, SUM(days_worked) as days_worked_by_date"))
            ->whereRaw(DB::raw("source_id = $technicalSource"))
            ->groupByRaw(DB::raw("date"))
            ->toSql();

        $wellsCountByDate = DB::table($tableForecasts)
            ->selectRaw(DB::raw("company_id, date, COUNT(*) as wells_count_by_company_date"))
            ->whereRaw(DB::raw("source_id = $technicalSource"))
            ->groupByRaw(DB::raw("company_id, date"))
            ->toSql();

        $oil = $this->sqlWellParam("oil", $wellByDates);
        $liquid = $this->sqlWellParam("liquid", $wellByDates);
        $daysWorked = $this->sqlWellParam("days_worked", $wellByDates);
        $prs = $this->sqlWellParam("prs", $wellByDates);

        $wellsQuery = DB::table($tableForecasts)
            ->selectRaw(DB::raw("
                well_id AS uwi,
                gu_id,
                company_id,
                pes_id,
                date,
                $oil * 1000 AS oil,
                $liquid * 1000 AS liquid,
                $daysWorked AS days_worked,
                IFNULL($prs, 0) AS prs
            "));

        $wells = $wellsQuery
            ->whereRaw(DB::raw("source_id = $technicalSource"))
            ->toSql();

        return DB::table(DB::raw("($wells) as wells"))
            ->selectRaw(DB::raw("
                wells.uwi,
                wells.date,
                wells.oil,
                wells.liquid,
                wells.days_worked,
                wells.prs,
                wells.pes_id,
                wells.company_id,
                wells.gu_id,
                companies.company_name,
                companies.company_tbd_id,
                companies.field_id,
                companies.field_name,
                companies.ngdu_id,
                companies.ngdu_name,
                companies.cdng_id,
                companies.cdng_name,
                companies.gu_name,
                days_worked_by_date.days_worked_by_date,
                wells_count_by_date.wells_count_by_company_date
            "))
            ->leftJoin(DB::raw("($companies) as companies"), function ($join) {
                $join->on(DB::raw("wells.gu_id"), '=', DB::raw("companies.gu_id"));
            })
            ->leftJoin(DB::raw("($daysWorkedByDate) as days_worked_by_date"), function ($join) {
                $join->on(DB::raw("wells.date"), '=', DB::raw("days_worked_by_date.date"));
            })
            ->leftJoin(DB::raw("($wellsCountByDate) as wells_count_by_date"), function ($join) {
                $join
                    ->on(DB::raw("wells.company_id"), '=', DB::raw("wells_count_by_date.company_id"))
                    ->on(DB::raw("wells.date"), '=', DB::raw("wells_count_by_date.date"));
            });
    }

    private function sqlMapCompanyTbd(): string
    {
        $companyMap = [
            5 => 2, // OZEN
            6 => 3, // EMBA
            7 => 2000000000004, // MANGISTAU
            8 => 5000001017, // KBM
            9 => 5000002020, // KAZGER
        ];

        $sqlQuery = "";

        foreach ($companyMap as $companyId => $tbdOrgId) {
            $sqlQuery .= "WHEN company_id = $companyId THEN $tbdOrgId ";
        }

        return "CASE $sqlQuery END";
    }

    private function sqlSumByRoute(
        string $sumKey,
        string $prefix,
        bool $isColumnNames = false,
        string $alias = null
    ): string
    {
        $routes = self::ROUTES_LOCAL + self::ROUTES_EXPORT;

        $query = "";

        foreach ($routes as $routeId => $routeName) {
            $query .= $isColumnNames
                ? "$alias.$prefix$routeName,"
                : "
                SUM(CASE 
                    WHEN route_id = $routeId 
                    THEN $sumKey
                    ELSE 0 
                END) as '$prefix$routeName',";
        }

        return substr($query, 0, -1);
    }

    private function sqlAvgRoutesSum(array $routes, string $prefix): string
    {
        $querySum = "";

        $queryCount = "";

        foreach ($routes as $routeId => $routeName) {
            $querySum .= "$prefix$routeName+";

            $queryCount .= "CASE WHEN $prefix$routeName > 0 THEN 1 ELSE 0 END +";
        }

        $querySum = substr($querySum, 0, -1);

        $queryCount = substr($queryCount, 0, -1);

        return "IFNULL(($querySum) / ($queryCount), 0)";
    }

    private function sqlRoutesProduction(bool $isExport, bool $isSum): string
    {
        $query = "";

        $production = self::PREFIX_PRODUCTION;

        $routes = $isExport ? self::ROUTES_EXPORT : self::ROUTES_LOCAL;

        foreach ($routes as $routeId => $routeName) {
            $routeProduction = $this->sqlRouteProduction($routeName);

            $query .= $isSum
                ? "$routeProduction +"
                : "$routeProduction AS $production$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteProduction(string $routeName): string
    {
        $saleShare = self::PREFIX_SALE_SHARE . $routeName;

        return "oil * $saleShare";
    }

    private function sqlRoutesRevenue(
        bool $isExport,
        bool $isSum = false,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $query = "";

        $revenue = self::PREFIX_REVENUE;

        $routes = $isExport ? self::ROUTES_EXPORT : self::ROUTES_LOCAL;

        foreach ($routes as $routeId => $routeName) {
            $routeRevenue = $isExport
                ? $this->sqlRouteRevenueExport($routeName, $dollarRate, $oilPrice)
                : $this->sqlRouteRevenueLocal($routeName);

            $query .= $isSum
                ? "$routeRevenue +"
                : "$routeRevenue AS $revenue$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteRevenueExport(
        string $routeName,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $routeProduction = $this->sqlRouteProduction($routeName);

        $discount = self::PREFIX_DISCOUNT . $routeName;

        $barrelRatio = self::PREFIX_BARREL_RATIO . $routeName;

        $price = $oilPrice ? $oilPrice : (self::PREFIX_PRICE . $routeName);

        return "($price - $discount) *
                $routeProduction * 
                $barrelRatio * 
                $dollarRate";
    }

    private function sqlRouteRevenueLocal(string $routeName): string
    {
        $price = self::PREFIX_PRICE . $routeName;

        $routeProduction = $this->sqlRouteProduction($routeName);

        return "$price * $routeProduction";
    }

    private function sqlRoutesMetPayments(
        bool $isExport,
        bool $isSum = false,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $query = "";

        $metPayments = self::PREFIX_MET_PAYMENTS;

        $routes = $isExport ? self::ROUTES_EXPORT : self::ROUTES_LOCAL;

        foreach ($routes as $routeId => $routeName) {
            $routeMetPayments = $isExport
                ? $this->sqlRouteMetPayments($routeName, true, $dollarRate, $oilPrice)
                : $this->sqlRouteMetPayments($routeName, false);

            $query .= $isSum
                ? "$routeMetPayments +"
                : "$routeMetPayments AS $metPayments$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteMetPayments(
        string $routeName,
        bool $isExport,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $revenue = $isExport
            ? $this->sqlRouteRevenueExport($routeName, $dollarRate, $oilPrice)
            : $this->sqlRouteRevenueLocal($routeName);

        return "$revenue * ndo_rates";
    }

    private function sqlRoutesErtPayments(
        bool $isSum,
        float $ert,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $query = "";

        $ertPayments = self::PREFIX_ERT_PAYMENTS;

        foreach (self::ROUTES_EXPORT as $routeId => $routeName) {
            $routeErtPayments = $this->sqlRouteErtPayments(
                $routeName,
                $ert,
                $dollarRate,
                $oilPrice
            );

            $query .= $isSum
                ? "$routeErtPayments +"
                : "$routeErtPayments AS $ertPayments$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteErtPayments(
        string $routeName,
        float $ert,
        string $dollarRate = 'currency_ratio',
        int $oilPrice = null
    ): string
    {
        $production = $this->sqlRouteProduction($routeName);

        $price = $oilPrice ? $oilPrice : (self::PREFIX_PRICE . $routeName);

        $barrelRatio = self::PREFIX_BARREL_RATIO . $routeName;

        return "$production * $price * $ert * $dollarRate * $barrelRatio";
    }

    private function sqlRoutesEcdPayments(
        bool $isSum,
        float $ecd,
        string $dollarRate = 'currency_ratio'
    ): string
    {
        $query = "";

        $ecdPayments = self::PREFIX_ECD_PAYMENTS;

        foreach (self::ROUTES_EXPORT as $routeId => $routeName) {
            $routeEcdPayments = $this->sqlRouteEcdPayments(
                $routeName,
                $ecd,
                $dollarRate
            );

            $query .= $isSum
                ? "$routeEcdPayments +"
                : "$routeEcdPayments AS $ecdPayments$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteEcdPayments(
        string $routeName,
        float $ecd,
        string $dollarRate = 'currency_ratio'
    ): string
    {
        $production = $this->sqlRouteProduction($routeName);

        return "$production * $ecd * $dollarRate";
    }

    private function sqlRoutesTransExpenditures(bool $isExport, bool $isSum): string
    {
        $query = "";

        $transExpenditures = self::PREFIX_TRANS_EXPENDITURES;

        $routes = $isExport ? self::ROUTES_EXPORT : self::ROUTES_LOCAL;

        foreach ($routes as $routeId => $routeName) {
            $routeTransExpenditures = $this->sqlRouteTransExpenditures($routeName);

            $query .= $isSum
                ? "$routeTransExpenditures +"
                : "$routeTransExpenditures AS $transExpenditures$routeName,";
        }

        return substr($query, 0, -1);
    }

    private function sqlRouteTransExpenditures(string $routeName): string
    {
        $transExp = self::PREFIX_TRANS_EXP . $routeName;

        $production = $this->sqlRouteProduction($routeName);

        return "$transExp * $production";
    }

    private function sqlVariableExpenditures(): string
    {
        return "oil * cost_variable_processing + liquid * cost_variable";
    }

    private function sqlFixedPayrollExpenditures(): string
    {
        return "cost_fix_payroll * days_worked / days_worked_by_date";
    }

    private function sqlFixedNoWrPayrollExpenditures(): string
    {
        return "cost_fix_noWRpayroll * days_worked / days_worked_by_date";
    }

    private function sqlFixedNoPayrollExpenditures(): string
    {
        return "cost_fix_nopayroll * days_worked / days_worked_by_date";
    }

    private function sqlPrsNoPayrollExpenditures(): string
    {
        return "1000 * prs * cost_WR_nopayroll";
    }

    private function sqlPrsExpenditures(): string
    {
        return "1000 * prs * cost_WR";
    }

    private function sqlGaOverheadExpenditures(): string
    {
        return "cost_Gaoverheads / wells_count_by_company_date";
    }

    private function sqlProfitability(
        string $operatingProfit = 'Operating_profit',
        string $operatingProfitVariablePrs = 'Operating_profit_variable_prs'
    ): string
    {
        return "
            CASE WHEN $operatingProfit > 0
                 THEN 'profitable'
                 WHEN $operatingProfitVariablePrs < 0 
                 THEN 'profitless_cat_1'
                 ELSE 'profitless_cat_2'
            END   
        ";
    }

    private function sqlWellParam(string $wellKey, array $wellByDates = null): string
    {
        if (!$wellByDates) {
            return $wellKey;
        }

        $query = "";

        foreach ($wellByDates as $date => $well) {
            $value = $well[$wellKey];

            $query .= "WHEN date = '$date' THEN $value";
        }

        return "CASE $query END";
    }
}
