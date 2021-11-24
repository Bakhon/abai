<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\BigData\Well;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\Org;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
}
