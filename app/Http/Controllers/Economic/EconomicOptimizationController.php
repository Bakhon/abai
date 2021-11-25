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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;

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

    public function getEconomicData()
    {
        $oilPrice = 30;
        $dollarRate = 400;

        $technicalData = $this->getTechnicalQuery()->toSql();
        $economicData = $this->getEconomicQuery()->toSql();

        $productionLocalRoutes = $this->sqlRoutesProduction(false, false);
        $productionLocal = $this->sqlRoutesProduction(false, true);
        $productionExportRoutes = $this->sqlRoutesProduction(true, false);
        $productionExport = $this->sqlRoutesProduction(true, true);

        $revenueLocalRoutes = $this->sqlRoutesRevenue(false);
        $revenueLocal = $this->sqlRoutesRevenue(false, true);
        $revenueExportRoutes = $this->sqlRoutesRevenue(true, false, $dollarRate, $oilPrice);
        $revenueExport = $this->sqlRoutesRevenue(true, true, $dollarRate, $oilPrice);
        $revenueTotal = "($revenueLocal + $revenueExport)";

        $metPaymentsLocalRoutes = $this->sqlRoutesMetPayments(false);
        $metPaymentsLocal = $this->sqlRoutesMetPayments(false, true);
        $metPaymentsExportRoutes = $this->sqlRoutesMetPayments(true, false, $dollarRate, $oilPrice);
        $metPaymentsExport = $this->sqlRoutesMetPayments(true, true, $dollarRate, $oilPrice);
        $metPayments = "($metPaymentsLocal + $metPaymentsExport)";

        $ert = EcoRefsRentTax::query()
            ->select('rate')
            ->whereScFa(1)
            ->where('world_price_beg', '<=', $oilPrice)
            ->where('world_price_end', '>', $oilPrice)
            ->firstOrFail()
            ->rate;

        $ertPaymentsRoutes = $this->sqlRoutesErtPayments(false, $ert, $dollarRate, $oilPrice);
        $ertPayments = $this->sqlRoutesErtPayments(true, $ert, $dollarRate, $oilPrice);

        $ecd = EcoRefsAvgMarketPrice::query()
            ->select('exp_cust_duty_rate')
            ->whereScFa(1)
            ->where('avg_market_price_beg', '<=', $oilPrice)
            ->where('avg_market_price_end', '>', $oilPrice)
            ->firstOrFail()
            ->exp_cust_duty_rate;

        $ecdPaymentsRoutes = $this->sqlRoutesEcdPayments(false, $ecd, $dollarRate);
        $ecdPayments = $this->sqlRoutesEcdPayments(true, $ecd, $dollarRate);

        $transExpendituresLocalRoutes = $this->sqlRoutesTransExpenditures(false, false);
        $transExpendituresLocal = $this->sqlRoutesTransExpenditures(false, true);
        $transExpendituresExportRoutes = $this->sqlRoutesTransExpenditures(true, false);
        $transExpendituresExport = $this->sqlRoutesTransExpenditures(true, true);
        $transExpenditures = "($transExpendituresLocal + $transExpendituresExport)";

        $netBack = "$revenueTotal - ($metPayments) - ($ertPayments) - ($ecdPayments) - ($transExpenditures)";

        $barrelRatioExportScenario = $this->sqlAvgRoutesSum(
            self::ROUTES_EXPORT,
            'Barrel_ratio_'
        );

        $variableExpenditures = $this->sqlVariableExpenditures();

        $fixedPayrollExpenditures = $this->sqlFixedPayrollExpenditures();
        $fixedNoWrPayrollExpenditures = $this->sqlFixedNoWrPayrollExpenditures();
        $fixedNoPayrollExpenditures = $this->sqlFixedNoPayrollExpenditures();
        $fixedExpenditures = "($fixedNoPayrollExpenditures + $fixedNoWrPayrollExpenditures)";

        $prsNoPayrollExpenditures = $this->sqlPrsNoPayrollExpenditures();
        $prsExpenditures = $this->sqlPrsExpenditures();

        $productionExpenditures = "($fixedExpenditures + $variableExpenditures + $prsExpenditures)";
        $gaOverheadExpenditures = $this->sqlGaOverheadExpenditures();
        $overallExpenditures = "$gaOverheadExpenditures + $productionExpenditures";
        $overallExpendituresFull = "$overallExpenditures + $metPayments + $ecdPayments + $ertPayments + $transExpenditures";

        $operatingProfit = "$netBack - ($overallExpenditures)";
        $operatingProfitVariable = "$netBack - ($variableExpenditures)";
        $operatingProfitVariablePrsNoPayroll = "$operatingProfitVariable - ($prsNoPayrollExpenditures)";
        $operatingProfitVariablePrs = "$operatingProfitVariable - $prsExpenditures";

        $wells = DB::table(DB::raw("($technicalData) as technical"))
            ->selectRaw(DB::raw("
                technical.uwi,
                technical.oil,
                technical.liquid,
                technical.days_worked,
                technical.days_worked_by_date,
                technical.wells_count_by_company_date,
                technical.prs,
                technical.company_name,
                technical.field_id,
                technical.field_name,
                technical.ngdu_id,
                technical.ngdu_name,
                technical.cdng_id,
                technical.cdng_name,
                technical.gu_id,
                technical.gu_name,
                economic.*,
                $ecd AS ecd,
                $ert AS ert,
                $barrelRatioExportScenario AS Barrel_ratio_export_scenario,
                oil * cost_amort AS amort,
                $productionLocalRoutes,
                $productionLocal AS production_local,
                $productionExportRoutes,
                $productionExport AS production_export,
                $revenueLocalRoutes,
                $revenueLocal AS Revenue_local,
                $revenueExportRoutes,
                $revenueExport AS Revenue_export,
                $revenueTotal AS Revenue_total, 
                $metPaymentsLocalRoutes,
                $metPaymentsLocal AS MET_payments_local,
                $metPaymentsExportRoutes,
                $metPaymentsExport AS MET_payments_export,
                $metPayments AS MET_payments,
                $ertPaymentsRoutes,
                $ertPayments AS ERT_payments,
                $ecdPaymentsRoutes,
                $ecdPayments AS ECD_payments,
                $transExpendituresLocalRoutes,
                $transExpendituresLocal AS Trans_expenditures_local,
                $transExpendituresExportRoutes,
                $transExpendituresExport AS Trans_expenditures_export,
                $transExpenditures AS Trans_expenditures,
                $netBack AS NetBack_bf_pr_exp,
                $variableExpenditures AS Variable_expenditures,
                $fixedPayrollExpenditures AS Fixed_payroll_expenditures,
                $fixedNoWrPayrollExpenditures AS Fixed_noWRpayroll_expenditures,
                $fixedNoPayrollExpenditures AS Fixed_nopayroll_expenditures,
                $fixedExpenditures AS Fixed_expenditures,
                $prsNoPayrollExpenditures AS PRS_nopayroll_expenditures,
                $prsExpenditures AS PRS_expenditures,
                $productionExpenditures AS Production_expenditures,
                $gaOverheadExpenditures AS Gaoverheads_expenditures,
                $overallExpenditures AS Overall_expenditures,
                $overallExpendituresFull AS Overall_expenditures_full,
                $operatingProfit AS Operating_profit,
                $operatingProfitVariablePrsNoPayroll AS Operating_profit_variable_prs_nopayrall,
                $operatingProfitVariablePrs AS Operating_profit_variable_prs
            "))
            ->leftJoin(DB::raw("($economicData) as economic"), function ($join) {
                $join
                    ->on(DB::raw("technical.company_tbd_id"), '=', DB::raw("economic.company_tbd_id"))
                    ->on(DB::raw("technical.date"), '=', DB::raw("economic.date"))
                    ->on(DB::raw("technical.pes_id"), '=', DB::raw("economic.pes_id"));
            })
            ->toSql();

        $wellsSum = DB::table(DB::raw("($technicalData) as technical"))
            ->selectRaw(DB::raw("
                uwi,
                SUM($fixedNoPayrollExpenditures) as Fixed_nopayroll_expenditures_sum, 
                SUM($fixedPayrollExpenditures) as Fixed_payroll_expenditures_sum, 
                SUM($operatingProfit) AS Operating_profit_sum,
                SUM($operatingProfitVariablePrs) AS Operating_profit_variable_prs_sum,
                COUNT(*) as date_count
            "))
            ->leftJoin(DB::raw("($economicData) as economic"), function ($join) {
                $join
                    ->on(DB::raw("technical.company_tbd_id"), '=', DB::raw("economic.company_tbd_id"))
                    ->on(DB::raw("technical.date"), '=', DB::raw("economic.date"))
                    ->on(DB::raw("technical.pes_id"), '=', DB::raw("economic.pes_id"));
            })
            ->groupByRaw(DB::raw("uwi"))
            ->toSql();

        $profitability = "
            CASE WHEN Operating_profit_sum > 0
                 THEN 'profitable'
                 WHEN Operating_profit_variable_prs_sum < 0 
                 THEN 'profitless_cat_1'
                 ELSE 'profitless_cat_2'
            END   
        ";

        $wells = DB::table(DB::raw("($wells) as wells"))
            ->selectRaw(DB::raw("
                wells.*,
                wells_sum.*,
                $profitability AS profitability
            "))
            ->leftJoin(DB::raw("($wellsSum) as wells_sum"), function ($join) {
                $join->on(DB::raw("wells.uwi"), '=', DB::raw("wells_sum.uwi"));
            })
            ->get();

        dd($wells);
    }

    public function getEconomicQuery(): Builder
    {
        $economicScFa = EcoRefsScFa::query()
            ->whereId(51)
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
                costs.fix,
                costs.gaoverheads AS cost_Gaoverheads,
                costs.wr_nopayroll AS cost_WR_nopayroll,
                costs.wr_payroll AS cost_WR_payroll,
                costs.wr_nopayroll + wr_payroll as cost_WR,
                costs.wo AS cost_WO,
                costs.amort AS cost_amort,
                ndo_rates.ndo_rates,
                macros.barrel_world_price AS price_export_world,
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

    public function getTechnicalQuery(): Builder
    {
        $technicalSource = TechnicalStructureSource::query()
            ->whereName('MMG_Scenario_Test')
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

        $wells = DB::table($tableForecasts)
            ->selectRaw(DB::raw("
                well_id as uwi,
                gu_id,
                company_id,
                pes_id,
                date,
                oil * 1000 as oil,
                liquid * 1000 as liquid,
                days_worked,
                IFNULL(prs, 0) as prs
            "))
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

    private function getSqlSelectColumnsFromString(string $string)
    {
        $offset = strpos($string, 'select') + strlen('select');

        return substr(
            $string,
            $offset,
            strpos($string, 'from') - $offset
        );
    }
}
