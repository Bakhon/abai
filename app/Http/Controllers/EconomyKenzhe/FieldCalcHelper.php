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

    public static function sumOverTree(&$items, $year, &$parent = null)
    {
        if(is_array($items)){
            foreach ($items as &$item){
                if(count($item['handbook_items'])> 0){
                    $item['handbook_items'] = self::sumOverTree($item['handbook_items'], $year, $item);
                }
                if($parent != null){
                    $values = array_column($parent['handbook_items'], 'plan_value');
                    foreach ($values as $value){
                        if($value[$year]<0){
                            $value[$year] = $value[$year]* -1;
                        }
                        $parent['plan_value'][$year] += $value[$year];
                    }
                }
            }
            return $items;
        }

    }

    public static function getShowDataOnTree($names, &$values, &$result = []){
        if(is_array($values)){
            foreach ($values as $value){
                if(count($value['handbook_items'])>0){
                    $result = self::getShowDataOnTree($names, $value['handbook_items'], $result);
                }
                if(in_array($value['num'], $names)){
                    $result[] = $value;
                }
            }
            return $result;
        }

    }

}