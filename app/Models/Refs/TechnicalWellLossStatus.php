<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalWellLossStatus extends Model
{
    protected $fillable = ['name', 'user_id'];

    const NRS = 1;

    const CRF = 2;

    const OPEK = 3;

    const DEOPTIMIZATION = 4;

    const DOWNLOAD_LIMIT = 5;

    public static function factualIds(): array
    {
        return [
            self::NRS,
            self::CRF,
            self::OPEK,
        ];
    }
}
