<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetDataHiveController extends Controller
{
    public function getData(Request $request)
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
        $alldata = new DzoImportData;
        $alldata->date = Carbon::yesterday();
        $alldata->dzo_name = 'КГМ';
        $alldata->oil_production_fact = $oilFact;
        $alldata->natural_gas_production_fact = $gasFact * 1000;
        $alldata->agent_upload_total_water_injection_fact = $liqFact;
        $alldata->save();
    }

    public function GetDataHive()
    {
        return view('visualcenter.getDataHive');
    }
}
