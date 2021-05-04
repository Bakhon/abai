<?php

namespace App\Console\Commands;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class GetHiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-hive:cron';

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

    public function getHiveData($table, $date)
    {
        require_once public_path() . '\php-thrift-sql\ThriftSQL.phar';

        $hive = new \ThriftSQL\Hive('172.20.103.38', 10000, 'hive', 'hive');
        $hiveTables = $hive->connect()->getIterator("select * from kazger." . $table . " where start_datetime like '" . $date . "%'");
        foreach ($hiveTables as $rowNum => $row) {
            $dataMass[] = array_merge($row);
        }
        return $dataMass;
    }

    public function saveHiveData()
    {
        require_once public_path() . '\php-thrift-sql\ThriftSQL.phar';
        $date = Carbon::yesterday();
        $dataOilAndGas =  $this->getHiveData('KMG_I_PRD_AREA_VIEW', $date);
        $dataWater =  $this->getHiveData('KMG_I_MTR_INJ_VIEW', $date);
        $dataOilDelivery =  $this->getHiveData('KMG_I_MTR_PROD_VIEW', $date);
        $dataGasMore =  $this->getHiveData('KMG_I_MTR_GAS_VIEW', $date);

        $oilFact  = 0;
        $gasFact  = 0;
        foreach ($dataOilAndGas as $rowNum => $row) {
            $oilFact += $row[4];
            $gasFact += $row[6];
        }


        $agentUploadTotalWaterInjectionFact = $this->getDataFromMassive($dataWater, 'KGM_INJ_TOTAL', 10);
        $oilDeliveryFact = $this->getDataFromMassive($dataOilDelivery, 'KGM_DELIVERY', 10);
        $stockOfGoodsDeliveryFactAsy = $this->getDataFromMassive($dataOilDelivery, 'ASY_D', 10);
        $stockOfGoodsDeliveryFactAksh = $this->getDataFromMassive($dataOilDelivery, 'AKSH_D', 10);
        $stockOfGoodsDeliveryFactNur = $this->getDataFromMassive($dataOilDelivery, 'NUR_D', 10);
        $stockOfGoodsDeliveryFactTotal =  $stockOfGoodsDeliveryFactAksh + $stockOfGoodsDeliveryFactAsy + $stockOfGoodsDeliveryFactNur;
        $associatedGasDeliveryFact = $this->getDataFromMassive($dataGasMore, 'KGM_TRANS', 10);

        $alldata = new DzoImportData();
        $alldata->date = $date;
        $alldata->dzo_name = 'КГМ';
        $alldata->oil_production_fact = $oilFact;
        $alldata->associated_gas_production_fact = $gasFact;
        $alldata->agent_upload_total_water_injection_fact = $agentUploadTotalWaterInjectionFact;
        $alldata->oil_delivery_fact = $oilDeliveryFact;
        $alldata->associated_gas_delivery_fact = $associatedGasDeliveryFact;
        $alldata->stock_of_goods_delivery_fact = $stockOfGoodsDeliveryFactTotal;
        dd($alldata);
        $alldata->save();
    }


    public function    getDataFromMassive($data, $field, $column)
    {
        foreach ($data as $rowNum => $row) {
            if ($row[4] == $field) {
                return  $row[$column];
            }
        }
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $this->saveHiveData();
    }
}
