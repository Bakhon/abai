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

class FieldCalcController extends Controller
{

    const ONE_YEAR = 365;
    public $worldBarrelPrice = 0;
    public $worldDollarRate = 0;
    public $worldRubRate = 0;
    public $oilProduction = 64;

    public function __construct()
    {
        $data = FieldCalcHelper::getBarrelWorldPrice();
        $this->worldBarrelPrice = $data['averageBarrelPrice'];
        $this->worldDollarRate = $data['averageDollarRate'];
        $this->worldRubRate = $data['averageRubRate'];
    }

    public function index()
    {
        $currentYear = '2020';
        $previousYear = '2019';
        $dateTo = date('Y-m-d', strtotime($currentYear.'-12-01'));
        $dateFrom = date("Y-m-d", strtotime($currentYear . "-01-01"));
        $companies = FieldCalcCompany::all();
        foreach ($companies as $key => $company) {
            $company['ecorefsemppers'] = $company->getCompanyBarrelPriceByDirection(1)->get()->toArray();
            $company['opiu'] = SubholdingCompany::whereName($company->name)->first();
            if($company['opiu']){
                $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
                $companyRepTtValues = $company['opiu']->statsByDate($currentYear)->get()->toArray();
                $company['opiu']['values'] = app('App\Http\Controllers\EconomyKenzhe\MainController')->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $dateFrom, $dateTo);
            }
        }
        dd($companies);
    }

}
