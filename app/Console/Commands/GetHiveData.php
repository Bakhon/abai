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

    public function getHiveData()
    {
        require_once public_path() . '\php-thrift-sql\ThriftSQL.phar';

        $date = Carbon::yesterday();
        $hive = new \ThriftSQL\Hive('172.20.103.38', 10000, 'hive', 'hive');
        $hiveTables = $hive->connect()->getIterator("select * from kazger.KMG_I_PRD_AREA_VIEW where start_datetime >= '" . $date . "'");
        $oilFact  = 0;
        $oilPlan  = 0;
        $gasFact  = 0;
        $gasPlan  = 0;
        $liqFact  = 0;
        $liqPlan  = 0;
        foreach ($hiveTables as $rowNum => $row) {
            $hiveData[] = array_merge($row);
            $oilFact += $row[4];
            $oilPlan += $row[5];
            $gasFact += $row[6];
            $gasPlan += $row[7];
            $liqFact += $row[8];
            $liqPlan += $row[9];
        }

        $hive->disconnect();
        $alldata = new DzoImportData();
        $alldata->date = $date;
        $alldata->dzo_name = 'КГМ';
        $alldata->oil_production_fact = $oilFact;  
        $alldata->agent_upload_total_water_injection_fact = $liqFact;
        $alldata->save();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $this->getHiveData();
    }
}
