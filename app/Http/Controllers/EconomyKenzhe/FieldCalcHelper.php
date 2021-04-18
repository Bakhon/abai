<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EcoRefsMacro;

class FieldCalcHelper{

    public static function getBarrelWorldPrice(){
        $data = [];
        $factValues = EcoRefsMacro::whereScFa(1)->get()->toArray();
        $data['averageBarrelPrice'] = self::getAverage($factValues, 'barrel_world_price');
        $data['averageDollarRate'] = self::getAverage($factValues, 'ex_rate_dol');
        $data['averageRubRate'] = self::getAverage($factValues, 'ex_rate_rub');
        return $data;
    }

    public static function getAverage($factValues, $attribute){
        return array_sum(array_column($factValues, $attribute))/12;
    }
}