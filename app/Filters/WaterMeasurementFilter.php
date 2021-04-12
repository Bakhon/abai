<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class WaterMeasurementFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'other_objects':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('other_objects', 'other_objects.id', '=', 'water_measurements.other_objects_id')
                ->orderBy('other_objects.name', $desc ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('gus', 'gus.id', '=', 'water_measurements.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('zus', 'zus.id', '=', 'water_measurements.zu_id')
                ->orderBy('zus.name', $desc ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', 'water_measurements.ngdu_id')
                ->orderBy('ngdus.name', $desc ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', 'water_measurements.cdng_id')
                ->orderBy('cdngs.name', $desc ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('wells', 'wells.id', '=', 'water_measurements.well_id')
                ->orderBy('wells.name', $desc ? 'desc' : 'asc');
                break;
            case 'water_type_by_sulin':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('water_type_by_sulins', 'water_type_by_sulins.id', '=', 'water_measurements.water_type_by_sulin_id')
                ->orderBy('water_type_by_sulins.name', $desc ? 'desc' : 'asc');
                break;
            case 'sulphate_reducing_bacteria':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('sulphate_reducing_bacterias', 'sulphate_reducing_bacterias.id', '=', 'water_measurements.sulphate_reducing_bacteria_id')
                ->orderBy('sulphate_reducing_bacterias.name', $desc ? 'desc' : 'asc');
                break;
            case 'hydrocarbon_oxidizing_bacteria':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('hydrocarbon_oxidizing_bacterias', 'hydrocarbon_oxidizing_bacterias.id', '=', 'water_measurements.hydrocarbon_oxidizing_bacteria_id')
                ->orderBy('hydrocarbon_oxidizing_bacterias.name', $desc ? 'desc' : 'asc');
                break;
            case 'thionic_bacteria':
                $this->query
                ->select('water_measurements.*')
                ->leftJoin('thionic_bacterias', 'thionic_bacterias.id', '=', 'water_measurements.thionic_bacteria_id')
                ->orderBy('thionic_bacterias.name', $desc ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc ? 'desc' : 'asc');
        }
    }

}
