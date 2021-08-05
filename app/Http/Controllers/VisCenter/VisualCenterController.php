<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VisCenter\ImportForms\DZOyearController;
use App\Imports\DZOyearImport;
use App\Models\DZO\DZOcalc;
use App\Models\UsdRate;
use App\Models\OilRate;
use App\Models\DZOyear;
use App\Models\VisCenter\ImportForms\DZOcalc as ImportFormsDZOcalc;
use App\Models\VisCenter\ImportForms\DZOstaff;
use App\Models\VisCenter\ImportForms\DZOdaily as ImportFormsDZOdaily;
use App\Models\VisCenter\ImportForms\DZOyear as ImportFormsDZOyear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DzoPlan;
use App\Http\Controllers\VisCenter\ExcelForm\ExcelFormController;
use App\Http\Controllers\VisCenter\ExcelForm\ExcelFormChemistryController;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use App\Models\VisCenter\ExcelForm\DzoImportDecreaseReason;
use Carbon\Carbon;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;
use App\Models\VisCenter\EmergencyHistory;
use App\Models\VisCenter\DataForKGM\Monthly\ChemistryForKGM;
use App\Models\VisCenter\DataForKGM\Monthly\RepairsForKGM;

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

    public function getOilRates() {
      $oilRatesData = OilRate::query()
          ->get()
          ->toArray();
      return response()->json($oilRatesData);
    }

    public function getDzoMonthlyPlans() {
          $dzoMonthlyPlans = dzoPlan::query()
              ->get()
              ->toArray();
          return response()->json($dzoMonthlyPlans);
        }

    public function getDzoYearlyPlan() {
        $dzoYearlyPlan = DZOyear::query()
            ->where('date',date("Y"))
            ->select('dzo','oil_plan','oil_opek_plan')
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

    function getCurrencyPeriod(Request $request)
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
                        $array[$i] =  array(
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
            ->whereDate('date','>', $startPeriod)
            ->whereDate('date','<=', $endPeriod)
            ->whereNull('is_corrected')
            ->with('importDowntimeReason')
            ->with('importDecreaseReason')
            ->get()
            ->toArray();

        $planData = $this->getPlanDetails();
        $comparedData = $this->getComparedPlanFactData($planData,$factDataByPeriod);
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
            $planRecord = $this->getPlanForRecord($item['dzo_name'],$parsedDate,$planData);
            $planRecord = $this->deleteDuplicateFields($planRecord);
            $comparedData[] = array_merge($item,$planRecord);
        }
        return $comparedData;
    }

    private function getPlanForRecord($dzoName, $date, $planData)
    {
        $searchedRecord = $planData->where('dzo',$dzoName)->where('date',$date);
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
            5 => 'dzo_name'
        ];
        foreach($fields as $item) {
            unset($planRecord[$item]);
        }
        return $planRecord;
    }

    public function getDrillingDetails(Request $request)
    {
        return DzoImportData::query()
            ->select('date','dzo_name','otm_drilling_fact','otm_wells_commissioning_from_drilling_fact')
            ->whereNull('is_corrected')
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
            ->whereNull('is_corrected')
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
            ->whereNull('is_corrected')
            ->with('importDecreaseReason')
            ->get()
            ->toArray();
    }
    public function getEmergencyHistory(Request $request)
    {
        return EmergencyHistory::query()
            ->select(DB::raw('DATE_FORMAT(date,"%d.%m.%Y") as date'),'title','description')
            ->whereMonth('date', $request->currentMonth)
            ->where('type',1)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function getHistoricalProductionByDzo(Request $request)
    {
        $factByDzo = DzoImportData::query()
            ->where('dzo_name', $request->dzoName)
            ->whereNull('is_corrected')
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
        $comparedData[] = array_merge($factByDzo,$planByDzo);
        return response()->json($comparedData);
    }

    public function storeKGMChemistryAndRepairsByMonth(Request $request)
    {
        $date = $request->date;
        $dzoName='КГМ';

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
            echo 'No data '.$nameOfChemistryValue;
        }
    }

    private function getKGMRepairs($nameOfRepairsValue, $date)
    {
        $month = date('m', strtotime($date));
        $repairs = RepairsForKGM::query()->select('*')          
            ->where('end_datetime','LIKE','2021-'.$month.'%')
            ->where('workover','LIKE', $nameOfRepairsValue)
            ->get()->toArray();      
        if (!is_null($repairs)) {
           return count($repairs);
        } else {
            echo 'No data '.$nameOfRepairsValue;
        }
    }

    public function dailyApprove()
        {
            return view('visualcenter.daily_approve');
        }
}
