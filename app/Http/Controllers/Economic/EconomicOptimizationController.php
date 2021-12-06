<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\EcoRefsScenario;
use App\Services\BigData\StructureService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EconomicOptimizationController extends Controller
{
    protected $structureService;

    const DOLLAR_RATE_URL = 'https://www.nationalbank.kz/ru/exchangerates/ezhednevnye-oficialnye-rynochnye-kursy-valyut';
    const DOLLAR_RATE_KEY = 'USD / KZT';

    const OIL_PRICE_URL = 'https://ru.investing.com/commodities/brent-oil-historical-data';
    const OIL_KEY = 'last_last';

    public function __construct(StructureService $structureService)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'inputParams', 'getData');

        $this->structureService = $structureService;
    }

    public function index(): View
    {
        return view('economic.optimization.index');
    }

    public function inputParams(): View
    {
        return view('economic.optimization.input_params');
    }

    public function getData(Request $request): array
    {
        $org = EconomicNrsController::getOrg($request->org_id, $this->structureService);

        $scenario = EcoRefsScenario::query()
            ->whereId($request->scenario_id)
            ->with('results')
            ->firstOrFail();

        $gtmKit = $scenario->gtm_kit_id
            ? $scenario->gtmKit()->first()
            : null;

        return [
            'org' => $org,
            'scenario' => $scenario,
            'specificIndicator' => $this->getSpecificIndicatorData($scenario->sc_fa_id),
//            'wells' => $this->getWells(),
            'dollarRate' => [
                'value' => $this->getDollarRate() ?? '0',
                'url' => self::DOLLAR_RATE_URL
            ],
            'oilPrice' => [
                'value' => $this->getOilPrice() ?? '0',
                'url' => self::OIL_PRICE_URL
            ],
            'gtms' => $gtmKit
                ? EcoRefsGtm::query()
                    ->whereLogId($gtmKit->gtm_log_id)
                    ->get()
                : []
        ];
    }

    private function getSpecificIndicatorData(int $scFaId): array
    {
        return EcoRefsCost::query()
            ->select(
                DB::raw('AVG(variable) as avg_variable'),
                DB::raw('AVG(fix_payroll) as avg_fix_payroll'),
                DB::raw('AVG(wo) as avg_wo'),
                DB::raw('AVG(fix) as avg_fix'),
                DB::raw('AVG(gaoverheads) as avg_gaoverheads'),
                DB::raw('AVG(wr_nopayroll) as avg_wr_nopayroll'),
                DB::raw('AVG(wr_payroll) as avg_wr_payroll'),
            )
            ->whereScFa($scFaId)
            ->get()
            ->first()
            ->toArray();
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
}
