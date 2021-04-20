<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Http\Controllers\Controller;

use App\Models\EconomyKenzhe\FieldCalcCompany;
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

    public function index(){
        $companies = FieldCalcCompany::all();
        foreach ($companies as $key=> $company){
            $company['ecorefsemppers'] = $company->getCompanyBarrelPriceByDirection(1)->get()->toArray();
        }
        echo '<pre>';
        print_r($companies);
        echo '</pre>';
    }

}
