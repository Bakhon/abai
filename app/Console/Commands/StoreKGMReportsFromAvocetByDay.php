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

    private function getlastRecord()
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
        $dzoImportFieldFonds = new FondsForKGM;
        $dzoImportFieldData = $this->getDzoImportFieldData($dzoImportFieldFonds);
        $dzoImportFieldDowntimeReason = $this->getDowntimeReasonFields($dzoImportFieldFonds);
        $this->saveKGMReportsFromAvocetByDay($dzoImportFieldData, $dzoImportFieldDowntimeReason);
    }

    private function getDzoImportFieldData($dzoImportFieldFonds)
    {
        $dzoImportFieldData = new DzoImportData();
        $this->updateFields($this->fieldsMapping['getWaterOilDeliveryAndGasMore'], $dzoImportFieldData, 'getWaterOilDeliveryAndGasMore');

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
            ['updateFields','production_fond','dzo_import_field_data','dzo_import_field_data'],
            ['updateFields','production_fond','SHUT_IN','SHUT_IN'],
            ['updateFieldsInjection','injection_fond','dzo_import_field_data','dzo_import_field_data']
        ]; 

        for ($i = 0; $i < 3; $i++) {
            $functionName = $fieldForFilter[$i][0];
            $fondName = $this->fieldsMapping[$fieldForFilter[$i][1]];
            $groupOfFields =$fondName[$fieldForFilter[$i][2]];
            $this->$functionName($groupOfFields, $dzoImportFieldData, $fieldForFilter[$i][3], '');
        }

        $fieldsForSumFond["operating_production_fond"] = ['in_work_production_fond','in_idle_production_fond','developing_production_fond','inactive_injection_fond'];
        $fieldsForSumFond["active_production_fond"] = ['in_work_production_fond','in_idle_production_fond'];
        $fieldsForSumFond["operating_injection_fond"] = ['in_work_injection_fond','in_idle_injection_fond','developing_injection_fond','inactive_injection_fond'];
        $fieldsForSumFond["active_injection_fond"] = ['in_work_injection_fond','in_idle_injection_fond'];

        $filter=[];
        foreach ($dzoImportFieldData->getAttributes() as $fondsAllFieldsName => $valueFond) {
            foreach ($fieldsForSumFond as $groupNameOfFonds => $fieldNameInGroupNameOfFondsArray) {
                foreach ($fieldNameInGroupNameOfFondsArray as $key => $fieldNameInGroupNameOfFonds) {                    
                    if ($fondsAllFieldsName==$fieldNameInGroupNameOfFonds) {
                        $filter[$groupNameOfFonds][$fondsAllFieldsName] = $valueFond;
                        $dzoImportFieldData->$groupNameOfFonds = array_sum($filter[$groupNameOfFonds]);
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

    private function getDowntimeReasonFields($dzoImportFieldFonds)
    {
        $dzoImportFieldDowntimeReason = new DzoImportDowntimeReason();
        $dzoImportFieldDowntimeReason->well_survey_downtime_production_wells_count = $this->getCountBy('category2', 'Исследование', 'PRODUCTION');
        $dzoImportFieldDowntimeReason->well_survey_downtime_injection_wells_count = $this->getCountBy('category2', 'Исследование', 'INJECTION');        

        if (isset($this->fieldsMapping['production_fond']['SHUT_IN_downtimeReason'])) {
            $this->updateFields($this->fieldsMapping['production_fond']['SHUT_IN_downtimeReason'], $dzoImportFieldDowntimeReason, 'SHUT_IN_downtimeReason', '');
        }

        if (isset($this->fieldsMapping['injection_fond']['SHUT_IN_downtimeReason'])) {
            $this->updateFieldsInjection($this->fieldsMapping['injection_fond']['SHUT_IN_downtimeReason'], $dzoImportFieldDowntimeReason, 'SHUT_IN_downtimeReason', '');
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

    private function getCountBy($fieldKey, $status, $type)
    {   $data = $this->getDataByType(new FondsForKGM);
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if (($row['type'] == $type)
                && ($row[$fieldKey] == $status)) {
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

    private function updateFieldsInjection($fieldsMapping,$dzoImportFieldData, $groupOfFieldNames)
    {
        foreach ($fieldsMapping as $field_name => $field) {

            if ($groupOfFieldNames == 'dzo_import_field_data') {
                $dzoImportFieldData->$field_name = $this->getCountBy('status', $field, 'INJECTION');
            }

            if ($groupOfFieldNames == 'SHUT_IN_downtimeReason') {
                $dzoImportFieldData->$field_name = $this->getCountBy('status', 'SHUT_IN', 'INJECTION');
            }
        }
    }

    private function updateFields($fieldsMapping, $dzoImportFieldData, $groupOfFieldNames)
    {
        foreach ($fieldsMapping as $field_name => $field) {

            if ($groupOfFieldNames == 'getWaterOilDeliveryAndGasMore') {
                $dzoImportFieldData->$field_name = $this->getWaterOilDeliveryAndGasMore($field);
            }
            if ($groupOfFieldNames == 'dzo_import_field_data') {
                $dzoImportFieldData->$field_name = $this->getCountBy('status', $field, 'PRODUCTION');
            }
            if (($groupOfFieldNames == 'SHUT_IN') || ($groupOfFieldNames == 'SHUT_IN_downtimeReason')) {
                $dzoImportFieldData->$field_name = $this->getCountBy('status', 'SHUT_IN', 'PRODUCTION');
            }
        }
    }

    private function saveKGMReportsFromAvocetByDay($dzoImportFieldData, $dzoImportFieldDowntimeReason)
    {
        $lastDataOil = $dzoImportFieldData
            ->where('dzo_name', '=', self::DZO_NAME)
            ->where('date', '=', $this->yesterdayDate)
            ->get()->toArray();
            

        if (count($lastDataOil) === 0) {
            $dzoImportFieldData->save();
            $dzoImportFieldDowntimeReason->dzo_import_data_id = $this->getlastRecord();
            $dzoImportFieldDowntimeReason->save();
            echo "Data haven't been written";
            return;
        }

        $lastDataOil = $lastDataOil[0];
        if (($lastDataOil['dzo_name'] != self::DZO_NAME) || ($lastDataOil['date'] != $this->yesterdayDate)) {
            return;
        } 
        
        if (($lastDataOil['oil_production_fact'] != 0) && ($lastDataOil['oil_delivery_fact'] != 0)) {
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
