<?php

namespace App\Console\Commands;

use App\Models\VisCenter\InboundIntegration\KGM\Daily\FondsForKGM;
use App\Models\VisCenter\InboundIntegration\KGM\Daily\OilAndGasForKGM;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreKGMReportsFromAvocetByDay extends Command
{
    
    protected $signature = 'store-kgm-reports-from-avocet:cron';
    const ROUNDING_FEW_VALUE = 1000;
    const DZO_NAME = 'КГМ';
    private $yesterdayDate = ''; 
    private $fieldsMapping = '';    

    private function lastRecordKGM()
    {
        return DzoImportData::query()->select('*')
            ->where('dzo_name', '=', self::DZO_NAME)
            ->where('date', '=', $this->yesterdayDate)
            ->whereNull('is_corrected')->first()->id;
    }
    

    public function storeKGMReportsFromAvocetByDay()
    {        
        $this->yesterdayDate=Carbon::yesterday();
        $pathToJsonFieldsMapping = resource_path() . "/js/components/visualcenter3/dailyReportImport/fields_kgm_reports_mapping.json";
        $this->fieldsMapping = json_decode(file_get_contents($pathToJsonFieldsMapping), true);  
        $dzoImportFieldData = new DzoImportData();
        $dzoImportFieldFonds = new FondsForKGM;
        $dzoImportFieldDowntimeReason = new DzoImportDowntimeReason();
        $this->getDzoImportFieldData($dzoImportFieldData, $dzoImportFieldFonds);
        $this->getDowntimeReasonFields($dzoImportFieldDowntimeReason, $dzoImportFieldFonds);
        $this->saveKGMReportsFromAvocetByDay($dzoImportFieldData, $dzoImportFieldDowntimeReason);
    }

    private function getDzoImportFieldData($dzoImportFieldData, $dzoImportFieldFonds)
    {        
        $this->getFields($this->fieldsMapping['getWaterOilDeliveryAndGasMore'], $dzoImportFieldData, 'getWaterOilDeliveryAndGasMore');

        $dzoImportFieldData->date = $this->yesterdayDate;
        $dzoImportFieldData->dzo_name = self::DZO_NAME;
        $dzoImportFieldData->oil_production_fact = $this->getOilAndGas('fact_oil_mass');
        $dzoImportFieldData->associated_gas_production_fact = $this->getOilAndGas('fact_gas_vol') * self::ROUNDING_FEW_VALUE;
        $dzoImportFieldData->stock_of_goods_delivery_fact = $dzoImportFieldData['ASY_D'] + $dzoImportFieldData['AKSH_D'] + $dzoImportFieldData['NUR_D'];
        $fieldsForDelete=['ASY_D','AKSH_D','NUR_D'];        
        for ($i = 0; $i < 3; $i++) {
            unset($dzoImportFieldData[$fieldsForDelete[$i]]);
        }
        $dzoImportFieldData->otm_well_workover_fact = $this->getWellsWorkover($dzoImportFieldData, $dzoImportFieldFonds);
        
        $fieldForFilter=[
            ['getFields','production_fond','dzo_import_field_data','dzo_import_field_data'],
            ['getFields','production_fond','SHUT_IN','SHUT_IN'],
            ['getFieldsInjection','injection_fond','dzo_import_field_data','dzo_import_field_data']
        ]; 

        for ($i = 0; $i < 3; $i++) {
            if (isset($this->fieldsMapping[$fieldForFilter[$i][1]][$fieldForFilter[$i][2]])) {
                $function = $fieldForFilter[$i][0];
                $this->$function($this->fieldsMapping[$fieldForFilter[$i][1]][$fieldForFilter[$i][2]], $dzoImportFieldData, $fieldForFilter[$i][3], '');
            }
        }

        $arr["operating_production_fond"] = ['in_work_production_fond','in_idle_production_fond','developing_production_fond','inactive_injection_fond'];
        $arr["active_production_fond"] = ['in_work_production_fond','in_idle_production_fond'];
        $arr["operating_injection_fond"] = ['in_work_injection_fond','in_idle_injection_fond','developing_injection_fond','inactive_injection_fond'];
        $arr["active_injection_fond"] = ['in_work_injection_fond','in_idle_injection_fond'];

        $sumArray=[];
        $filter=[];
        foreach ($dzoImportFieldData->getAttributes() as $k1 => $valueFond) {
            foreach ($arr as $k2 => $fildName) {
                foreach ($fildName as $k3 => $fildName2) {              
                    if ($k1==$fildName2) {           
                    $filter[$k2][$k1] = $valueFond;                    
                    $dzoImportFieldData->$k2 = array_sum($filter[$k2]);                   
                    }                  
                }  
            }            
        }      
        return $dzoImportFieldData;
    }

    private function getWellsWorkover($dzoImportFieldData, $dzoImportFieldFonds)
    {
        return count($dzoImportFieldFonds::query()->select('*')
            ->WHERE('start_datetime', 'LIKE', $this->yesterdayDate . '%')
            ->WHERE('status', 'SHUT_IN')
            ->WHERE('cattegory_code', 'P_WORK_W_2')
            ->get()->toArray());
      
    }

    private function getDowntimeReasonFields($dzoImportFieldDowntimeReason, $dzoImportFieldFonds)
    {
        $fonds = $this->getDataByType($dzoImportFieldFonds);
        $dzoImportFieldDowntimeReason->well_survey_downtime_production_wells_count = $this->getCountByDowntimeWells($fonds, 'PRODUCTION');
        $dzoImportFieldDowntimeReason->well_survey_downtime_injection_wells_count = $this->getCountByDowntimeWells($fonds, 'INJECTION');        

        if (isset($this->fieldsMapping['production_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFields($this->fieldsMapping['production_fond']['SHUT_IN_downtimeReason'], $dzoImportFieldDowntimeReason, 'SHUT_IN_downtimeReason', '');
        }

        if (isset($this->fieldsMapping['injection_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFieldsInjection($this->fieldsMapping['injection_fond']['SHUT_IN_downtimeReason'], $dzoImportFieldDowntimeReason, 'SHUT_IN_downtimeReason', '');
        }
        return $dzoImportFieldDowntimeReason;
    }

    private function getDataByType($nameData)
    {
        return $nameData::query()->select('*')
            ->WHERE('start_datetime', 'LIKE', $this->yesterdayDate . '%')
            ->get()->toArray();
    }

    private function getWaterOilDeliveryAndGasMore($fieldName)
    {
        $column_names = array(
            "KGM_INJ_TOTAL" => "WaterForKGM",
            "KGM_DELIVERY" => "OilDeliveryForKGM",
            "ASY_D" => "OilDeliveryForKGM",
            "AKSH_D" => "OilDeliveryForKGM",
            "NUR_D" => "OilDeliveryForKGM",
            "KGM_TRANS" => "GasForKGM",
            "KGM_UTIL" => "GasForKGM",
        );
        $pathOfClasses = "\App\Models\VisCenter\InboundIntegration\KGM\Daily";
        foreach ($column_names as $key => $value) {
            if ($fieldName == $key) {
                $class = $pathOfClasses . "\\" . $value;
                $data = $this->getDataByType(new $class);

                if (empty($data)) {
                    return 0;
                }
                foreach ($data as $rowNum => $row) {
                    if ($row['legacy_id'] == $fieldName) {
                        return $this->getFactBy($row, $fieldName);
                    }
                }
            }
        }
    }

    private function getFactBy($row, $fieldName){
        if (($fieldName == 'KGM_INJ_TOTAL') || ($fieldName == 'KGM_TRANS') || ($fieldName == 'KGM_UTIL')) {
            return $row['fact'] * self::ROUNDING_FEW_VALUE;
        } else {
            return $row['fact'];
        }
    }

    private function getCountOfFonds($status, $type)
    {

        $data = $this->getDataByType(new FondsForKGM);
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if (($row['type'] == $type) && ($row['status'] == $status)) {
                $summ[] = array_merge($row);
            }
        }
        return count($summ);
    }

    private function getCountByDowntimeWells($data, $fieldName)
    {
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if (($row['type'] == $fieldName)
                && ($row['category2'] == 'Исследование')) {
                $summ[] = array_merge($row);
            }
        }
        return count($summ);
    }

    private function getOilAndGas($fieldName)
    {
        $oilAndGas = $this->getDataByType(new OilAndGasForKGM);
        $data = 0;
        foreach ($oilAndGas as $rowNum => $row) {
            $data += $row[$fieldName];
        }
        return $data;
    }

    private function getFieldsInjection($fieldsMapping,$dzoImportFieldData, $groupOfFieldNames)
    {
        foreach ($fieldsMapping as $field_name => $field) {

            if ($groupOfFieldNames == 'dzo_import_field_data') {
                $dzoImportFieldData->$field_name = $this->getCountOfFonds($field, 'INJECTION');
            }

            if ($groupOfFieldNames == 'SHUT_IN_downtimeReason') {
                $dzoImportFieldData->$field_name = $this->getCountOfFonds('SHUT_IN', 'INJECTION');
            }
        }
        return $dzoImportFieldData;
    }

    private function getFields($fieldsMapping, $dzoImportFieldData, $groupOfFieldNames)
    {
        foreach ($fieldsMapping as $field_name => $field) {

            if ($groupOfFieldNames == 'getWaterOilDeliveryAndGasMore') {
                $dzoImportFieldData->$field_name = $this->getWaterOilDeliveryAndGasMore($field);
            }
            if ($groupOfFieldNames == 'dzo_import_field_data') {
                $dzoImportFieldData->$field_name = $this->getCountOfFonds($field, 'PRODUCTION');
            }
            if (($groupOfFieldNames == 'SHUT_IN') || ($groupOfFieldNames == 'SHUT_IN_downtimeReason')) {
                $dzoImportFieldData->$field_name = $this->getCountOfFonds('SHUT_IN', 'PRODUCTION');
            }
        }

        return $dzoImportFieldData;
    }

    private function saveKGMReportsFromAvocetByDay($dzoImportFieldData, $dzoImportFieldDowntimeReason)
    {
        $lastDataOil = $dzoImportFieldData
            ->where('dzo_name', '=', self::DZO_NAME)
            ->where('date', '=', $this->yesterdayDate)
            ->get()->toArray();

        if (count($lastDataOil) === 0) {
            $dzoImportFieldData->save();
            $dzoImportFieldDowntimeReason->dzo_import_data_id = $this->lastRecordKGM();
            $dzoImportFieldDowntimeReason->save();
            echo "Data haven't been written";
            return;
        }

        $lastDataOil = $lastDataOil[0];
        if (($lastDataOil['dzo_name'] != self::DZO_NAME) || ($lastDataOil['date'] != $this->yesterdayDate)) {
            return;
        } 
        
        if (($lastDataOil['oil_production_fact'] != 0) || ($lastDataOil['oil_delivery_fact'] != 0)) {
            echo "No update needed";
            return;
        }

        $dzoImportFieldData
            ->where('dzo_name', '=', self::DZO_NAME)
            ->where('date', '=', $this->yesterdayDate)->update($dzoImportFieldData->getAttributes());

        unset($dzoImportFieldDowntimeReason['dzo_import_data_id']);
        $dzoImportFieldDowntimeReason
            ->where('dzo_import_data_id', '=', $lastDataOil['id'])
            ->update($dzoImportFieldDowntimeReason->getAttributes());
            echo "Data have been update";
        }

    public function handle()
    {
        $this->storeKGMReportsFromAvocetByDay();
    }
}
