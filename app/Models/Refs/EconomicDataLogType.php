<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EconomicDataLogType extends Model
{
    const COST = 1;

    const GTM = 2;

    const GTM_VALUE = 3;

    public static function ids(): array
    {
        return [
            self::COST,
            self::GTM,
            self::GTM_VALUE,
        ];
    }

    public function logs()
    {
        return $this->hasMany(EconomicDataLog::class, 'type_id');
    }
}
