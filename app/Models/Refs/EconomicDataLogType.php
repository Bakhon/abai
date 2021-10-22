<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EconomicDataLogType extends Model
{
    const COST = 1;

    const GTM = 2;

    const WELL_FORECAST = 3;

    public static function ids(): array
    {
        return [
            self::COST,
            self::GTM,
            self::WELL_FORECAST,
        ];
    }

    public function logs()
    {
        return $this->hasMany(EconomicDataLog::class, 'type_id');
    }
}
