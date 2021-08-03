<?php

namespace App\Console\Commands;

use App\Models\VisCenter\DataForKGM\Daily\FondsForKGM;
use App\Models\VisCenter\DataForKGM\Daily\GasForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilAndGasForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilDeliveryForKGM;
use App\Models\VisCenter\DataForKGM\Daily\WaterForKGM;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreKGMReportsFromAvocetByDay extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store-kgm-reports-from-avocet:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is designed to copy some fields from hive';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function store()
    {

    }

    public function storeKGMReportsFromAvocetByDay()
    {
        $path = resource_path() . "/js/components/visualcenter3/dailyReportImport/fields_kgm_reports_mapping.json";
        $fields_data = json_decode(file_get_contents($path), true);
        $dzo_summary_last_record = DzoImportData::latest('id')->first();
        $date = Carbon::yesterday();

        $dzo_import_field_data = new DzoImportData();

        $multiplier = 1000;
        /*foreach ($fields_data as $field_name => $field) {
        $dzo_import_field_data->$field_name = $this->getWaterOilDeliveryAndGasMore( );
        }*/

        $this->getFilds($fields_data['getWaterOilDeliveryAndGasMore'], $dzo_import_field_data, 'getWaterOilDeliveryAndGasMore', $date, $multiplier);

        $dzo_import_field_data->date = $date;
        $dzo_import_field_data->dzo_name = 'КГМ';
        $dzo_import_field_data->oil_production_fact = $this->getOilAndGas('fact_oil_mass', $date);
        $dzo_import_field_data->associated_gas_production_fact = $this->getOilAndGas('fact_gas_vol', $date) * $multiplier;
        $dzo_import_field_data->stock_of_goods_delivery_fact = $dzo_import_field_data['ASY_D'] + $dzo_import_field_data['AKSH_D'] + $dzo_import_field_data['NUR_D'];
        unset($dzo_import_field_data['ASY_D']);
        unset($dzo_import_field_data['AKSH_D']);
        unset($dzo_import_field_data['NUR_D']);

        
    
        if (isset($fields_data['production_fond'])){
        $this->getFilds($fields_data['production_fond'], $dzo_import_field_data, 'quantityOfArray', $date, '');
        }

        dd($dzo_import_field_data);
        
            $dzo_import_field_data->save();

        
       // print_r($dzo_import_field_data);
   
        
       
       
        
      

        $productionFond = 'PRODUCTION';
        // $inWorkProductionFond = $this->quantityOfArray( 'PRODUCING', $productionFond, '');
        //$inIdleProductionFond = $this->quantityOfArray( 'SHUT_IN', $productionFond, '');
        $inactiveProductionPrsFond = $this->quantityOfArray('SHUT_IN', $productionFond, 'P_WORK_W_1');
        $inactiveProductionOprsFond = $this->quantityOfArray('SHUT_IN', $productionFond, 'N_DOWN_T_1');
        $inactiveProductionKrsFond = $this->quantityOfArray('SHUT_IN', $productionFond, 'P_WORK_W_2');
        $inactiveProductionOkrsFond = $this->quantityOfArray('SHUT_IN', $productionFond, 'N_DOWN_T_2');
        $inactiveProductionOtherFond = $this->quantityOfArray('SHUT_IN', $productionFond, 'N_D_D_1');
        //$inactiveProductionFond = $this->quantityOfArray( 'IDLE', $productionFond, '');
        // $developingProductionFond = $this->quantityOfArray( 'DEVELOPMENT', $productionFond, '');
        //$pendingLiquidationProductionFond = $this->quantityOfArray( 'ABANDON', $productionFond, '');
        $operatingProductionFond = $inWorkProductionFond + $inIdleProductionFond + $developingProductionFond + $inactiveProductionFond;
        $activeProductionFond = $inWorkProductionFond + $inIdleProductionFond;
        $inConservationProductionFond = $this->quantityOfArray('SUSPENDED', $productionFond, '');

        $injectionFond = 'INJECTION';
        $inWorkInjectionFond = $this->quantityOfArray('PRODUCING', $injectionFond, '');
        $inIdleInjectionFond = $this->quantityOfArray('SHUT_IN', $injectionFond, '');
        $inactiveInjectionPrsFond = $this->quantityOfArray('SHUT_IN', $injectionFond, 'P_WORK_W_1');
        $inactiveInjectionOprsFond = $this->quantityOfArray('SHUT_IN', $injectionFond, 'N_DOWN_T_1');
        $inactiveInjectionKrsFond = $this->quantityOfArray('SHUT_IN', $injectionFond, 'P_WORK_W_2');
        $inactiveInjectionOkrsFond = $this->quantityOfArray('SHUT_IN', $injectionFond, 'N_DOWN_T_2');
        $inactiveInjectionOtherFond = $this->quantityOfArray('SHUT_IN', $injectionFond, 'N_D_D_1');
        $inactiveInjectionFond = $this->quantityOfArray('IDLE', $injectionFond, '');
        $developingInjectionFond = $this->quantityOfArray('DEVELOPMENT', $injectionFond, '');
        $pendingLiquidationInjectionFond = $this->quantityOfArray('ABANDON', $injectionFond, '');
        $operatingInjectionFond = $inWorkInjectionFond + $inIdleInjectionFond + $developingInjectionFond + $inactiveInjectionFond;
        $activeInjectionFond = $inWorkInjectionFond + $inIdleInjectionFond;
        $inConservationInjectionFond = $this->quantityOfArray('SUSPENDED', $injectionFond, '');

        //$dzoImportData
        $dzo_import_field_data->in_work_production_fond = $inWorkProductionFond;
        $dzo_import_field_data->in_idle_production_fond = $inIdleProductionFond;
        $dzo_import_field_data->inactive_production_fond = $inactiveProductionFond;
        $dzo_import_field_data->developing_production_fond = $developingProductionFond;
        $dzo_import_field_data->pending_liquidation_production_fond = $pendingLiquidationProductionFond;
        $dzo_import_field_data->operating_production_fond = $operatingProductionFond;
        $dzo_import_field_data->active_production_fond = $activeProductionFond;

        $dzo_import_field_data->in_work_injection_fond = $inWorkInjectionFond;
        $dzo_import_field_data->in_idle_injection_fond = $inIdleInjectionFond;
        $dzo_import_field_data->inactive_injection_fond = $inactiveInjectionFond;
        $dzo_import_field_data->developing_injection_fond = $developingInjectionFond;
        $dzo_import_field_data->pending_liquidation_injection_fond = $pendingLiquidationInjectionFond;
        $dzo_import_field_data->operating_injection_fond = $operatingInjectionFond;
        $dzo_import_field_data->active_injection_fond = $activeInjectionFond;
        $dzo_import_field_data->otm_underground_workover = $inactiveProductionPrsFond;
        $dzo_import_field_data->otm_well_workover_fact = $inactiveInjectionKrsFond;

        
        /*
    $downtimeReason = new DzoImportDowntimeReason();
    $downtimeReason->dzo_import_data_id = $dzo_summary_last_record['id'] + 1;

    $downtimeReason->prs_downtime_production_wells_count = $inactiveProductionPrsFond;
    $downtimeReason->krs_downtime_production_wells_count = $inactiveProductionKrsFond;
    $downtimeReason->other_downtime_production_wells_count = $inactiveProductionOtherFond;
    $downtimeReason->prs_wait_downtime_production_wells_count = $inactiveProductionOprsFond;
    $downtimeReason->krs_wait_downtime_production_wells_count = $inactiveProductionOkrsFond;
    $downtimeReason->well_survey_downtime_production_wells_count = $this->getCountByDowntimeWells($fonds, $productionFond);

    $downtimeReason->prs_downtime_injection_wells_count = $inactiveInjectionPrsFond;
    $downtimeReason->krs_downtime_injection_wells_count = $inactiveInjectionKrsFond;
    $downtimeReason->other_downtime_injection_wells_count = $inactiveInjectionOtherFond;
    $downtimeReason->prs_wait_downtime_injection_wells_count = $inactiveInjectionOprsFond;
    $downtimeReason->krs_wait_downtime_injection_wells_count = $inactiveInjectionOkrsFond;
    $downtimeReason->well_survey_downtime_injection_wells_count = $this->getCountByDowntimeWells($fonds, $injectionFond);
    $downtimeReason->save();
     */

    }

    private function getDataFromBD($nameData, $date)
    {
        return $nameData::query()->select('*')
            ->WHERE('start_datetime', 'LIKE', $date . '%')
            ->get()->toArray();

    }

    public function getWaterOilDeliveryAndGasMore($column1, $date, $multiplier)
    {
        if ($column1 == "KGM_INJ_TOTAL") {
            $data = $this->getDataFromBD(new WaterForKGM, $date);} elseif ($column1 == "KGM_DELIVERY") {
            $data = $this->getDataFromBD(new OilDeliveryForKGM, $date);} elseif ($column1 == "ASY_D") {
            $data = $this->getDataFromBD(new OilDeliveryForKGM, $date);} elseif ($column1 == "AKSH_D") {
            $data = $this->getDataFromBD(new OilDeliveryForKGM, $date);} elseif ($column1 == "NUR_D") {
            $data = $this->getDataFromBD(new OilDeliveryForKGM, $date);} elseif ($column1 == "KGM_TRANS") {
            $data = $this->getDataFromBD(new GasMoreForKGM, $date);} elseif ($column1 == "KGM_UTIL") {
            $data = $this->getDataFromBD(new GasMoreForKGM, $date);}

        if (isset($data)) {
            foreach ($data as $rowNum => $row) {
                if ($row['legacy_id'] == $column1) {
                    if (($column1 == 'KGM_INJ_TOTAL') or ($column1 == 'KGM_TRANS') or ($column1 == 'KGM_UTIL')) {
                        return $row['fact'] * $multiplier;
                    } else {return $row['fact'];}
                }
            }}
    }

    public function quantityOfArray($column1, $column2, $column3, $date)
    {

        
        $data = $this->getDataFromBD(new FondsForKGM, $date);

        $summ = [];

        foreach ($data as $rowNum => $row) {
            if ($row['type'] == $column2) {
                if ($row['status'] == $column1) {

                    if ($row['cattegory_code'] !== null) {
                        $summ[] = array_merge($row);
                    } else {
                        if ($row['cattegory_code'] == $column3) {
                            $summ[] = array_merge($row);
                        }
                    }

                }
            }}        
        return count($summ);        
    }

    public function getCountByDowntimeWells($data, $column1)
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

    public function getOilAndGas($column1, $date)
    {
        $oilAndGas = $this->getDataFromBD(new OilAndGasForKGM, $date);
        $data = 0;
        foreach ($oilAndGas as $rowNum => $row) {
            $data += $row[$column1];
        }
        return $data;
    }

    public function getFilds($fields_data, $dzo_import_field_data, $function, $date, $multiplier)
    {

        foreach ($fields_data as $field_name => $field) {           
            if ($function == 'getWaterOilDeliveryAndGasMore') {
                $dzo_import_field_data->$field_name = $this->getWaterOilDeliveryAndGasMore($field, $date, $multiplier);
            }
            if ($function == 'quantityOfArray') {                
                $dzo_import_field_data->$field_name = $this->quantityOfArray($field, 'PRODUCTION', '', $date);
            }

        }
        return $dzo_import_field_data;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $this->storeKGMReportsFromAvocetByDay();
    }
}
