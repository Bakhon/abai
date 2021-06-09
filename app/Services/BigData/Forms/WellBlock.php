<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WellBlock extends PlainForm
{
    protected $configurationFileName = 'well_block';

    public function calcFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_block as wb')
            ->select('b.name_ru as block')
            ->where('wb.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wb.well', $wellId)
            ->leftJoin('dict.block as b', 'b.id', 'wb.block')
            ->orderBy('wb.dbeg', 'desc')
            ->limit(1)
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'current_block' => $result->block
        ];
    }
}