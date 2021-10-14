<?php


namespace App\Services\BigData\DictionaryServices;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GisTypeForm
{
    public static function getMethodDict()
    {
        $result = [];
        $parentCode = 'UNDR';
        $equipTypes = DB::connection('tbd')
            ->table('dict.equip_type')
            ->get();
        $parent = $equipTypes->where('code', $parentCode)->first();

        if (empty($parent)) {
            return $result;
        }

        $result = self::addChildren($equipTypes, $parent);
        usort($result, function ($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        return $result;
    }

    private static function addChildren(Collection $equipTypes, \stdClass $parent): array
    {
        $result = [];
        $children = $equipTypes->where('parent', $parent->id);
        foreach ($children as $child) {
            if ($equipTypes->where('parent', $child->id)->isNotEmpty()) {
                $result = array_merge($result, self::addChildren($equipTypes, $child));
                continue;
            }

            $result[] = [
                'id' => $child->id,
                'name' => $child->name_ru,
            ];
        }
        return $result;
    }
}    