<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;

class EconomicOptimizationController extends Controller
{
    protected $druidClient;

    const DATA_SOURCE = 'economic_scenario_test_v2';

    const DATA_SOURCE_DATE = '2021/07/13';

    const OPTIMIZED_COLUMNS = [
        "Revenue_total",
        "Overall_expenditures",
        "operating_profit_12m",
        "oil",
        "liquid",
        "prs",
        "well_count",
        "well_count_profitable",
        "well_count_profitless_cat_1",
        "well_count_profitless_cat_2",
    ];

    const OPTIMIZED_COLUMN_SUFFIX = '_optimize';

    const DOLLAR_RATE_URL = 'https://www.nationalbank.kz/ru/exchangerates/ezhednevnye-oficialnye-rynochnye-kursy-valyut';

    const DOLLAR_RATE_KEY = 'USD / KZT';

    const OIL_PRICE_URL = 'https://ru.investing.com/commodities/brent-oil-historical-data';

    const OIL_KEY = '_last_8833';

    public function __construct(DruidClient $druidClient)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData');

        $this->druidClient = $druidClient;
    }

    public function index()
    {
        return view('economic.optimization');
    }

    public function getData(Request $request): array
    {
        $org = EconomicNrsController::getOrg($request->org_id);

        return [
            'scenarios' => $this->getScenarios(),
            'dollarRate' => $this->getDollarRate() ?? '0',
            'oilPrice' => $this->getOilPrice() ?? '0',
            'org' => $org,
            'specificIndicator' => $this->getSpecificIndicatorData()
        ];
    }

    private function getScenarios(): array
    {
        $builder = $this
            ->druidClient
            ->query(self::DATA_SOURCE, Granularity::YEAR)
            ->interval(EconomicNrsController::intervalFormat(
                Carbon::parse(self::DATA_SOURCE_DATE),
                Carbon::parse(self::DATA_SOURCE_DATE)->addDay(),
            ));

        $columns = [
            "scenario_id",
            "percent_stop_cat_1",
            "percent_stop_cat_2",
            "coef_Fixed_nopayroll",
            "coef_cost_WR_payroll",
            "dollar_rate",
            "oil_price",
        ];

        foreach (self::OPTIMIZED_COLUMNS as $column) {
            $columns[] = $column;

            $columns[] = $column . self::OPTIMIZED_COLUMN_SUFFIX;
        }

        $data = $builder
            ->select($columns)
            ->groupBy()
            ->data();

        $scenarios = [];

        foreach ($data as $index => $item) {
            foreach ($columns as $column) {
                $scenarios[$index][$column] = $item[$column];
            }

            foreach (self::OPTIMIZED_COLUMNS as $column) {
                $columnOptimized = $column . self::OPTIMIZED_COLUMN_SUFFIX;

                $scenarios[$index][$column] = [
                    'value' => self::moneyFormat($item[$column]),
                    'value_optimized' => self::moneyFormat($item[$columnOptimized]),
                    'percent' => EconomicNrsController::percentFormat($item[$columnOptimized], $item[$column], 2),
                    'original_value' => $item[$column],
                    'original_value_optimized' => $item[$columnOptimized],
                ];
            }
        }

        return $scenarios;
    }

    private function getSpecificIndicatorData(): array
    {
        return EcoRefsCost::query()
            ->select(
                DB::raw('SUM(variable) as sum_variable'),
                DB::raw('SUM(fix_payroll) as sum_fix_payroll'),
                DB::raw('SUM(wo) as sum_wo'),
                DB::raw('SUM(fix) as sum_fix'),
                DB::raw('SUM(gaoverheads) as sum_gaoverheads'),
                DB::raw('SUM(wr_nopayroll) as sum_wr_nopayroll'),
                DB::raw('SUM(wr_payroll) as sum_wr_payroll'),
            )
            ->whereScFa(6)
            ->get()
            ->first()
            ->toArray();
    }

    private function getDollarRate(): ?string
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
            return null;
        }
    }

    private function getOilPrice(): ?string
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

    static function moneyFormat(?float $digit): array
    {
        $digit = $digit ?? 0;

        $digitAbs = abs($digit);

        if ($digitAbs < 1000000) {
            return [
                number_format($digit / 1000, 2),
                trans('economic_reference.thousand')
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
