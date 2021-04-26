<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EcoRefsMacro;

class FieldCalcHelper
{

    public static function getBarrelWorldPrice($scenario_fact)
    {
        $data = [];
        $factValues = EcoRefsMacro::whereScFa($scenario_fact)->get()->toArray();
        $data['averageBarrelPrice'] = self::getAverage($factValues, 'barrel_world_price');
        $data['averageDollarRate'] = self::getAverage($factValues, 'ex_rate_dol');
        $data['averageRubRate'] = self::getAverage($factValues, 'ex_rate_rub');
        return $data;
    }

    public static function getAverage($factValues, $attribute)
    {
        return array_sum(array_column($factValues, $attribute)) / 12;
    }

    public static function sumOverTree($arr, $year)
    {
//        array_reduce($arr, 'recursive', $year);
        $result = Array();
        array_walk($array, function ($item, $key) use ($arr, $year, &$result) {
            $hasChild = count($item['handbook_items'])>0;
            $yearValue = $item['plan_value'][$year];
            if($yearValue<0){
                $item['plan_value'][$year] = $yearValue * -1;
            }
            if($hasChild){
                $item['plan_value'][$year] = self::sumOverTree($item['handbook_items'], 'recursive', $year);
            }
            return $item['plan_value'][$year];
        });

        return $result;
    }

    public function recursive($year, $item, $accumulator){
        $hasChild = count($item['handbook_items'])>0;
        $yearValue = $item['plan_value'][$year];
        if($yearValue<0){
            $item['plan_value'][$year] = $yearValue * -1;
        }
        if($hasChild){
            $item['plan_value'][$year] = array_reduce($item['handbook_items'], 'recursive', $year);
        }
        return $accumulator + $item['plan_value'][$year];
    }

//    public static function sumOverTree(&$arr, $year)
//    {
////        array_reduce($arr, 'recursive', $year);
//        $sum = 0;
//        foreach ($arr as $v) {
//            if (is_array($v)) {
//                $sum += sumOverTree($v);
//            } elseif (is_integer($v)) {
//                $sum += $v;
//            }
//        }
//        return $sum;
//    }


//    function array_walk_recursive_rewrite(array $data) {
//        $sum = 0;
//        foreach ($data as $v) {
//            if (is_array($v)) {
//                $sum += array_walk_recursive_rewrite($v);
//            } elseif (is_integer($v)) {
//                $sum += $v;
//            }
//        }
//        return $sum;
//    }





//    public static function sumOverTree(&$arr, $year)
//    {
//        array_reduce($arr, function($accumulator, $item) use ($year){
//            $hasChild = count($item['handbook_items'])>0;
//            $yearValue = $item['plan_value'][$year];
//            if($yearValue<0){
//                $item['plan_value'][$year] = $yearValue * -1;
//            }
//            if($hasChild){
//                $item['plan_value'][$year] = ;
//            }
//            return $accumulator + $item['plan_value'][$year];
//        });
//    }

}