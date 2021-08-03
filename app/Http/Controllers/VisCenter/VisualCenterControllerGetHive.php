<?php

namespace App\Http\Controllers\VisCenter;

use App\Http\Controllers\Controller;
use App\Models\VisCenter\DataForKGM\Daily\FondsForKGM;
use App\Models\VisCenter\DataForKGM\Daily\GasForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilAndGasForKGM;
use App\Models\VisCenter\DataForKGM\Daily\OilDeliveryForKGM;
use App\Models\VisCenter\DataForKGM\Daily\WaterForKGM;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use Carbon\Carbon;

class VisualCenterControllerGetHive extends Controller
{
    public function storeKGMReportsFromAvocetByDay()
    {
        $path = resource_path() . "/js/components/visualcenter3/dailyReportImport/fields_kgm_reports_mapping.json";
        $fields_data = json_decode(file_get_contents($path), true);
        $dzo_summary_last_record = DzoImportData::latest('id')->first();
        $date = Carbon::yesterday();
        $dzo_import_field_data = new DzoImportData();
        $multiplier = 1000;
        $fondsModel = new FondsForKGM;
        $this->getFilds($fields_data['getWaterOilDeliveryAndGasMore'], $dzo_import_field_data, 'getWaterOilDeliveryAndGasMore', $date, $multiplier);

        $dzo_import_field_data->date = $date;
        $dzo_import_field_data->dzo_name = 'КГМ';
        $dzo_import_field_data->oil_production_fact = $this->getOilAndGas('fact_oil_mass', $date);
        $dzo_import_field_data->associated_gas_production_fact = $this->getOilAndGas('fact_gas_vol', $date) * $multiplier;
        $dzo_import_field_data->stock_of_goods_delivery_fact = $dzo_import_field_data['ASY_D'] + $dzo_import_field_data['AKSH_D'] + $dzo_import_field_data['NUR_D'];
        unset($dzo_import_field_data['ASY_D']);
        unset($dzo_import_field_data['AKSH_D']);
        unset($dzo_import_field_data['NUR_D']);
        $dzo_import_field_data->otm_well_workover_fact = count($fondsModel::query()->select('*')
                ->WHERE('start_datetime', 'LIKE', $date . '%')
                ->WHERE('status', 'SHUT_IN')
                ->WHERE('cattegory_code', 'P_WORK_W_2')
                ->get()->toArray());

        $downtimeReason = new DzoImportDowntimeReason();

        $fonds = $this->getDataFromBD($fondsModel, $date);
        $downtimeReason->well_survey_downtime_production_wells_count = $this->getCountByDowntimeWells($fonds, 'PRODUCTION');
        $downtimeReason->well_survey_downtime_injection_wells_count = $this->getCountByDowntimeWells($fonds, 'INJECTION');

        if (isset($fields_data['production_fond']['head'])) {
            $this->getFilds($fields_data['production_fond']['head'], $dzo_import_field_data, 'head', $date, '');
        }
        if (isset($fields_data['injection_fond']['head'])) {
            $this->getFildsInjection($fields_data['injection_fond']['head'], $dzo_import_field_data, 'head', $date, '');
        }
        if (isset($fields_data['production_fond']['SHUT_IN'])) {
            $this->getFilds($fields_data['production_fond']['SHUT_IN'], $dzo_import_field_data, 'SHUT_IN', $date, '');
        }

        $dzo_import_field_data->operating_production_fond = $dzo_import_field_data['in_work_production_fond'] + $dzo_import_field_data['in_idle_production_fond'] + $dzo_import_field_data['developing_production_fond'] + $dzo_import_field_data['inactive_injection_fond'];
        $dzo_import_field_data->active_production_fond = $dzo_import_field_data['in_work_production_fond'] + $dzo_import_field_data['in_idle_production_fond'];
        $dzo_import_field_data->operating_injection_fond = $dzo_import_field_data['in_work_injection_fond'] + $dzo_import_field_data['in_idle_injection_fond'] + $dzo_import_field_data['developing_injection_fond'] + $dzo_import_field_data['inactive_injection_fond'];
        $dzo_import_field_data->active_injection_fond = $dzo_import_field_data['in_work_injection_fond'] + $dzo_import_field_data['in_idle_injection_fond'];

        $downtimeReason->dzo_import_data_id = $dzo_summary_last_record['id'] + 1;

        if (isset($fields_data['production_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFilds($fields_data['production_fond']['SHUT_IN_downtimeReason'], $downtimeReason, 'SHUT_IN_downtimeReason', $date, '');
        }

        if (isset($fields_data['injection_fond']['SHUT_IN_downtimeReason'])) {
            $this->getFildsInjection($fields_data['injection_fond']['SHUT_IN_downtimeReason'], $downtimeReason, 'SHUT_IN_downtimeReason', $date, '');
        }

        $lastDataOil = $dzo_import_field_data
            ->where('dzo_name', '=', 'КГМ')
            ->where('date', '=', $date)
            ->get()->toArray();
        $lastDataOil = $lastDataOil[0];

        $dzo_import_field_data->oil_delivery_by_stations_fact = '588';

        if (count($lastDataOil) === 0) {
            $dzo_import_field_data->save();
            $downtimeReason->save();
            echo "Data haven't been written";
        } else {
            echo "Data have been written, check production and delivery oil";
            if (($lastDataOil['dzo_name'] == 'КГМ') && ($lastDataOil['date'] == $date)) {
                if (($lastDataOil['oil_production_fact'] === 0.00000000) or ($lastDataOil['oil_delivery_fact'] === 0.00000000)) {
                    $dzo_import_field_data
                        ->where('dzo_name', '=', 'КГМ')
                        ->where('date', '=', $date)->update($dzo_import_field_data->getAttributes());

                    $downtimeReason
                        ->where('dzo_import_data_id', '=', $lastDataOil['id'])
                        ->update($downtimeReason->getAttributes());
                    echo "Data have been update";
                } else {echo "No update needed";}
            }
        }

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
            $data = $this->getDataFromBD(new GasForKGM, $date);} elseif ($column1 == "KGM_UTIL") {
            $data = $this->getDataFromBD(new GasForKGM, $date);}

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

                    if ($row['cattegory_code'] == null) {
                        if ($row['cattegory_code'] == $column3) {
                            $summ[] = array_merge($row);}
                    } else { $summ[] = array_merge($row);}
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

    public function getFildsInjection($fields_data, $dzo_import_field_data, $function, $date, $multiplier)
    {

        foreach ($fields_data as $field_name => $field) {

            if ($function == 'head') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray($field, 'INJECTION', '', $date);
            }

            if ($function == 'SHUT_IN_downtimeReason') {
                $dzo_import_field_data->$field_name = $this->quantityOfArray('SHUT_IN', 'INJECTION', $field, $date);
            }
        }
        return $dzo_import_field_data;
    }

    public function getFilds($fields_data, $dzo_import_field_data, $function, $date, $multiplier)
    {

        foreach ($fields_data as $field_name => $field) {

            if ($function == 'getWaterOilDeliveryAndGasMore') {
                $dzo_import_field_data->$field_name = $this->getWaterOilDeliveryAndGasMore($field, $date, $multiplier);
            }
            if ($function == 'head') {
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

}
