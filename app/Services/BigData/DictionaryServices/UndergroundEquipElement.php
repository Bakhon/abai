<?php


namespace App\Services\BigData\DictionaryServices;

use Illuminate\Support\Facades\DB;

class UndergroundEquipElement
{
    public static function getDict()
    {
        return DB::connection('tbd')
            ->table('dict.equip')
            ->select('id', 'vendor_code as name')
            ->get()
            ->toArray();
    }
}    