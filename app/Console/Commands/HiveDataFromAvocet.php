<?php

namespace App\Console\Commands;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HiveDataFromAvocet extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hive-data-from-avocet:cron';

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

    public function hiveDataFromAvocet($table, $date)
    {
        require_once app_path() . '/Libs/php-thrift-sql/ThriftSQL.phar';
        $hive = new \ThriftSQL\Hive(env('MIX_SERVER_HIVE_FROM_AVOCET'), 10000, 'hive', 'hive');
        $hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime like '" . $date . "%'");
        $dataMass = [];
        foreach ($hiveTables as $rowNum => $row) {
            $dataMass[] = array_merge($row);
        }
        return $dataMass;
    }

    public function saveHiveDataFromAvocet()
    {
        $dzo_summary_last_record = DzoImportData::latest('id')->first();
        $date = Carbon::yesterday();        
        $dataOilAndGas = $this->hiveDataFromAvocet('KMG_I_PRD_AREA_VIEW', $date);
        $dataWater = $this->hiveDataFromAvocet('KMG_I_MTR_INJ_VIEW', $date);
        $dataOilDelivery = $this->hiveDataFromAvocet('KMG_I_MTR_PROD_VIEW', $date);
        $dataGasMore = $this->hiveDataFromAvocet('KMG_I_MTR_GAS_VIEW', $date);
        $fonds = $this->hiveDataFromAvocet('KMG_I_WELL_STOCK_VIEW', $date);

        $oilFact = 0;
        $gasFact = 0;
        foreach ($dataOilAndGas as $rowNum => $row) {
            $oilFact += $row[4];
            $gasFact += $row[6];
        }

        $agentUploadTotalWaterInjectionFact = $this->valueFromArray($dataWater, 'KGM_INJ_TOTAL', 10);
        $oilDeliveryFact = $this->valueFromArray($dataOilDelivery, 'KGM_DELIVERY', 10);
        $stockOfGoodsDeliveryFactAsy = $this->valueFromArray($dataOilDelivery, 'ASY_D', 10);
        $stockOfGoodsDeliveryFactAksh = $this->valueFromArray($dataOilDelivery, 'AKSH_D', 10);
        $stockOfGoodsDeliveryFactNur = $this->valueFromArray($dataOilDelivery, 'NUR_D', 10);
        $stockOfGoodsDeliveryFactTotal = $stockOfGoodsDeliveryFactAksh + $stockOfGoodsDeliveryFactAsy + $stockOfGoodsDeliveryFactNur;
        $associatedGasDeliveryFact = $this->valueFromArray($dataGasMore, 'KGM_TRANS', 10);
        $associatedGasExpensesForOwnFact = $this->valueFromArray($dataGasMore, 'KGM_UTIL', 10);

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

    public function valueFromArray($data, $column1, $column2)
    {
        foreach ($data as $rowNum => $row) {
            if ($row[4] == $column1) {
                return $row[$column2];
            }
        }
    }

    public function quantityOfArray($data, $column1, $column2, $column3)
    {

        $summ = [];

        foreach ($data as $rowNum => $row) {
            if ($row[3] == $column2) {
                if ($row[5] == $column1) {

                    if ($row[17]==null) {
                        if ($row[17] == $column3) {
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
            if ($row[3] == $column1) {
                if ($row[14] == 'Исследование') {
                    $summ[] = array_merge($row);
                }}
        }
        return count($summ);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $this->saveHiveDataFromAvocet();
    }
}
