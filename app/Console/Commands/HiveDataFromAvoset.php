<?php

namespace App\Console\Commands;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HiveDataFromAvoset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hive-data-from-avoset:cron';

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

    public function hiveDataFromAvoset($table, $date)
    {
        require_once app_path() . '\libs\php-thrift-sql\ThriftSQL.phar';


       //$hive = new \ThriftSQL\Hive(env('SERVER_HIVE_FROM_AVOCET', '172.20.103.38'), 10000, 'hive', 'hive');
     
       //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime >= '2021-04-05 %' and category3 like'%ПРС%' or category4 like '%ПРС%'");
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime >= '2021-04-05 %'and category3 like'%КРС%' or category4 like '%КРС%'");
  
  
  
     //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2019-01-30' and '2021-05-05' and category4 like '%ОПРС%'");
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2019-01-30' and '2021-05-05' and category4 like '%КРС%'");
    
    
    
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2019-01-30' and '2021-05-05' and details like '%ПРС.%'");
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2019-01-30' and '2021-05-05' and details like '%КРС%'");
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2019-01-30' and '2021-05-05' and details like '%ОПРС%'");
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2021-05-04' and '2021-05-05' and details like '%Остановка%'");//простой
    //$hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime BETWEEN '2021-01-04' and '2021-05-05' and category4 like '%Прочие%'");
    
    //$hiveTables = $hive->connect()->getIterator( "select *  from  kazger.KMG_I_WELL_STOCK_VIEW wt left outer join kazger.OFM_MASTER as mast on mast.WELLNAME = wt.WELLNAME where wt.START_DATETIME like '2021-04-27%' ");
  //$hiveTables = $hive->connect()->getIterator( "select distinct STATUS, STATUS_TEXT from kazger.KMG_I_WELL_STOCK_VIEW where start_datetime BETWEEN '2021-01-04' and '2021-05-05'");


   $impala = new \ThriftSQL\Impala( '172.20.103.38', 10000, 'hive', 'hive' );
   $hiveTables = $impala
  ->connect()
  ->setOption( 'MEM_LIMIT', '1gb' ) 
  ->getIterator( "select * from kazger.OFM_DOWNTIME_VIEW where start_datetime BETWEEN '2021-01-04' and '2021-05-05' and category4 like '%Прочие%'");
  
        foreach ($hiveTables as $rowNum => $row) {
            $dataMass[] = array_merge($row);
        }
        return $dataMass;
        //print_r( $dataMass );
        dd($dataMass);
        
    }
 
    public function saveHiveDataFromAvoset()
    {
        $date = Carbon::yesterday();
       /* $dataOilAndGas =  $this->hiveDataFromAvoset('KMG_I_PRD_AREA_VIEW', $date);
        $dataWater =  $this->hiveDataFromAvoset('KMG_I_MTR_INJ_VIEW', $date);
        $dataOilDelivery =  $this->hiveDataFromAvoset('KMG_I_MTR_PROD_VIEW', $date);
        $dataGasMore =  $this->hiveDataFromAvoset('KMG_I_MTR_GAS_VIEW', $date);
        $fonds  =  $this->hiveDataFromAvoset('KMG_I_WELL_STOCK_VIEW', $date);*/
        $downtime  =  $this->hiveDataFromAvoset('OFM_DOWNTIME_VIEW', '%');
dd($downtime);
        
        $oilFact  = 0;
        $gasFact  = 0;
        foreach ($dataOilAndGas as $rowNum => $row) {
            $oilFact += $row[4];
            $gasFact += $row[6];
        }

        $agentUploadTotalWaterInjectionFact = $this->valueFromArray($dataWater, 'KGM_INJ_TOTAL', 10);
        $oilDeliveryFact = $this->valueFromArray($dataOilDelivery, 'KGM_DELIVERY', 10);
        $stockOfGoodsDeliveryFactAsy = $this->valueFromArray($dataOilDelivery, 'ASY_D', 10);
        $stockOfGoodsDeliveryFactAksh = $this->valueFromArray($dataOilDelivery, 'AKSH_D', 10);
        $stockOfGoodsDeliveryFactNur = $this->valueFromArray($dataOilDelivery, 'NUR_D', 10);
        $stockOfGoodsDeliveryFactTotal =  $stockOfGoodsDeliveryFactAksh + $stockOfGoodsDeliveryFactAsy + $stockOfGoodsDeliveryFactNur;
        $associatedGasDeliveryFact = $this->valueFromArray($dataGasMore, 'KGM_TRANS', 10);
        $associatedGasExpensesForOwnFact = $this->valueFromArray($dataGasMore, 'KGM_UTIL', 10);
      
        $productionFond='PRODUCTION';        
        $inWorkProductionFond = $this->quantityOfArray($fonds, 'PRODUCING',$productionFond);
        $inIdleProductionFond = $this->quantityOfArray($fonds, 'SHUT_IN',$productionFond);
        $inactiveProductionFond = $this->quantityOfArray($fonds, 'IDLE',$productionFond);
        $developingProductionFond = $this->quantityOfArray($fonds, 'DEVELOPMENT',$productionFond);
        $pendingLiquidationProductionFond = $this->quantityOfArray($fonds, 'ABANDON',$productionFond);
        $operatingProductionFond = $inWorkProductionFond+$inIdleProductionFond+$developingProductionFond;
        $activeProductionFond = $inWorkProductionFond+$inIdleProductionFond;
        $inConservationProductionFond=$this->quantityOfArray($fonds, 'SUSPENDED',$productionFond);

        $injectionFond='INJECTION';
        $inWorkInjectionFond = $this->quantityOfArray($fonds, 'PRODUCING',$injectionFond);
        $inIdleInjectionFond = $this->quantityOfArray($fonds, 'SHUT_IN',$injectionFond);
        $inactiveInjectionFond = $this->quantityOfArray($fonds, 'IDLE',$injectionFond);
        $developingInjectionFond = $this->quantityOfArray($fonds, 'DEVELOPMENT',$injectionFond);
        $pendingLiquidationInjectionFond = $this->quantityOfArray($fonds, 'ABANDON',$injectionFond);
        $operatingInjectionFond = $inWorkInjectionFond+$inIdleInjectionFond+$developingInjectionFond;
        $activeInjectionFond = $inWorkInjectionFond+$inIdleInjectionFond;
        $inConservationInjectionFond=$this->quantityOfArray($fonds, 'SUSPENDED',$injectionFond);
         
        $alldata = new DzoImportData();
        $alldata->date = $date;
        $alldata->dzo_name = 'КГМ';
        $alldata->oil_production_fact = $oilFact;
        $alldata->associated_gas_production_fact = $gasFact;
        $alldata->agent_upload_total_water_injection_fact = $agentUploadTotalWaterInjectionFact;
        $alldata->oil_delivery_fact = $oilDeliveryFact;
        $alldata->associated_gas_delivery_fact = $associatedGasDeliveryFact;
        $alldata->associated_gas_expenses_for_own_fact = $associatedGasExpensesForOwnFact;
        $alldata->stock_of_goods_delivery_fact = $stockOfGoodsDeliveryFactTotal;

        $alldata->in_work_production_fond = $inWorkProductionFond;
        $alldata->in_idle_production_fond = $inIdleProductionFond; 
        $alldata->inactive_production_fond = $inactiveProductionFond; 
        $alldata->developing_production_fond = $developingProductionFond; 
        $alldata->pending_liquidation_production_fond = $pendingLiquidationProductionFond;
        $alldata-> operating_production_fond = $operatingProductionFond;
        $alldata-> active_production_fond= $activeProductionFond;

        $alldata->in_work_injection_fond = $inWorkInjectionFond; 
        $alldata->in_idle_injection_fond = $inIdleInjectionFond; 
        $alldata->inactive_injection_fond = $inactiveInjectionFond; 
        $alldata->developing_injection_fond = $developingInjectionFond; 
        $alldata->pending_liquidation_injection_fond = $pendingLiquidationInjectionFond; 
        $alldata-> operating_injection_fond = $operatingInjectionFond; 
        $alldata-> active_injection_fond= $activeInjectionFond;

        $alldata->save();
    }

    public function valueFromArray($data, $field, $column)
    {
        foreach ($data as $rowNum => $row) {
            if ($row[4] == $field) {
                return  $row[$column];
            }
        }
    }

    public function quantityOfArray($data, $field,$field2)
    {

        $summ = [];

        foreach ($data as $rowNum => $row) {
            if ($row[3] == $field2) {
            if ($row[5] == $field) {
                $summ[] = array_merge($row);
            }
        }}
        return count($summ);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $this->saveHiveDataFromAvoset();
    }
}
