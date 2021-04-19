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
//        $companies = FieldCalcCompany::with('getCompanyBarrelPrice')->get();
        $companyData = [];
        $companies = FieldCalcCompany::all();
        foreach ($companies as $company){
            $companyData[$company->id] = $company->getCompanyBarrelPriceByDirection(1)->get();
        }
        dd($companyData);
        $exportDirections = EcoRefsDirectionId::where('name', '=', 'Экспорт')->pluck('id')->toArray();
        $scenario = EcoRefsScFa::where('name', '=', 'Корр. 6 на 2021-2025')->pluck('id')->toArray();
        $emppersExp = EcoRefsEmpPer::whereIn('direction_id', $exportDirections)->where('sc_fa', $scenario[0])->where('company_id', 7)->where('date', '2020-02-31')->get();
    }

}
