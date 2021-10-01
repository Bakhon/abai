<?php


namespace App\Services\BigData\DictionaryServices;

use Illuminate\Support\Facades\DB;

class UndergroundEquipElement
{
    public static function getDict()
    {
        $result = [];
        $elements = DB::connection('tbd')
            ->table('dict.equip_element')
            ->get();

        $params = DB::connection('tbd')
            ->table('dict.equip_element_param as p')
            ->select('p.element', 'p.value_string', 'p.value_double', 'm.name_ru')
            ->join('dict.metric as m', 'p.metric', 'm.id')
            ->whereIn('p.element', $elements->pluck('id')->toArray())
            ->get();

        foreach ($elements as $element) {
            $elementParams = $params->where('element', $element->id)
                ->map(function ($param) {
                    return $param->name_ru . ': ' . ($param->value_string ?? $param->value_double);
                })
                ->join(', ');
            $result[] = [
                'id' => $element->id,
                'name' => $elementParams
            ];
        }
        return $result;
    }
}    