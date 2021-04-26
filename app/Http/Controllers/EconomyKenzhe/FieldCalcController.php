<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Http\Controllers\Controller;

use App\Models\EconomyKenzhe\FieldCalcCompany;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Models\EcoRefsAvgMarketPrice;
use App\Models\EcoRefsAvgPrs;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\EcoRefsEquipId;
use App\Models\EcoRefsMacro;
use App\Models\EcoRefsNdoRates;
use App\Models\EcoRefsPrepElectPrsBrigCost;
use App\Models\EcoRefsProcDob;
use App\Models\EcoRefsRentEquipElectServCost;
use App\Models\EcoRefsRentTax;
use App\Models\EcoRefsServiceTime;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsEmpPer;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use function Complex\ln;

class FieldCalcController extends MainController
{

    const ONE_YEAR = 365;
    public $worldBarrelPrice = 0;
    public $worldDollarRate = 0;
    public $worldRubRate = 0;
    public $liquidProduction = 337;
    public $oilProduction = 64;

    public function __construct()
    {
        $data = FieldCalcHelper::getBarrelWorldPrice(2);
        $this->worldBarrelPrice = $data['averageBarrelPrice'];
        $this->worldDollarRate = $data['averageDollarRate'];
        $this->worldRubRate = $data['averageRubRate'];
    }

    public function index()
    {
        $currentYear = '2020';
        $previousYear = (string) $currentYear - 1;
        $dateTo = date('Y-m-d', strtotime($currentYear.'-12-01'));
        $dateFrom = date("Y-m-d", strtotime($currentYear . "-01-01"));
        $companies = FieldCalcCompany::whereId(5)->get();
        $company = $companies[0];
//        foreach ($companies as $key => $company) {
            $company['ecorefsemppers'] = $company->getCompanyBarrelPriceByDirection(1, 2)->get()->toArray();
            $company['eco_refs_prep_elect_prs_brig_costs'] = $company->compRas(2)->get();
            $company['opiu'] = SubholdingCompany::whereName($company->name)->first();
            if($company['opiu']){
                $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
                $companyRepTtValues = $company['opiu']->statsByDate($currentYear)->get()->toArray();
                $company['opiu']['values'] = $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo);
            }
//        }
        $equipments = EcoRefsEquipId::pluck('id');
        $opiuNames = ['B61000000000', 'B62000000000', 'BZ7001010000', 'BZ7001030000',
            'BZ7001050000', 'BZ7001120000', 'BZ7001180000', 'BZ7001240000', 'BZ7001260000',
            'B72165030000', 'BZ7001340000', 'B71136000000', 'B71138000000', 'B72140000000',
            'B72145000000', 'BZ7001470000', 'B71150000000', 'B72155000000', 'BZ7001600000',
            'BZ7001620000', 'BZ7001670000', 'BZ7001700000', 'BZ7001800000', 'BZ7001840000',
            'BZ7001850000', 'B72186000000', 'BZ7001880000', 'BZ7001900500', 'B72190070000',
            'B72190080000'
            ];
        dd(FieldCalcHelper::sumOverTree($companies[0]['opiu']));

    }

}