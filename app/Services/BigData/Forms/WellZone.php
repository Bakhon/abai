<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WellZone extends PlainForm
{
    protected $configurationFileName = 'well_zone';

    public function calcFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_zone as wz')
            ->select('z.name_ru as zone')
            ->where('wz.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wz.well', $wellId)
            ->leftJoin('dict.zone as z', 'z.id', 'wz.zone')
            ->orderBy('wz.dbeg', 'desc')
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'old_zone' => $result->zone
        ];
    }
}