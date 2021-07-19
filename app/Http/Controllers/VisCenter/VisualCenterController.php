<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use App\Models\DzoPlan;
use App\Models\DZOyear;
use App\Models\OilRate;
use App\Models\UsdRate;
use App\Models\VisCenter\DataForKGM\Monthly\ChemistryForKGM;
use App\Models\VisCenter\DataForKGM\Monthly\RepairsForKGM;

use App\Models\VisCenter\DataForKGM\Daily\OilAndGasForKGM;
use App\Models\VisCenter\DataForKGM\Daily\WaterForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilDeliveryForKGM;
use App\Models\VisCenter\DataForKGM\Daily\GasMoreForKGM;
use App\Models\VisCenter\DataForKGM\Daily\FondsForKGM;

use App\Models\VisCenter\EmergencyHistory;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;

use App\Models\VisCenter\ImportForms\DZOcalc as ImportFormsDZOcalc;
use App\Models\VisCenter\ImportForms\DZOdaily as ImportFormsDZOdaily;
use App\Models\VisCenter\ImportForms\DZOstaff;
use App\Models\VisCenter\ImportForms\DZOyear as ImportFormsDZOyear;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisualCenterController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:visualcenter view main')->only('visualcenter3', 'visualcenter4', 'visualcenter5', 'visualcenter6', 'visualcenter7');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDZOcalcs(Request $request)
    {
        $dateStart = $request->get('dateStart');
        $dateEnd = $request->get('dateEnd');
        $dzo = $request->get('dzo');
        if (!$dateEnd) {
            $dateEnd = new \DateTime($dateStart);
            $dateStart = clone $dateEnd;
            $dateStart->sub(new \DateInterval('P3M'));
            $dateStart = $dateStart->format('Y-m-d H:i:s');
            $dateEnd = $dateEnd->format('Y-m-d H:i:s');
        }
        $dateTimeStart = new \DateTime($dateStart);
        $dateTimeEnd = new \DateTime($dateEnd);
        $dzoDataActual = ImportFormsDZOcalc::query()
            ->where('date', '>=', $dateTimeStart->format('Y-m-d H:i:s'))
            ->where('date', '<', $dateTimeEnd->format('Y-m-d H:i:s'));
        if ($dzo) {
            $dzoDataActual->where('dzo', '=', $dzo);
        }
        $dzoDataActual = $dzoDataActual->get();

        $dateTimeStart->sub(new \DateInterval('P1Y'));
        $dateTimeEnd->sub(new \DateInterval('P1Y'));
        $dzoDataPrevYear = ImportFormsDZOcalc::query()
            ->where('date', '>=', $dateTimeStart->format('Y-m-d H:i:s'))
            ->where('date', '<', $dateTimeEnd->format('Y-m-d H:i:s'));
        if ($dzo) {
            $dzoDataPrevYear->where('dzo', '=', $dzo);
        }
        $dzoDataPrevYear = $dzoDataPrevYear->get();

        return response()->json(['dzoDataActual' => $dzoDataActual, 'dzoDataPrevYear' => $dzoDataPrevYear]);
    }

    public function getDZOCalcsActualMonth()
    {
        $maxDate = ImportFormsDZOcalc::query()->max('date');
        $tmpDate = \DateTime::createFromFormat('Y-m-d H:i:s', $maxDate);
        return $tmpDate->format('m');
    }

    public function getUsdRates()
    {
        $data = UsdRate::query()
            ->where('date', '>=', '2010-01-01')
            ->get()
            ->toArray();

        return response()->json($data);
    }

    public function getOilRates()
    {
        $oilRatesData = OilRate::query()
            ->get()
            ->toArray();
        return response()->json($oilRatesData);
    }

    public function getDzoMonthlyPlans()
    {
        $dzoMonthlyPlans = dzoPlan::query()
            ->get()
            ->toArray();
        return response()->json($dzoMonthlyPlans);
    }

    public function getDzoYearlyPlan()
    {
        $dzoYearlyPlan = DZOyear::query()
            ->where('date', date("Y"))
            ->select('dzo', 'oil_plan', 'oil_opek_plan')
            ->get()
            ->toArray();
        return response()->json($dzoYearlyPlan);
    }

    public function getCurrency(Request $request)
    {
        $udsRate = DB::table('usd_rate')
            ->orderBy('id', 'DESC')
            ->select('value as description', 'change', 'index', 'date')
            ->first();
        return response()->json($udsRate);
    }

    public function getCurrencyPeriod(Request $request)
    {
        $datesNow = $request->dates;
        $period = $request->period;
        $datesNowString = strtotime($datesNow);
        $last = strtotime($datesNow . '-' . $period . 'day');
        //$last = strtotime($datesNow . '- 1 month');
        $countDay = ($datesNowString - $last) / 86400;

        for (
            $i = 1;
            $i <= $countDay;
            $i++
        ) {
            $last = $last + 86400;
            $dates = date('d.m.Y', $last);
            $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $dates;
            $dataObj = simplexml_load_file($url);
            if ($dataObj) {
                foreach ($dataObj as $item) {
                    if ($item->title == 'USD') {
                        $description = $item->description;
                        $array[$i] = array(
                            "dates" => $dates,
                            "description" => $description,
                            "change" => $item->change,
                            "index" => $item->index,
                        );
                    }
                }
            }
        }

        return response()->json($array);
    }
    public function visualcenter()
    {
        return view('visualcenter.visualcenter');
    }

    public function visualcenter2()
    {
        return view('visualcenter.visualcenter2');
    }

    public function visualcenter3()
    {
        return view('visualcenter.visualcenter3');
    }

    public function visualcenter3GetDataStaff(Request $request)
    {
        return response()->json(DZOstaff::all());
    }

    public function visualcenter3GetData(Request $request)
    {
        $today = $request->timestampToday;
        $end = $request->timestampEnd;
        $period = (($end - $today) + (86400000 * 2));
        $todayback = $today - $period;
        //return response()->json(DZOday::all('oil_plan','oil_fact','__time'));//->value('oil_plan'));
        return response()->json(ImportFormsDZOdaily::all(
            'fond_nagnetat_ef',
            'fond_nagnetat_df',
            'fond_nagnetat_bd',
            'fond_nagnetat_ofls',
            'fond_nagnetat_prs',
            'fond_nagnetat_oprs',
            'fond_nagnetat_krs',
            'fond_nagnetat_okrs',
            'oil_plan',
            'oil_fact',
            'gas_plan',
            'gas_fact',
            '__time',
            'tovarnyi_ostatok_nefti_prev_day',
            'tovarnyi_ostatok_nefti_today',
            'sdacha_gaza_prirod_plan',
            'sdacha_gaza_prirod_fact',
            'raskhod_prirod_plan',
            'raskhod_prirod_fact',
            'pererabotka_gaza_prirod_plan',
            'pererabotka_gaza_prirod_fact',
            'pererabotka_gaza_poput_plan',
            'pererabotka_gaza_poput_fact',
            'sdacha_gaza_poput_plan',
            'sdacha_gaza_poput_fact',
            'raskhod_poput_plan',
            'raskhod_poput_fact',
            'ppd_zakachka_morskoi_vody_plan',
            'ppd_zakachka_morskoi_vody_fact',
            'ppd_zakachka_stochnoi_vody_plan',
            'ppd_zakachka_stochnoi_vody_fact',
            'ppd_zakachka_albsen_vody_plan',
            'ppd_zakachka_albsen_vody_fact',
            'fond_nagnetat_osvoenie',
            'fond_nagnetat_konv',
            'fond_nagnetat_well_survey',
            'fond_nagnetat_others',

            'otm_iz_burenia_skv_plan',
            'otm_iz_burenia_skv_fact',
            'otm_burenie_prohodka_plan',
            'otm_burenie_prohodka_fact',
            'otm_krs_skv_plan',
            'otm_krs_skv_fact',
            'otm_prs_skv_plan',
            'otm_prs_skv_fact',

            'chem_prod_zakacka_demulg_plan',
            'chem_prod_zakacka_demulg_fact',
            'chem_prod_zakacka_bakteracid_plan',
            'chem_prod_zakacka_bakteracid_fact',
            'chem_prod_zakacka_ingibator_korrozin_plan',
            'chem_prod_zakacka_ingibator_korrozin_fact',
            'chem_prod_zakacka_ingibator_soleotloj_plan',
            'chem_prod_zakacka_ingibator_soleotloj_fact',

            'fond_neftedob_ef',
            'fond_neftedob_df',
            'fond_neftedob_bd',
            'fond_neftedob_osvoenie',
            'fond_neftedob_ofls',
            'fond_neftedob_prs',
            'fond_neftedob_oprs',
            'fond_neftedob_krs',
            'fond_neftedob_okrs',
            'fond_neftedob_well_survey',
            'fond_neftedob_nrs',
            'fond_neftedob_others',
            'tb_covid_total',
            'tb_personal_fact',
            'oil_opek_plan',
            'date',
            'opec2',
            'landing',
            'impulses',
            'accident',
            'restrictions',
            'otheraccidents',
            'dzo',
            'oil_dlv_plan',
            'oil_dlv_fact',
            'prod_wells_work',
            'prod_wells_idle',
            'inj_wells_idle',
            'inj_wells_work',
            'gk_plan',
            'gk_fact',
            'liq_plan',
            'liq_fact'
        )->where('__time', '>', $todayback)->where('__time', '<', $end + 86400000));
        //return response()->json(Vis2Form::all());//response()->json($array);
        //return  response()->json($request);
    }

    public function visualcenter3GetDataOpec()
    {
        return response()->json(ImportFormsDZOyear::all(
            'date',
            'oil_plan',
            'dzo',
            'ngdu'
            // 'oil_dlv_opek_plan',

        )->where('date', '2021'));
        //->where('__time', '>', $todayback)->where('__time', '<', $end + 86400000));

    }

    public function visualcenter4()
    {
        return view('visualcenter.visualcenter4');
    }

    public function visualcenter5()
    {
        return view('visualcenter.visualcenter5');
    }

    public function visualcenter6()
    {
        return view('visualcenter.visualcenter6');
    }

    public function visualcenter7()
    {
        return view('visualcenter.visualcenter7');
    }

    public function excelform()
    {
        return view('visualcenter.excelform');
    }

    public function getProductionDetails(Request $request)
    {
        $endPeriod = Carbon::parse($request->timestampEnd)->endOfDay();
        $startPeriod = Carbon::parse($request->timestampToday)->startOfDay();
        $diff = $startPeriod->diffInDays($endPeriod);
        $startPeriod->subDays($diff);

        $factDataByPeriod = DzoImportData::query()
            ->whereDate('date', '>', $startPeriod)
            ->whereDate('date', '<=', $endPeriod)
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->get()
            ->toArray();

        $planData = $this->getPlanDetails();
        $comparedData = $this->getComparedPlanFactData($planData, $factDataByPeriod);
        return response()->json($comparedData);
    }

    private function getPlanDetails()
    {
        $planData = DzoPlan::query()
            ->get();
        return $planData;
    }

    private function getComparedPlanFactData($planData, $factData)
    {
        $comparedData = [];
        foreach ($factData as $item) {
            $parsedDate = Carbon::parse($item['date'])->startOfDay()->day(01)->toDateTimeString();
            $planRecord = $this->getPlanForRecord($item['dzo_name'], $parsedDate, $planData);
            $planRecord = $this->deleteDuplicateFields($planRecord);
            $comparedData[] = array_merge($item, $planRecord);
        }
        return $comparedData;
    }

    private function getPlanForRecord($dzoName, $date, $planData)
    {
        $searchedRecord = $planData->where('dzo', $dzoName)->where('date', $date);
        if ($searchedRecord->count() > 0) {
            return array_values($searchedRecord->toArray())[0];
        }
        return array();

    }

    public function getOtmDetails(Request $request)
    {
        return DzoImportOtm::query()
            ->whereMonth('date', '>=', $request->startPeriod)
            ->whereMonth('date', '<=', $request->endPeriod)
            ->get()
            ->toArray();
    }

    public function getChemistryDetails(Request $request)
    {
        return DzoImportChemistry::query()
            ->whereMonth('date', '>=', $request->startPeriod)
            ->whereMonth('date', '<=', $request->endPeriod)
            ->get()
            ->toArray();
    }

    private function deleteDuplicateFields($planRecord)
    {
        $fields = [
            0 => "dzo",
            1 => "date",
            2 => "created_at",
            3 => "updated_at",
            4 => 'id',
            5 => 'dzo_name',
        ];
        foreach ($fields as $item) {
            unset($planRecord[$item]);
        }
        return $planRecord;
    }

    public function getDrillingDetails(Request $request)
    {
        return DzoImportData::query()
            ->select('date', 'dzo_name', 'otm_drilling_fact', 'otm_wells_commissioning_from_drilling_fact')
            ->whereDate('date', '>=', Carbon::parse($request->startPeriod))
            ->whereDate('date', '<=', Carbon::parse($request->endPeriod))
            ->get()
            ->toArray();
    }

    public function getFondDetails(Request $request)
    {
        $fields = $request->fields;
        array_push($fields, "date", "dzo_name", "id");
        return DzoImportData::query()
            ->select($fields)
            ->whereDate('date', '>=', Carbon::parse($request->startPeriod))
            ->whereDate('date', '<=', Carbon::parse($request->endPeriod))
            ->with('importDowntimeReason')
            ->get()
            ->toArray();
    }

    public function dailyReport()
    {
        return view('visualcenter.dailyreport');
    }

    public function getProductionDetailsForYear()
    {
        $startPeriod = Carbon::now()->startOfYear();
        $endPeriod = Carbon::now()->endOfDay();
        return DzoImportData::query()
            ->select()
            ->whereDate('date', '>=', $startPeriod)
            ->whereDate('date', '<=', $endPeriod)
            ->with('importDecreaseReason')
            ->get()
            ->toArray();
    }
    public function getEmergencyHistory(Request $request)
    {
        return EmergencyHistory::query()
            ->select(DB::raw('DATE_FORMAT(date,"%d.%m.%Y") as date'), 'title', 'description')
            ->whereMonth('date', $request->currentMonth)
            ->where('type', 1)
            ->get()
            ->toArray();
    }
    public function getHistoricalProductionByDzo(Request $request)
    {
        $factByDzo = DzoImportData::query()
            ->where('dzo_name', $request->dzoName)
            ->orderBy('date', 'desc')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->first()
            ->toArray();
        $factDate = Carbon::parse($factByDzo['date'])->firstOfMonth();
        $planByDzo = DzoPlan::query()
            ->whereDate('date', $factDate)
            ->where('dzo', $request->dzoName)
            ->first()
            ->toArray();
        $planByDzo = $this->deleteDuplicateFields($planByDzo);
        $comparedData[] = array_merge($factByDzo, $planByDzo);
        return response()->json($comparedData);
    }

    public function storeKGMChemistryAndRepairsByMonth(Request $request)
    {
        $date = $request->date;
        $dzoName = 'КГМ';

        $DzoImportChemistry = new DzoImportChemistry();
        $DzoImportChemistry->dzo_name = $dzoName;
        $DzoImportChemistry->date = $date;
        $DzoImportChemistry->demulsifier = $this->getKGMChemistry('DEMULSIFICATOR', $date);
        $DzoImportChemistry->bactericide = $this->getKGMChemistry('BACTERICIDE', $date);
        $DzoImportChemistry->corrosion_inhibitor = $this->getKGMChemistry('COR_ING', $date);
        $DzoImportChemistry->scale_inhibitor = $this->getKGMChemistry('SALT_INHIB', $date);

        $DzoImportRepairs = new DzoImportOtm();
        $DzoImportRepairs->dzo_name = $dzoName;
        $DzoImportRepairs->date = $date;
        $DzoImportRepairs->otm_underground_workover = $this->getKGMRepairs('ПРС%', $date);
        $DzoImportRepairs->otm_well_workover_fact = $this->getKGMRepairs('КРС%', $date);

        $DzoImportChemistry->save();
        $DzoImportRepairs->save();
        return 'Save';
    }

    private function getKGMChemistry($nameOfChemistryValue, $date)
    {
        $chemistry = ChemistryForKGM::query()->select('*')
            ->where('start_datetime', $date)
            ->where('legacy_id', $nameOfChemistryValue)
            ->get()->toArray();
        if (!is_null($chemistry)) {
            return $chemistry['0']['inj_fact_mass'];
        } else {
            echo 'No data ' . $nameOfChemistryValue;
        }
    }

    private function getKGMRepairs($nameOfRepairsValue, $date)
    {
        $month = date('m', strtotime($date));
        $repairs = RepairsForKGM::query()->select('*')
            ->where('end_datetime', 'LIKE', '2021-' . $month . '%')
            ->where('workover', 'LIKE', $nameOfRepairsValue)
            ->get()->toArray();
        if (!is_null($repairs)) {
            return count($repairs);
        } else {
            echo 'No data ' . $nameOfRepairsValue;
        }
    }

    public function storeKGMReportsFromAvocetByDay(Request $request)
    {
        $dzo_summary_last_record = DzoImportData::latest('id')->first();
        $date = $request->date;
        $oilAndGas = $this->getDataFromAvocet(new OilAndGasForKGM, $date);
        $water = $this->getDataFromAvocet(new WaterForKGM, $date);
        $oilDelivery = $this->getDataFromAvocet(new OilDeliveryForKGM, $date);
        $gasMore = $this->getDataFromAvocet(new GasMoreForKGM, $date);
        $fonds = $this->getDataFromAvocet(new FondsForKGM, $date);

        $oilFact = 0;
        $gasFact = 0;
        foreach ($oilAndGas as $rowNum => $row) {

            $oilFact += $row['fact_oil_mass'];
            $gasFact += $row['fact_gas_vol'];
        }     
      
      $agentUploadTotalWaterInjectionFact = $this->valueFromArray($water, 'KGM_INJ_TOTAL', 'fact');
        $oilDeliveryFact = $this->valueFromArray($oilDelivery, 'KGM_DELIVERY', 'fact');
        $stockOfGoodsDeliveryFactAsy = $this->valueFromArray($oilDelivery, 'ASY_D', 'fact');
        $stockOfGoodsDeliveryFactAksh = $this->valueFromArray($oilDelivery, 'AKSH_D', 'fact');
        $stockOfGoodsDeliveryFactNur = $this->valueFromArray($oilDelivery, 'NUR_D', 'fact');
        $stockOfGoodsDeliveryFactTotal = $stockOfGoodsDeliveryFactAksh + $stockOfGoodsDeliveryFactAsy + $stockOfGoodsDeliveryFactNur;
        $associatedGasDeliveryFact = $this->valueFromArray($gasMore, 'KGM_TRANS', 'fact');
        $associatedGasExpensesForOwnFact = $this->valueFromArray($gasMore, 'KGM_UTIL', 'fact');

        $productionFond = 'PRODUCTION';
        $inWorkProductionFond = $this->quantityOfArray($fonds, 'PRODUCING', $productionFond, '');
        $inIdleProductionFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, '');
        $inactiveProductionPrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, 'P_WORK_W_1');
        $inactiveProductionOprsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, 'N_DOWN_T_1');
        $inactiveProductionKrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, 'P_WORK_W_2');
        $inactiveProductionOkrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, 'N_DOWN_T_2');
        $inactiveProductionOtherFond = $this->quantityOfArray($fonds, 'SHUT_IN', $productionFond, 'N_D_D_1');
        $inactiveProductionFond = $this->quantityOfArray($fonds, 'IDLE', $productionFond, '');
        $developingProductionFond = $this->quantityOfArray($fonds, 'DEVELOPMENT', $productionFond, '');
        $pendingLiquidationProductionFond = $this->quantityOfArray($fonds, 'ABANDON', $productionFond, '');
        $operatingProductionFond = $inWorkProductionFond + $inIdleProductionFond + $developingProductionFond + $inactiveProductionFond;
        $activeProductionFond = $inWorkProductionFond + $inIdleProductionFond;
        $inConservationProductionFond = $this->quantityOfArray($fonds, 'SUSPENDED', $productionFond, '');

        $injectionFond = 'INJECTION';
        $inWorkInjectionFond = $this->quantityOfArray($fonds, 'PRODUCING', $injectionFond, '');
        $inIdleInjectionFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, '');
        $inactiveInjectionPrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, 'P_WORK_W_1');
        $inactiveInjectionOprsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, 'N_DOWN_T_1');
        $inactiveInjectionKrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, 'P_WORK_W_2');
        $inactiveInjectionOkrsFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, 'N_DOWN_T_2');
        $inactiveInjectionOtherFond = $this->quantityOfArray($fonds, 'SHUT_IN', $injectionFond, 'N_D_D_1');
        $inactiveInjectionFond = $this->quantityOfArray($fonds, 'IDLE', $injectionFond, '');
        $developingInjectionFond = $this->quantityOfArray($fonds, 'DEVELOPMENT', $injectionFond, '');
        $pendingLiquidationInjectionFond = $this->quantityOfArray($fonds, 'ABANDON', $injectionFond, '');
        $operatingInjectionFond = $inWorkInjectionFond + $inIdleInjectionFond + $developingInjectionFond + $inactiveInjectionFond;
        $activeInjectionFond = $inWorkInjectionFond + $inIdleInjectionFond;
        $inConservationInjectionFond = $this->quantityOfArray($fonds, 'SUSPENDED', $injectionFond, '');

        $dzoImportData = new DzoImportData();
        $multiplier  = 1000;
        $dzoImportData->date = $date;
        $dzoImportData->dzo_name = 'КГМ';
        $dzoImportData->oil_production_fact = $oilFact;
        $dzoImportData->associated_gas_production_fact = $gasFact*$multiplier ;
        $dzoImportData->agent_upload_total_water_injection_fact = $agentUploadTotalWaterInjectionFact*$multiplier ;
        $dzoImportData->oil_delivery_fact = $oilDeliveryFact;
        $dzoImportData->associated_gas_delivery_fact = $associatedGasDeliveryFact*$multiplier ;
        $dzoImportData->associated_gas_expenses_for_own_fact = $associatedGasExpensesForOwnFact*$multiplier ;
        $dzoImportData->stock_of_goods_delivery_fact = $stockOfGoodsDeliveryFactTotal;

        $dzoImportData->in_work_production_fond = $inWorkProductionFond;
        $dzoImportData->in_idle_production_fond = $inIdleProductionFond;
        $dzoImportData->inactive_production_fond = $inactiveProductionFond;
        $dzoImportData->developing_production_fond = $developingProductionFond;
        $dzoImportData->pending_liquidation_production_fond = $pendingLiquidationProductionFond;
        $dzoImportData->operating_production_fond = $operatingProductionFond;
        $dzoImportData->active_production_fond = $activeProductionFond;

        $dzoImportData->in_work_injection_fond = $inWorkInjectionFond;
        $dzoImportData->in_idle_injection_fond = $inIdleInjectionFond;
        $dzoImportData->inactive_injection_fond = $inactiveInjectionFond;
        $dzoImportData->developing_injection_fond = $developingInjectionFond;
        $dzoImportData->pending_liquidation_injection_fond = $pendingLiquidationInjectionFond;
        $dzoImportData->operating_injection_fond = $operatingInjectionFond;
        $dzoImportData->active_injection_fond = $activeInjectionFond;
        $dzoImportData->otm_underground_workover = $inactiveProductionPrsFond;
        $dzoImportData->otm_well_workover_fact = $inactiveInjectionKrsFond;

        $dzoImportData->save();

        $downtimeReason = new DzoImportDowntimeReason();
        $downtimeReason->dzo_import_data_id = $dzo_summary_last_record['id'] + 1;

        $downtimeReason->prs_downtime_production_wells_count = $inactiveProductionPrsFond;
        $downtimeReason->krs_downtime_production_wells_count = $inactiveProductionKrsFond;
        $downtimeReason->other_downtime_production_wells_count = $inactiveProductionOtherFond;
        $downtimeReason-> prs_wait_downtime_production_wells_count = $inactiveProductionOprsFond;
        $downtimeReason->krs_wait_downtime_production_wells_count = $inactiveProductionOkrsFond;
        $downtimeReason->well_survey_downtime_production_wells_count = $this->valueFromArrayWellSurvey($fonds, $productionFond);

        $downtimeReason->prs_downtime_injection_wells_count = $inactiveInjectionPrsFond;
        $downtimeReason->krs_downtime_injection_wells_count = $inactiveInjectionKrsFond;
        $downtimeReason->other_downtime_injection_wells_count = $inactiveInjectionOtherFond; 
        $downtimeReason->prs_wait_downtime_injection_wells_count = $inactiveInjectionOprsFond;      
        $downtimeReason->krs_wait_downtime_injection_wells_count = $inactiveInjectionOkrsFond;           
        $downtimeReason->well_survey_downtime_injection_wells_count = $this->valueFromArrayWellSurvey($fonds, $injectionFond);
        $downtimeReason->save();

    }

    private function getDataFromAvocet($nameData, $date)
    {
        return $nameData::query()->select('*')
            ->WHERE('start_datetime', 'LIKE', $date . '%')
            ->get()->toArray();       

    }

    public function valueFromArray($data, $column1, $column2)
    {
        foreach ($data as $rowNum => $row) {
            if ($row['legacy_id'] == $column1) {
                return $row[$column2];
            }
        }
    }

    public function quantityOfArray($data, $column1, $column2, $column3)
    {

        $summ = [];

        foreach ($data as $rowNum => $row) {
            if ($row['type'] == $column2) {
                if ($row['status'] == $column1) {

                    if ($row['cattegory_code']==null) {
                        if ($row['cattegory_code'] == $column3) {
                            $summ[] = array_merge($row);}
                    } else { $summ[] = array_merge($row);}
                }
            }}
        return count($summ);
    }

    public function valueFromArrayWellSurvey($data, $column1)
    {
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if ($row['type'] == $column1) {
                if ($row['category2'] == 'Исследование') {
                    $summ[] = array_merge($row);
                }}
        }
        return count($summ);
    }
}
