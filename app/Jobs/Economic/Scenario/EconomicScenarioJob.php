<?php

namespace App\Jobs\Economic\Scenario;

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
use App\Models\Refs\EcoRefsGtmKit;
use App\Models\Refs\EcoRefsGtmValue;
use App\Models\Refs\EcoRefsScenario;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use SplFixedArray;

class EconomicScenarioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 6000;

    public $scenarioId;

    public $oilPrice;

    public $dollarRate;

    const NUMBER_OF_STOPS = 16;

    const GTM_DENOMINATOR = 10000000;

    const COMPANY_OZEN = 5;
    const COMPANY_EMBA = 6;
    const COMPANY_MANGISTAU = 7;
    const COMPANY_KARAZANBAS = 8;
    const COMPANY_KAZ_GER = 9;

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

    const PROFITABILITY = [
        'profitable',
        'profitless_cat_1',
        'profitless_cat_2'
    ];

    const WELL_KEYS = [
        'Revenue_total',
        'Revenue_local',
        'Revenue_export',
        'oil',
        'liquid',
        'prs',
        'days_worked',
        'production_export',
        'production_local',
        'Fixed_noWRpayroll_expenditures',
        'Fixed_nopayroll_expenditures',
        'Fixed_payroll_expenditures',
        'Overall_expenditures',
        'Overall_expenditures_full',
        'Operating_profit',
    ];


    public function __construct(
        int $scenarioId,
        int $oilPrice,
        int $dollarRate
    )
    {
        $this->scenarioId = $scenarioId;

        $this->oilPrice = $oilPrice;

        $this->dollarRate = $dollarRate;
    }

    public function handle()
    {
        ini_set('max_execution_time', $this->timeout);

        $scenario = EcoRefsScenario::find($this->scenarioId);

        if (!$scenario) return;

        $gtmKit = $scenario->gtm_kit_id
            ? $scenario->gtmKit()->firstOrFail()
            : null;

        $scenarioEconomicId = $scenario->sc_fa_id;

        $scenarioTechnicalId = $scenario->source_id;

        $fixedNoPayrolls = [];

        foreach ($scenario->params["fixed_nopayrolls"] as $fixedNoPayroll) {
            $fixedNoPayrolls[] = $fixedNoPayroll["value"];
        }

        $costWrPayrolls = [];

        foreach ($scenario->params["cost_wr_payrolls"] as $costWrPayroll) {
            $costWrPayrolls[] = $costWrPayroll["value"];
        }

        list($wells, $variants) = $this->calculateScenarioVariants(
            $scenarioEconomicId,
            $scenarioTechnicalId,
            $this->oilPrice,
            $this->dollarRate,
            $fixedNoPayrolls,
            $costWrPayrolls
        );

        $wells = $this->getWellsWithCoordinates($wells);

        $gtms = $gtmKit ? $this->getGtms($gtmKit) : null;

        if ($gtms) {
            $wellId = TechnicalDataForecast::query()
                ->whereSourceId($scenarioTechnicalId)
                ->firstOrFail()
                ->well_id;

            foreach ($variants as &$variant) {
                $variant["gtm_well_id"] = $wellId;

                $variant = $this->addGtmsToScenario($variant, $gtms);
            }
        }

        DB::transaction(function () use ($scenario, $wells, $variants, $fixedNoPayrolls, $costWrPayrolls) {
            $scenario->results()->create([
                "oil_price" => $this->oilPrice,
                "dollar_rate" => $this->dollarRate,
                "wells" => $wells,
                "variants" => $variants
            ]);

            $scenario->increment(
                "calculated_variants",
                self::NUMBER_OF_STOPS * count($fixedNoPayrolls) * count($costWrPayrolls)
            );
        });
    }

    private function calculateScenarioVariants(
        string $scenarioEconomicId,
        string $scenarioTechnicalId,
        int $oilPrice,
        int $dollarRate,
        array $fixedNoPayrolls,
        array $costWrPayrolls
    ): array
    {
        $wells = $this->getWellsForScenarios(
            $scenarioEconomicId,
            $scenarioTechnicalId,
            $oilPrice,
            $dollarRate
        );

        $scenario = [
            "economic_id" => $scenarioEconomicId,
            "technical_id" => $scenarioTechnicalId,
            "coef_Fixed_nopayroll" => 0,
            "coef_cost_WR_payroll" => 0,
            "percent_stop_cat_1" => 0,
            "percent_stop_cat_2" => 0,
            "Barrel_ratio_export_scenario" => $wells[0]->Barrel_ratio_export_scenario ?? null,
            "stopped_wells" => [],
            "stopped_uwis" => [],
        ];

        foreach (self::WELL_KEYS as $wellKey) {
            $scenario[$wellKey] = 0;

            foreach (self::PROFITABILITY as $profitability) {
                $scenario["${wellKey}_${profitability}"] = 0;
            }
        }

        $wellsByProfitability = [];

        foreach ($wellsByProfitability as $profitability) {
            $wellsByProfitability[$profitability] = [];
        }

        foreach ($wells as $well) {
            $well = (array)$well;

            $wellsByProfitability[$well["profitability"]][] = $well;

            foreach (self::WELL_KEYS as $wellKey) {
                $scenario[$wellKey] += $well[$wellKey];

                $scenario[$wellKey . "_" . $well["profitability"]] += $well[$wellKey];
            }
        }

        foreach (self::WELL_KEYS as $wellKey) {
            $scenario["${wellKey}_optimize"] = $scenario[$wellKey];

            foreach (self::PROFITABILITY as $profitability) {
                $value = $scenario["${wellKey}_${profitability}"];

                $scenario["${wellKey}_${profitability}_optimize"] = $value;
            }
        }

        $scenario["oil_price"] = $oilPrice;
        $scenario["dollar_rate"] = $dollarRate;

        $scenario["uwi_count"] = count($wells);
        $scenario["uwi_count_optimize"] = $scenario["uwi_count"];

        foreach (self::PROFITABILITY as $profitability) {
            $scenario["uwi_count_$profitability"] = count($wellsByProfitability[$profitability]);

            $scenario["uwi_count_${profitability}_optimize"] = $scenario["uwi_count_$profitability"];
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
                $wellsByProfitability["profitless_cat_1"]
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
                $wellsByProfitability["profitless_cat_2"]
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

        return [$wells, $optimizedScenarios];
    }

    private function getWellsWithCoordinates(array $wells): array
    {
        $uwis = [];

        foreach ($wells as &$well) {
            $well = (array)$well;

            $uwis[] = $well["uwi"];
        }

        $wellCoordinates = Well::query()
            ->whereIn("uwi", $uwis)
            ->whereNotNull("whc")
            ->with("spatialObject")
            ->get()
            ->groupBy("uwi");

        foreach ($wells as &$well) {
            $well["coordinates"] = $wellCoordinates->get($well["uwi"])[0]["spatialObject"]["coord_point"] ?? null;
        }

        return $wells;
    }

    private function getWellsForScenarios(
        int $scenarioEconomicId,
        int $scenarioTechnicalId,
        int $oilPrice,
        int $dollarRate,
        array $wellByDates = null,
        string $wellId = null
    ): array
    {
        $technicalData = $this
            ->getTechnicalQuery($scenarioTechnicalId, $wellByDates, $wellId)
            ->toSql();

        $economicData = $this
            ->getEconomicQuery($scenarioEconomicId)
            ->toSql();

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
            self::PREFIX_BARREL_RATIO
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
        array $wells
    ): array
    {
        $percent = $stoppedPercent / 100;

        $stoppedWellsCount = ceil($scenario["uwi_count_$profitability"] * $percent);

        $stoppedWells = array_slice($wells, $stoppedOffset, $stoppedWellsCount - $stoppedOffset);

        $stoppedOffset = $stoppedWellsCount;

        $scenario[$profitabilityPercentKey] = $percent;

        foreach ($stoppedWells as $well) {
            $scenario["uwi_count_optimize"] -= 1;
            $scenario["uwi_count_{$profitability}_optimize"] -= 1;

            $scenario["stopped_wells"][] = $well;
            $scenario["stopped_uwis"][] = $well["uwi"];

            foreach (self::WELL_KEYS as $wellKey) {
                $scenario["${wellKey}_optimize"] -= $well[$wellKey];

                $scenario["${wellKey}_${profitability}_optimize"] -= $well[$wellKey];
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

        $scenario["coef_cost_WR_payroll"] = $costWrPayroll;

        foreach ($scenario["stopped_wells"] as $well) {
            $profitability = $well["profitability"];

            $fixedExpenditures =
                $fixedNoPayroll * $well["Fixed_nopayroll_expenditures"] +
                $costWrPayroll * $well["Fixed_payroll_expenditures"];

            $scenario["Operating_profit_optimize"] -= $fixedExpenditures;
            $scenario["Operating_profit_${profitability}_optimize"] -= $fixedExpenditures;

            $scenario["Overall_expenditures_optimize"] += $fixedExpenditures;
            $scenario["Overall_expenditures_${profitability}_optimize"] += $fixedExpenditures;

            $scenario["Overall_expenditures_full_optimize"] += $fixedExpenditures;
            $scenario["Overall_expenditures_full_${profitability}_optimize"] += $fixedExpenditures;
        }

        return $scenario;
    }

    private function addGtmsToScenario(
        array $scenario,
        array $gtms
    ): array
    {
        $scenario["gtm_oil"] = 0;

        $scenario["gtm_liquid"] = 0;

        $scenario["gtm_cost"] = 0;

        $scenario["gtm_operating_profit"] = 0;

        $scenario["gtms"] = [];

        $operatingDelta = $scenario["Operating_profit_optimize"] - $scenario["Operating_profit"];

        if ($operatingDelta <= 0) {
            return $scenario;
        }

        $gtmGrowth = 0;

        $date = Carbon::parse($gtms[0]->date);

        $wellByMonths = [];

        for ($month = 1; $month <= 12; $month++) {
            $date = $date
                ->setMonth($month)
                ->setDay(1);

            $formattedDate = $date->copy()->format("Y-m-d");

            $wellByMonths[$formattedDate] = [
                "date" => $formattedDate,
                "days_worked" => $date->daysInMonth,
                "oil" => 0,
                "prs" => 0,
                "liquid" => 0,
            ];

            $gtmsByMonth = array_filter($gtms, function ($gtm) use ($month, $operatingDelta) {
                return Carbon::parse($gtm->date)->month === $month && $gtm->price <= $operatingDelta;
            });

            if (!$gtmsByMonth) continue;

            $gtmsByMonth = $this->getGtmsForCostLimitWithMaxGrowth($gtmsByMonth, $operatingDelta);

            $gtmGrowth += $gtmsByMonth["growth"];

            $gtmOil = $gtmGrowth * $wellByMonths[$formattedDate]["days_worked"];

            $wellByMonths[$formattedDate]["oil"] = $gtmOil;

            $wellByMonths[$formattedDate]["liquid"] = $gtmOil * 10;

            foreach (collect($gtmsByMonth["gtms"])->groupBy("id") as $gtmId => $gtmsGroup) {
                $gtm = $gtmsGroup->first();

                $scenario["gtms"][$formattedDate][] = [
                    "id" => $gtmId,
                    "name" => $gtm["name"],
                    "price" => $gtm["price"],
                    "growth" => $gtm["growth"],
                    "amount" => count($gtmsGroup),
                    "oil_month" => $gtm["growth"] * $date->daysInMonth,
                    "oil_total" => $gtm["growth"] * (1 + $date->copy()->setMonth(12)->setDay(31)->diffInDays($date)),
                ];
            }

            $scenario["gtm_oil"] += $wellByMonths[$formattedDate]["oil"];

            $scenario["gtm_liquid"] += $wellByMonths[$formattedDate]["liquid"];

            $scenario["gtm_cost"] += $gtmsByMonth["cost"];

            $scenario["gtm_operating_profit"] -= $gtmsByMonth["cost"];

            $operatingDelta -= $gtmsByMonth["cost"];
        }

        if ($operatingDelta > 0) {
            $scenario["gtm_operating_profit"] += $operatingDelta;
        }

        $well = (array)$this->getWellsForScenarios(
            $scenario["economic_id"],
            $scenario["technical_id"],
            $scenario["oil_price"],
            $scenario["dollar_rate"],
            $wellByMonths,
            $scenario["gtm_well_id"]
        )[0];

        $scenario["gtm_operating_profit"] += $well["Operating_profit"];

        return $scenario;
    }

    private function getGtms(EcoRefsGtmKit $kit): array
    {
        $gtmLogId = $kit->gtm_log_id;

        $gtmLogValueId = $kit->gtm_value_log_id;

        $gtms = DB::table((new EcoRefsGtm())->getTable())
            ->whereRaw(DB::raw("log_id = $gtmLogId"))
            ->toSql();

        $gtmValues = DB::table((new EcoRefsGtmValue())->getTable())
            ->whereRaw(DB::raw("log_id = $gtmLogValueId"))
            ->toSql();

        return DB::table(DB::raw("($gtms) as gtms"))
            ->leftJoin(DB::raw("($gtmValues) as gtm_values"), function ($join) {
                $join->on(DB::raw("gtms.id"), '=', DB::raw("gtm_values.gtm_id"));
            })
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

    public function getEconomicQuery(int $scFaId): Builder
    {
        $ndoRates = EcoRefsNdoRates::query()
            ->selectRaw(DB::raw("company_id, ndo_rates"))
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
            ->toSql();

        $macros = EcoRefsMacro::query()
            ->selectRaw(DB::raw("date, ex_rate_dol"))
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
            ->toSql();

        $saleShares = EcoRefsEmpPer::query()
            ->selectRaw(DB::raw("
                company_id,
                date,
                {$this->sqlSumByRoute('emp_per', self::PREFIX_SALE_SHARE)}
            "))
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
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
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
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
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
            ->groupByRaw(DB::raw("company_id, date"))
            ->toSql();

        $transExpColumns = $this->sqlSumByRoute(
            'tn_rate',
            self::PREFIX_TRANS_EXP,
            true,
            'trans_exp'
        );

        $companyTbdId = $this->sqlCompanyTbdId();

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
            ->whereRaw(DB::raw("sc_fa = $scFaId"))
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
            ->leftJoin(DB::raw("($ndoRates) as ndo_rates"), function ($join) use ($scFaId) {
                $join->on(DB::raw("costs.company_id"), '=', DB::raw("ndo_rates.company_id"));
            })
            ->leftJoin(DB::raw("($macros) as macros"), function ($join) use ($scFaId) {
                $join->on(DB::raw("costs.date"), '=', DB::raw("macros.date"));
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
            ->leftJoin(DB::raw("($transExp) as trans_exp"), function ($join) use ($scFaId) {
                $join
                    ->on(DB::raw("costs.company_id"), '=', DB::raw("trans_exp.company_id"))
                    ->on(DB::raw("costs.date"), '=', DB::raw("trans_exp.date"));
            });
    }

    public function getTechnicalQuery(
        int $sourceId,
        array $wellByDates = null,
        string $wellId = null
    ): Builder
    {
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
            ->whereRaw(DB::raw("source_id = $sourceId"))
            ->groupByRaw(DB::raw("date"))
            ->toSql();

        $wellsCountByDate = DB::table($tableForecasts)
            ->selectRaw(DB::raw("company_id, date, COUNT(*) as wells_count_by_company_date"))
            ->whereRaw(DB::raw("source_id = $sourceId"))
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

        if ($wellId) {
            $wellsQuery->whereRaw(DB::raw("well_id = '$wellId'"));
        }

        $wells = $wellsQuery
            ->whereRaw(DB::raw("source_id = $sourceId"))
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

    private function sqlCompanyTbdId(): string
    {
        $companies = [
            self::COMPANY_OZEN => 2,
            self::COMPANY_EMBA => 3,
            self::COMPANY_MANGISTAU => 2000000000004,
            self::COMPANY_KARAZANBAS => 5000001017,
            self::COMPANY_KAZ_GER => 5000002020,
        ];

        $sqlQuery = "";

        foreach ($companies as $companyId => $tbdId) {
            $sqlQuery .= "WHEN company_id = $companyId THEN $tbdId ";
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

            $query .= " WHEN date = '$date' THEN $value ";
        }

        return "CASE $query END";
    }
}
