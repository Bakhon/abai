<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EconomicDataLogType extends Model
{
    const COST = 1;

    const GTM = 2;

    const WELL_FORECAST = 3;

    const ANALYSIS_PARAM = 4;

    public static function ids(): array
    {
        return [
            self::COST,
            self::GTM,
            self::WELL_FORECAST,
            self::ANALYSIS_PARAM,
        ];
    }

    public function logs()
    {
        return $this->hasMany(EconomicDataLog::class, 'type_id');
    }
}
