<?php

namespace App\Console\Commands;

use App\Models\VisCenter\DataForKGM\Daily\FondsForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilAndGasForKGM;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreKGMReportsFromAvocetByDay extends Command
{

    protected $signature = 'store-kgm-reports-from-avocet:cron';

    public function storeKGMReportsFromAvocetByDay()
    {
        $path = resource_path() . "/js/components/visualcenter3/dailyReportImport/fields_kgm_reports_mapping.json";
        $fields_json_data = json_decode(file_get_contents($path), true);
        $dzo_summary_last_record = DzoImportData::latest('id')->whereNull('is_corrected')->first();
        $date = Carbon::yesterday();
        $dzo_import_field_data = new DzoImportData();
        $fondsModel = new FondsForKGM;
        $downtimeReason = new DzoImportDowntimeReason();
        $this->getDzoImportFieldData($fields_json_data, $dzo_import_field_data, $date, $fondsModel);
        $this->getDowntimeReasonFields($fields_json_data, $downtimeReason, $date, $fondsModel, $dzo_summary_last_record);
        $this->saveKGMReportsFromAvocetByDay($dzo_import_field_data, $downtimeReason, $date);
    }

    private function getDzoImportFieldData($fields_json_data, $dzo_import_field_data, $date, $fondsModel)
    {

        $multiplier = 1000;
        $this->getFields($fields_json_data['getWaterOilDeliveryAndGasMore'], $dzo_import_field_data, 'getWaterOilDeliveryAndGasMore', $date, $multiplier);

        $dzo_import_field_data->date = $date;
        $dzo_import_field_data->dzo_name = 'КГМ';
        $dzo_import_field_data->oil_production_fact = $this->getOilAndGas('fact_oil_mass', $date);
        $dzo_import_field_data->associated_gas_production_fact = $this->getOilAndGas('fact_gas_vol', $date) * $multiplier;
        $dzo_import_field_data->stock_of_goods_delivery_fact = $dzo_import_field_data['ASY_D'] + $dzo_import_field_data['AKSH_D'] + $dzo_import_field_data['NUR_D'];
        unset($dzo_import_field_data['ASY_D']);
        unset($dzo_import_field_data['AKSH_D']);
        unset($dzo_import_field_data['NUR_D']);

        $this->getWellsWorkover($dzo_import_field_data, $fondsModel, $date);

        if (isset($fields_json_data['production_fond']['dzo_import_field_data'])) {
            $this->getFields($fields_json_data['production_fond']['dzo_import_field_data'], $dzo_import_field_data, 'dzo_import_field_data', $date, '');
        }
        if (isset($fields_json_data['injection_fond']['dzo_import_field_data'])) {
            $this->getFieldsInjection($fields_json_data['injection_fond']['dzo_import_field_data'], $dzo_import_field_data, 'dzo_import_field_data', $date, '');
        }
        if (isset($fields_json_data['production_fond']['SHUT_IN'])) {
            $this->getFields($fields_json_data['production_fond']['SHUT_IN'], $dzo_import_field_data, 'SHUT_IN', $date, '');
        }

        $dzo_import_field_data->operating_production_fond = $dzo_import_field_data['in_work_production_fond'] + $dzo_import_field_data['in_idle_production_fond'] + $dzo_import_field_data['developing_production_fond'] + $dzo_import_field_data['inactive_injection_fond'];
        $dzo_import_field_data->active_production_fond = $dzo_import_field_data['in_work_production_fond'] + $dzo_import_field_data['in_idle_production_fond'];
        $dzo_import_field_data->operating_injection_fond = $dzo_import_field_data['in_work_injection_fond'] + $dzo_import_field_data['in_idle_injection_fond'] + $dzo_import_field_data['developing_injection_fond'] + $dzo_import_field_data['inactive_injection_fond'];
        $dzo_import_field_data->active_injection_fond = $dzo_import_field_data['in_work_injection_fond'] + $dzo_import_field_data['in_idle_injection_fond'];

        return $dzo_import_field_data;
    }

    private function getWellsWorkover($dzo_import_field_data, $fondsModel, $date)
    {
        $dzo_import_field_data->otm_well_workover_fact = count($fondsModel::query()->select('*')
                ->WHERE('start_datetime', 'LIKE', $date . '%')
                ->WHERE('status', 'SHUT_IN')
                ->WHERE('cattegory_code', 'P_WORK_W_2')
                ->get()->toArray());

        return $dzo_import_field_data;
    }

    private function getDowntimeReasonFields($fields_json_data, $downtimeReason, $date, $fondsModel, $dzo_summary_last_record)
    {
        $fonds = $this->getDataFromBD($fondsModel, $date);
        $downtimeReason->well_survey_downtime_production_wells_count = $this->getCountByDowntimeWells($fonds, 'PRODUCTION');
        $downtimeReason->well_survey_downtime_injection_wells_count = $this->getCountByDowntimeWells($fonds, 'INJECTION');
        $downtimeReason->dzo_import_data_id = $dzo_summary_last_record['id'] + 1;

        if (isset($fields_json_data['production_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFields($fields_json_data['production_fond']['SHUT_IN_downtimeReason'], $downtimeReason, 'SHUT_IN_downtimeReason', $date, '');
        }

        if (isset($fields_json_data['injection_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFieldsInjection($fields_json_data['injection_fond']['SHUT_IN_downtimeReason'], $downtimeReason, 'SHUT_IN_downtimeReason', $date, '');
        }
        return $downtimeReason;
    }

    private function getDataFromBD($nameData, $date)
    {
        return $nameData::query()->select('*')
            ->WHERE('start_datetime', 'LIKE', $date . '%')
            ->get()->toArray();
    }

    private function getWaterOilDeliveryAndGasMore($column1, $date, $multiplier)
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
        $pathOfClasses = "\App\Models\VisCenter\DataForKGM\Daily";
        foreach ($column_names as $key => $value) {
            if ($column1 == $key) {
                $class = $pathOfClasses . "\\" . $value;
                $data = $this->getDataFromBD(new $class, $date);

                if (empty($data)) {
                    continue;
                }
                foreach ($data as $rowNum => $row) {
                    if ($row['legacy_id'] == $column1) {
                        if (($column1 == 'KGM_INJ_TOTAL') || ($column1 == 'KGM_TRANS') || ($column1 == 'KGM_UTIL')) {
                            return $row['fact'] * $multiplier;
                        } else {
                            return $row['fact'];
                        }
                    }
                }
            }
        }
    }

    private function quantityOfArray($status, $type, $cattegory_code, $date)
    {

        $data = $this->getDataFromBD(new FondsForKGM, $date);
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if (($row['type'] == $type) && ($row['status'] == $status)) {
                if (($row['cattegory_code'] == null) && ($row['cattegory_code'] == $cattegory_code)) {
                    $summ[] = array_merge($row);
                } 
            }
        }
        return count($summ);
    }

    private function getCountByDowntimeWells($data, $column1)
    {
        $summ = [];

        foreach ($data as $rowNum => $row) {
            if (($row['type'] == $column1)
                && ($row['category2'] == 'Исследование')) {
                $summ[] = array_merge($row);
            }
        }
        return count($summ);
    }

    private function getOilAndGas($column1, $date)
    {
        $oilAndGas = $this->getDataFromBD(new OilAndGasForKGM, $date);
        $data = 0;
        foreach ($oilAndGas as $rowNum => $row) {
            $data += $row[$column1];
        }
        return $data;
    }

    private function getFieldsInjection($fields_json_data, $dzo_import_field_data, $function, $date, $multiplier)
    {

        foreach ($fields_json_data as $field_name => $field) {

            if ($function == 'dzo_import_field_data') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray($field, 'INJECTION', '', $date);
            }

            if ($function == 'SHUT_IN_downtimeReason') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray('SHUT_IN', 'INJECTION', $field, $date);
            }
        }
        return $dzo_import_field_data;
    }

    private function getFields($fields_json_data, $dzo_import_field_data, $function, $date, $multiplier)
    {

        foreach ($fields_json_data as $field_name => $field) {

            if ($function == 'getWaterOilDeliveryAndGasMore') {
                $dzo_import_field_data->$field_name = $this->getWaterOilDeliveryAndGasMore($field, $date, $multiplier);
            }
            if ($function == 'dzo_import_field_data') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray($field, 'PRODUCTION', '', $date);
            }
            if ($function == 'SHUT_IN') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray('SHUT_IN', 'PRODUCTION', $field, $date);
            }

            if ($function == 'SHUT_IN_downtimeReason') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray('SHUT_IN', 'PRODUCTION', $field, $date);
            }

        }
        return $dzo_import_field_data;
    }

    private function saveKGMReportsFromAvocetByDay($dzo_import_field_data, $downtimeReason, $date)
    {
        $lastDataOil = $dzo_import_field_data
            ->where('dzo_name', '=', 'КГМ')
            ->where('date', '=', $date)
            ->get()->toArray();

        if (count($lastDataOil) === 0) {
            $dzo_import_field_data->save();
            $downtimeReason->save();
            echo "Data haven't been written";
            return;
        }

        $lastDataOil = $lastDataOil[0];
        if (($lastDataOil['dzo_name'] != 'КГМ') || ($lastDataOil['date'] != $date)) {
            return;
        } 
        
        if (($lastDataOil['oil_production_fact'] != 0) || ($lastDataOil['oil_delivery_fact'] != 0)) {
            echo "No update needed";
            return;
        }

        $dzo_import_field_data
            ->where('dzo_name', '=', 'КГМ')
            ->where('date', '=', $date)->update($dzo_import_field_data->getAttributes());

        unset($downtimeReason['dzo_import_data_id']);
        $downtimeReason
            ->where('dzo_import_data_id', '=', $lastDataOil['id'])
            ->update($downtimeReason->getAttributes());
            echo "Data have been update";        
         }

    public function handle()
    {
        $this->storeKGMReportsFromAvocetByDay();
    }
}
